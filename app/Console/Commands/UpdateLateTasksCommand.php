<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TraineeTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // TAMBAHKAN INI

class UpdateLateTasksCommand extends Command
{
    protected $signature = 'tasks:update-late';
    protected $description = 'Update task status to Late if deadline has passed and status is not Done';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Checking for late tasks...');
        
        // Get current date
        $today = Carbon::now()->format('Y-m-d');
        
        // Find tasks that are past deadline and not Done or already Late
        $lateTasks = TraineeTask::where('deadline', '<', $today)
            ->whereNotIn('status', ['Done', 'Late', 'Canceled'])
            ->get();
        
        if ($lateTasks->count() === 0) {
            $this->info('No tasks to update.');
            return 0;
        }
        
        // Update tasks to Late status
        $updatedCount = 0;
        foreach ($lateTasks as $task) {
            $oldStatus = $task->status;
            $task->update(['status' => 'Late']);
            $updatedCount++;
            
            $this->line("✓ Updated: {$task->task} (ID: {$task->id}) from '{$oldStatus}' to 'Late'");
            $this->line("  Trainee: {$task->trainee->name}");
            $this->line("  Deadline: {$task->deadline->format('Y-m-d')}");
            $this->line("");
        }
        
        $this->info("🎉 Total {$updatedCount} tasks updated to Late status.");
        
        // Log hanya ke file Laravel log (sudah ada)
        Log::info("Cron job executed: {$updatedCount} tasks updated to Late status", [
            'updated_tasks' => $lateTasks->map(function($task) {
                return [
                    'id' => $task->id,
                    'task' => $task->task,
                    'trainee' => $task->trainee->name,
                    'deadline' => $task->deadline->format('Y-m-d')
                ];
            })->toArray(),
            'executed_at' => Carbon::now()->toDateTimeString()
        ]);
        
        return 0;
    }
}
