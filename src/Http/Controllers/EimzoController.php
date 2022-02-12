<?php

namespace Asadbek\Eimzo\Http\Controllers;

use Asadbek\Eimzo\Requests\EriRequest;
use Asadbek\Eimzo\Services\AuthLogService;
use Asadbek\Eimzo\Services\EriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EimzoController extends Controller
{
    public function index(){
        return view("asadbek.eimzo.login");
    }
    public function auth(EriRequest $request) {
        try {
            $oneAuthService = new EriService();
            $params = $oneAuthService->makeParams($request->validated());
            $oneAuthService->authorizeUser($params);

            AuthLogService::logAuth();

        } catch (\Throwable $th) {
            $errorMessage = "Киришда хатолик юз берди, илтимос кейинроқ уруниб кўринг.";
            if(in_array($th->getCode(), [401])) {
                $errorMessage = $th->getMessage();
            }

            Log::error(sprintf("ERI error: Message: %s, Line: %s, File: %s", $th->getMessage(), $th->getLine(), $th->getFile()));
            return redirect()->route(config('eimzo.redirect_url.after_login_error'))->with('error', $errorMessage);
        }

        return redirect()->route(config('eimzo.redirect_url.after_login_success'));
    }
}
