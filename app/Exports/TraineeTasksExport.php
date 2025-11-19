<?php

namespace App\Exports;

use App\TraineeTask;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Auth;

class TraineeTasksExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = TraineeTask::with('trainee');

        // Filter berdasarkan role
        if (Auth::guard('admin')->check() || (Auth::guard('web')->check() && Auth::guard('web')->user()->is_admin)) {
            // Admin melihat semua data
        } else {
            // User hanya melihat data sendiri
            $currentUser = Auth::guard('admin')->check() ? Auth::guard('admin')->user() : Auth::guard('web')->user();
            $query->where('trainee_id', $currentUser->id);
        }

        // Apply filters
        if (isset($this->filters['status']) && !empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Trainee Name',
            'Trainee Email',
            'Task',
            'Description',
            'Start Date',
            'Deadline',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($task): array
    {
        return [
            $task->id,
            $task->trainee->name,
            $task->trainee->email,
            $task->task,
            $task->desc,
            $task->start_date->format('Y-m-d'),
            $task->deadline->format('Y-m-d'),
            $task->status,
            $task->created_at->format('Y-m-d H:i:s'),
            $task->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Set background color for header
            'A1:J1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE2E2E2']
                ]
            ],
        ];
    }
}
