<?php

namespace Asadbek\Eimzo\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;


class EimzoService
{
    private $eimzo_server;

    public function __construct()
    {
        $this->eimzo_server = config('eimzo.dsv_server_url');
    }

    public function getSigners($pkcs7)
    {
        $signers = array();
        if ($pkcs7 && (!empty($pkcs7))) {
            $xml = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">    <Body><verifyPkcs7 xmlns="http://v1.pkcs7.plugin.server.dsv.eimzo.yt.uz/"><pkcs7B64 xmlns="">' . $pkcs7 . '</pkcs7B64> </verifyPkcs7></Body></Envelope>';
            $url = $this->eimzo_server;
            $client = new CurlRequest();
            $responseBody = ($client->request($url, $xml));
            if (!$responseBody) {
                return false;
            }
            $signers = array();
            preg_match("/<return>(.*)<\/return>/Uis", $responseBody, $matches);
            if (Arr::get($matches, 0) === '<return></return>') {
                return response()->json([
                    'message' => 'Verification server return no data'
                ], 400);
            } else {
                $xml = simplexml_load_string(Arr::get($matches, 0));
                $answer = json_decode(json_encode((array)$xml), true);
                $answer = (array)json_decode(Arr::get($answer, 0), true);
                $answer = json_decode(json_encode((array)$answer), true);
                $pkcs7info = Arr::get($answer, 'pkcs7Info');
                $allSigners = Arr::get($pkcs7info, 'signers');
                foreach ($allSigners as $signer) {
                    $signers[] = ($signer["certificate"][0]["serialNumber"]);
                }
            }
        }

        return $signers;
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function getStir($subject)
    {
        $arr = explode(',', $subject);
        $stir = "";
        foreach ($arr as $item) {
            $item2 = explode("=", $item);
            if ($item2[0] == "UID") {
                $stir = $item2[1];
            }
        }
        return $stir;
    }

    function getXML($sign)
    {
        $sign_arr = array();
        $client = new CurlRequest();
        if (!empty($sign) && Arr::get($sign, 0)) {
            $xml = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/"> <Body> <verifyPkcs7 xmlns="http://v1.pkcs7.plugin.server.dsv.eimzo.yt.uz/">  <pkcs7B64 xmlns="">' . $sign[0] . '</pkcs7B64>  </verifyPkcs7></Body></Envelope>';
            $responseBody = ($client->request($this->eimzo_server, $xml));
            if (!$responseBody) {
                return false;
            }
            preg_match("/<return>(.*)<\/return>/Uis", $responseBody, $matches);

            if (Arr::get($matches, 0) === '<return></return>') {
                Log::error('E-IMZO serverida xatolik!');
                return response()->json([
                    'message' => 'Verification server return no data'
                ], 400);
            } else {
                $xml = simplexml_load_string(Arr::get($matches, 0));
                $answer = json_decode(json_encode((array)$xml), true);
                $answer = (array)json_decode(Arr::get($answer, 0), true);
                $answer = json_decode(json_encode((array)$answer), true);
                $pkcs7info = Arr::get($answer, 'pkcs7Info');
                $signers = Arr::get($pkcs7info, 'signers');
                $className = Arr::get($answer, 'className');
                $reason = Arr::get($answer, 'reason');
                $successResponse = Arr::get($answer, 'success');
                foreach ($signers as $code) {
                    $certificate = Arr::get($code, 'certificate');
                    $certificate = Arr::get($certificate, 0);
                    $subjectName = Arr::get($certificate, 'subjectName');
                    $sign_arr[] =
                        [
                            'name' => $this->get_string_between($subjectName, 'CN=', ','),
                            'date' => Arr::get($code, "signingTime"),
                            'serialNumber' => $certificate['serialNumber'],
                            'stir' => $this->getStir($subjectName),
                        ];
                }
                if (isset($className, $reason, $successResponse)) {
                    if ($className === 'CMSException' && $reason === 'IOException reading content.' && $successResponse === false) {
                        Log::info($answer['reason']);
                    }
                    if ($className === 'DecoderException' && $reason === 'unable to decode base64 string: invalid characters encountered in base64 data' && $successResponse === false) {
                        Log::info("EIMZO ERROR procol.blade" . $answer['reason']);
                    }
                }
                $documentBase64 = Arr::get($pkcs7info, 'documentBase64');
                if (isset($signers['0'], $documentBase64)) {
                    $cert = $signers['0'];
                } else {
                    Log::error('EIMZO ERROR: protocol.blade Signer error');
                    return false;
                }
                $verification = (int)Arr::get($cert, 'verified') * Arr::get($cert, 'certificateVerified') * Arr::get($cert, 'certificateValidAtSigningTime');
                if ($verification == true) {
                    return $sign_arr;
                } else {
                    Log::error('EIMZO ERROR: Not verified');
                    return false;
                }
            }
        }

    }

}
