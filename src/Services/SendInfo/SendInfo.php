<?php
namespace Asadbek\Eimzo\Services\SendInfo;

use App\Services\SendInfo\SendInfoInterface;

class SendInfo {
    public function __construct(SendInfoInterface $sendProvider)
    {
        $sendProvider->sendMessage();
    }


}
