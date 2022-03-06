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

class EriSignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private SignRequest $request;
    private array $signers;
    public function __construct(SignRequest $request, array $signers)
    {
        $this->request=$request;
        $this->signers = $signers[0];
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
            $document = new SignedDocs();
            $document->pkcs = $this->request->pkcs7;
            $document->text = $this->request->data;
            $data[] = new ImzoData($this->signers['name'], $this->signers['date'], $this->signers['serialNumber'],
                $this->signers['stir']);
            $document->data = json_encode($data);
            $document->save();
        } catch (\Exception $exception){
            dd('Ex'.$exception->getMessage());
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

    }
}
