<?php

namespace App\Exports;

use App\Models\History;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;


class HistoriesExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct($history)
    {
        $this->history = $history;
    }

    public function collection()
    {
        return $this->history->with(['member', 'selections'])->get();
    }

    public function map($history): array
    {

        return [
            $history->id,
            $history->member->id,
            $history->member->fb,
            $history->member->name,
            $history->member->email,
            "{$history->total}",
            $history->selections[0]->player_id,
            $history->selections[1]->player_id,
            $history->selections[2]->player_id,
            $history->selections[3]->player_id,
            $history->selections[4]->player_id,
            $history->date_only,
            $history->year,
            $history->type,
        ];
    }

    public function headings(): array
    {
        return [
            'History ID',
            'Member ID',
            'FaceBook ID',
            'Name',
            'Email',
            'Total',
            'player ID',
            'player ID',
            'player ID',
            'player ID',
            'player ID',
            'Date',
            'Year',
            'Type',
        ];
    }
}
