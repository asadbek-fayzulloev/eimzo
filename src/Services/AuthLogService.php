<?php

namespace Asadbek\Eimzo\Services;

use Asadbek\Eimzo\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthLogService {
    public static function logAuth() {
        if(Auth::check()) {
            // AuthLog::create(['user_id' => Auth::user()->id, 'ip' => request()->ip()]);
            User::where('id', Auth::user()->id)->update([
                'last_login' => Carbon::now()->toDateTimeString()
            ]);
        }
    }
}
