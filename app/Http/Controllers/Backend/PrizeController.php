<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PrizeController extends Controller
{
    public function index()
    {
        $prizes = Prize::all();
        return view('backend.prizes.index', compact('prizes'));
    }

    public function update(Prize $prize, Request $request)
    {

        $prize->title = $request->title;
        $prize->img = $request->img;

        $prize->save();
        session()->flash('success', "{$prize->id}更新完成");
        return back();
    }
}
