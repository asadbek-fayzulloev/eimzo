<?php

namespace Asadbek\Eimzo\Jobs;

use Asadbek\Eimzo\Http\Classes\ImzoData;
use Asadbek\Eimzo\Models\SignedDocs;
use Asadbek\Eimzo\Requests\SignRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EriJoinSignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private SignRequest $request;
    private array $signers;
    private ImzoData $imzoData;
    private String $newPkcs;
    public function __construct(SignRequest $request, array $signers, $document, $newPkcs)
    {
        $this->newPkcs= $newPkcs;
        $this->request=$request;
        $this->signers = $signers;
        $this->document =$document;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try{
            $this->document->pkcs = $this->newPkcs;
            $data = array();
            foreach ($this->signers as $signer){
                $data[] = new ImzoData($signer['name'], $signer['date'], $signer['serialNumber'], $signer['stir']);
            }
            $this->document->data = json_encode($data);

            $this->document->save();
        } catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
    }
}
