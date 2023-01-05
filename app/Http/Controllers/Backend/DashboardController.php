<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $weight = Weight::first();
        $setting = Setting::first();

        return view('backend.dashboard', compact('weight', 'setting'));
    }

    public function setting(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'year' => 'required|bail',
            'type' => 'required||bail',
            'award_year' => 'required||bail',
            'prize_type' => 'required|bail',
        ]);

        if ($validator->fails()) {
            session()->flash('error', "格式有誤");
            return back();
        }

        $setting = Setting::first();
        $setting->year = $request->year;
        $setting->type = $request->type;
        $setting->award_year = $request->award_year;
        $setting->prize_type = $request->prize_type;
        $setting->shutdown_start_date = $request->shutdown_start_date;
        $setting->shutdown_end_date = $request->shutdown_end_date;
        $setting->save();
        session()->flash('success', "更新完成");
        return back();
    }

    public function weight(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assist' => 'required|numeric|bail',
            'block' => 'required|numeric|bail',
            'reb' => 'required|numeric|bail',
            'turnover' => 'required|numeric|bail',
            'steal' => 'required|numeric|bail',
            'point' => 'required|numeric|bail',
        ]);


        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return back();
        }
        $weight = Weight::first();
        $weight->assist = $request->assist;
        $weight->block = $request->block;
        $weight->reb = $request->reb;
        $weight->turnover = $request->turnover;
        $weight->steal = $request->steal;
        $weight->point = $request->point;
        $weight->save();
        session()->flash('success', "更新完成");
        return back();
    }
}
