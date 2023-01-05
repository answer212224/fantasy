<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\AwardDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AwardController extends Controller
{
    public function index()
    {
        $awards = Award::orderBy('year', 'desc')->get();
        return view('backend.awards.index', compact('awards'));
    }


    public function destroy(Award $award)
    {
        $award->delete();
        session()->flash('success', "刪除完成");
        return back();
    }

    public function show(Award $award)
    {
        $award = $award->load('awardDetails.member');
        return view('backend.awards.show', compact('award'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|bail',
            'type' => 'required||bail',
            'member_id' => 'required|exists:App\Models\Member,id|bail',
            'title' => 'required|bail',
            'score' => 'required|numeric|bail',

        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return back();
        }
        $award = Award::firstOrCreate(
            [
                'year' => $request->year,
                'type' => $request->type,
                'cate' => $request->cate
            ]
        );

        $award->awardDetails()->create(
            [
                'member_id' => $request->member_id,
                'title' => $request->title,
                'score' => $request->score,
            ],
        );

        session()->flash('success', "新增" . "{$request->year}的{$request->type}的{$request->cate}的MemberID: {$request->member_id}的標題: {$request->title}的分數: $request->score");

        return back();
    }

    public function updateDetail(Request $request, AwardDetail $awardDetail)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|bail',
            'score' => 'required|numeric|bail',
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return back();
        }

        $awardDetail->title = $request->title;
        $awardDetail->score = $request->score;
        $awardDetail->save();

        return back();
    }

    public function destroyDetail(AwardDetail $awardDetail)
    {
        $awardDetail->delete();
        session()->flash('success', "刪除完成");
        return back();
    }
}
