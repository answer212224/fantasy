<?php

namespace App\Http\Controllers\Backend;

use App\Exports\HistoriesExport;
use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Member;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;




class MemberController extends Controller
{

    public function __construct(History $history)
    {
        $this->history = $history;
    }

    public function index(Request $request)
    {
        $memberHistoryCount = 0;
        $historyCount = 0;

        $memberQuery = Member::query();
        if ($request->detail) {
            $memberHistoryCount = $memberQuery->withExists('histories')->get()->where('histories_exists', 1)->count();
            $historyCount = History::count();
        }

        if ($request->name) {
            $memberQuery->where('name', $request->name)->paginate('20');
        }

        $members =  $memberQuery->latest()->paginate('20');

        $members->setPath(env('APP_URL') . '/admin/members');


        return view('backend.members.index', compact('members', 'historyCount', 'memberHistoryCount'));
    }


    public function show(Member $member)
    {
        $member = $member->load(['histories' => function ($query) {
            $query->orderBy('date_only', 'desc');
        }]);

        return view('backend.members.histories', compact('member'));
    }

    public function showSelections(History $history)
    {
        $history = $history->load(['selections.player']);
        return view('backend.members.selections', compact('history'));
    }

    public function export(Request $request)
    {
        $history = $this->history->where('date_only', '>=', $request->start)->where('date_only', '<=', $request->end);
        return Excel::download(new HistoriesExport($history), "fantasy_{$request->start}_{$request->end}.xlsx");
    }
}
