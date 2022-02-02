<?php

namespace Asadbek\Eimzo\Jobs;

use Asadbek\Eimzo\Services\SendInfo\SendInfo;
use Asadbek\Eimzo\Services\SendInfo\Telegram;
use Illuminate\Bus\Queueable;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class NotifyOperatorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
//         $telegram = new Telegram($this->message);
//         try {
//             $response = new SendInfo($telegram);
//             if(isset($response->ok) && $response->ok) {
//                 return true;
//             }
//         } catch (\Throwable $th) {
//             Log::error(sprintf("Error Message: %s, Line: %s, File: %s", $th->getMessage(), $th->getLine(), $th->getFile()));
//             return false;
//         }
    }
}
