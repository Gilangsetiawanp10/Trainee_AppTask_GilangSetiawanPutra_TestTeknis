<?php

namespace App\Imports;

use App\TraineeTask;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class TraineeTasksImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Find trainee by email
        $trainee = User::where('email', $row['trainee_email'])->first();
        
        if (!$trainee) {
            throw new \Exception('Trainee with email ' . $row['trainee_email'] . ' not found');
        }

        return new TraineeTask([
            'trainee_id' => $trainee->id,
            'task' => $row['task'],
            'desc' => $row['description'],
            'start_date' => Carbon::createFromFormat('Y-m-d', $row['start_date']),
            'deadline' => Carbon::createFromFormat('Y-m-d', $row['deadline']),
            'status' => $row['status'] ?? 'Progress',
        ]);
    }

    public function rules(): array
    {
        return [
            'trainee_email' => 'required|email|exists:users,email',
            'task' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d',
            'deadline' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'status' => 'nullable|in:Progress,Done,Late,Canceled',
        ];
    }
}
