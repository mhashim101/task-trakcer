<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MemberTasksExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->data['tasks'] as $task) {
            $rows[] = [
                $task->title,
                $task->team->name,
                ucfirst(str_replace('_', ' ', $task->status)),
                $task->assignedBy->name,
                $task->created_at->format('Y-m-d H:i'),
                $task->updated_at->format('Y-m-d H:i'),
                $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Task Title',
            'Team',
            'Status',
            'Assigned By',
            'Created At',
            'Last Updated',
            'Due Date'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:G' => ['alignment' => ['wrapText' => true]],
        ];
    }
}
