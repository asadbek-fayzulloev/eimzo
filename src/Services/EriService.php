<?php

namespace Asadbek\Eimzo\Services;

use Asadbek\Eimzo\Models\User;
use Asadbek\Eimzo\Jobs\NotifyOperatorJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EriService {
    public function makeParams($data) {
        $fullname_parts = $this->parseFullname($data['eri_fullname']);
        // #TODO: check table columns
        return [
            'username' => $data['eri_sn'],
            'fullname' => $data['eri_fullname'],
            'firstname' => $fullname_parts['firstname'],
            'lastname' => $fullname_parts['lastname'],
            'midname' => $fullname_parts['midname'],
            'pinfl' => $data['eri_pinfl'],
            // 'inn' => $data['eri_inn'],
            'passport' => null,
            'passport_expire_date' => null,
            'phone' => null,
            'address' => null,
            'email' => $data['eri_sn'] . "@mail.mail",
            'name' => $data['eri_sn'],
            'password' => Hash::make(uniqid()),
            'auth_type' => 'eri',
            'role_id' => 9,
            'status' => 1,
            'user_type' => 'Jismoniy shaxs'
        ];
    }

    public function authorizeUser($params) {
        // CREATE NEW OR UPDATE EXISTING USER
        $user = User::firstOrCreate(
            ['pinfl' => $params['pinfl']],
            $params
        );

        // NOTIFY OPERATOR ABOUT NEW USER
        if($user->wasRecentlyCreated) {
            $message = "<b>Yangi foydalanuvchi tizimda ro'yhatdan o'tdi.</b>\n";
            $message .= "<b>ERI KEY:</b> " . $user->username . "\n";
            $message .= "<b>FISh:</b> " . $user->fullname . "\n";

            // #TODO: dispatch async on production
            NotifyOperatorJob::dispatchSync($message);
        }

        // CHECK USER STATUS
        // #TODO: middleware to check status of auth user
        if(!$user->status)
            throw new \Exception(trans("user::trans.user_is_inactive"), 401);

        // AUTHORIZE USER
        Auth::login($user);
    }

    protected function parseFullname($fullname) {
        $fullname_parts = explode(' ', $fullname);

        $data = [];
        $data['lastname'] = $fullname_parts[0];
        $data['firstname'] = $fullname_parts[1];
        $data['midname'] = "";
        $data['midname'] .= isset($fullname_parts[2]) ? $fullname_parts[2] : "";
        $data['midname'] .= isset($fullname_parts[3]) ? " " . $fullname_parts[3] : "";

        return $data;
    }
}
