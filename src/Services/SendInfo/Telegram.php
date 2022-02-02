<?php
namespace Asadbek\Eimzo\Services\SendInfo;

use CurlFile;


class Telegram implements SendInfoInterface {

    protected $message;
    protected $botUrl;
    protected const BOT_TOKEN = "1881298730:AAFH5_HHAPHBWOefgjIjdPQy4PTfCVASTQM";
    protected const CHAT_ID = "-1001243532957";

    public function __construct($message) {
        $this->message = $message;
        $this->botUrl = sprintf("https://api.telegram.org/bot%s/", self::BOT_TOKEN);
    }

    public function sendMessage() {
        $url = $this->botUrl . "sendMessage?chat_id=" . self::CHAT_ID . "&parse_mode=HTML&text=" . urlencode($this->message);
        file_get_contents($url);
    }
}
