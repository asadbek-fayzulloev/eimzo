<?php
namespace Asadbek\Eimzo\Services\SendInfo;

class Telegram implements SendInfoInterface {

    protected $message;
    protected $botUrl;
    protected  $bot_token;
    protected  $chat_id;

    public function __construct($message) {
        $this->bot_token = config("eimzo.telegram.bot_token");
        $this->chat_id = config("eimzo.telegram.chat_id");

        $this->message = $message;
        $this->botUrl = sprintf("https://api.telegram.org/bot%s/", $this->bot_token);
    }

    public function sendMessage() {
        $url = $this->botUrl . "sendMessage?chat_id=" . $this->chat_id . "&parse_mode=HTML&text=" . urlencode
            ($this->message);
        file_get_contents($url);
    }
}
