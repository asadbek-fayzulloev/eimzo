<?php

namespace Asadbek\Eimzo\Http\Controllers;

use App\Models\Application;
use App\Models\SignedDocs;
use Asadbek\Eimzo\Requests\SignRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EimzoSignController extends Controller
{
    public function index()
    {
        return view('asadbek.eimzo.sign.master');
    }

    public function verifyPks(SignRequest $request)
    {
        try {
            return redirect()->route('sign.index')->with('success', 'Signed');
        } catch (\Exception $exception) {
            return redirect()->route('sign.index')->with('danger', 'Something went wrong! Contact developer!');
        }

    }

    public function joinTwoPks(SignRequest $request)
    {
        try {
            return redirect()->route('sign.index')->with('success', 'Signed');
        } catch (\Exception $exception) {
            return redirect()->route('sign.index')->with('danger', 'Something went wrong! Contact developer!');
        }
    }

    public function sign()
    {

    }

    public function docsList(Request $request)
    {
        $data = SignedDocs::all();
        return $data;
    }
}