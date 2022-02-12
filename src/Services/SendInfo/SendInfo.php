<?php
namespace Asadbek\Eimzo\Services\SendInfo;

use Asadbek\Eimzo\Services\SendInfo\SendInfoInterface;

class SendInfo {
    public function __construct(SendInfoInterface $sendProvider)
    {
        $sendProvider->sendMessage();
    }


}
