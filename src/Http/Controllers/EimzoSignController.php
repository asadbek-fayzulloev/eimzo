<?php

namespace Asadbek\Eimzo\Http\Controllers;

use App\Models\SignedDocs;
use Asadbek\Eimzo\Jobs\EriJoinSignJob;
use Asadbek\Eimzo\Jobs\EriSignJob;
use Asadbek\Eimzo\Requests\SignRequest;
use Asadbek\Eimzo\Services\EimzoService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EimzoSignController extends Controller
{
    private EimzoService $eimzoService;
    public function __construct()
    {
        $this->eimzoService = new EimzoService();
    }

    public function index()
    {
        $signs = SignedDocs::all();
        return view('asadbek.eimzo.sign.master', compact('signs'));
    }

    public function verifyPks(SignRequest $request)
    {

        try {
            $text = $request->data;
            $document = SignedDocs::where('text', $text)->first();


            if($document){
                $new = $request->pkcs7;
                $old = $document->pkcs;
                $newPkcs = $this->eimzoService->joinSigns($old,$new);
                if(!$newPkcs)
                    return redirect()->route('sign.index')->with('danger', 'Fix Eimzo Service! Error in newPkcs');
                $signers = $this->eimzoService->getXML($newPkcs);

                if(!$signers)
                    return redirect()->route('sign.index')->with('danger', 'Fix Eimzo Service! Error in getting info');

                $this->dispatchNow(new EriJoinSignJob($request, $signers, $document, $newPkcs[0]));

            }
            else {
                $pkcs7[] = $request->pkcs7;
                $signers = $this->eimzoService->getXML($pkcs7);
                if(!$signers)
                    return redirect()->route('sign.index')->with('danger', 'Fix Eimzo Service!');
                $this->dispatchNow(new EriSignJob($request, $signers));

            }
            return redirect()->route('sign.index')->with('success', 'Signed');
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->route('sign.index')->with('danger', 'Something went wrong! Contact developer!');
        }

    }

    public function joinTwoPks(SignRequest $request)
    {
        try {
            return redirect()->route('sign.index')->with('success', 'Signed');
        } catch (\Exception $exception) {
            return redirect()->route('sign.index')->with('danger', 'Something went wrong! Contact developer!');
        }
    }

    public function sign()
    {

    }

    public function docsList(Request $request)
    {
        if (isset($request->orderBy)) {
            if ($request->orderBy == 'all') {
                $data = SignedDocs::get();
            }
        }
        return $data;
    }

}