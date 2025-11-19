<?php

namespace App\Http\Controllers;

use App\TraineeTask;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TraineeTasksImport;
use App\Exports\TraineeTasksExport;

class TraineeTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('trainee-tasks.index');
    }

    public function getData(Request $request)
    {
        $query = TraineeTask::with('trainee');

        // Filter berdasarkan role
        if (Auth::guard('admin')->check()) {
            // Admin melihat semua data
        } else {
            // User hanya melihat data sendiri
            $query->where('trainee_id', Auth::id());
        }

        // Filter status jika ada
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addColumn('checkbox', function ($task) {
                return '<input type="checkbox" name="task_ids[]" value="' . $task->id . '">';
            })
            ->addColumn('trainee_name', function ($task) {
                return $task->trainee->name;
            })
            ->addColumn('formatted_start_date', function ($task) {
                return $task->start_date->format('d-m-Y');
            })
            ->addColumn('formatted_deadline', function ($task) {
                return $task->deadline->format('d-m-Y');
            })
            ->addColumn('status_dropdown', function ($task) {
                $options = ['Progress', 'Done', 'Late', 'Canceled'];
                $dropdown = '<div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle status-btn" 
                            type="button" data-task-id="' . $task->id . '" 
                            data-current-status="' . $task->status . '">
                        ' . $task->status . '
                    </button>
                    <div class="dropdown-menu status-options" style="display: none;">';
                
                foreach ($options as $option) {
                    $dropdown .= '<a class="dropdown-item status-option" href="#" 
                                    data-status="' . $option . '">' . $option . '</a>';
                }
                
                $dropdown .= '</div></div>';
                return $dropdown;
            })
            ->addColumn('action', function ($task) {
                return '<a href="' . route('trainee-tasks.edit', $task->id) . '" 
                           class="btn btn-sm btn-primary">EDIT</a>';
            })
            ->rawColumns(['checkbox', 'status_dropdown', 'action'])
            ->make(true);
    }

    public function create()
    {
        $trainees = [];
        
        if (Auth::guard('admin')->check()) {
            // Admin bisa pilih semua user
            $trainees = User::where('is_admin', false)->get();
        } else {
            // User hanya bisa assign ke diri sendiri
            $trainees = [Auth::user()];
        }

        return view('trainee-tasks.create', compact('trainees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trainee_id' => 'required|exists:users,id',
            'task' => 'required|string|max:255',
            'desc' => 'required|string',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
        ]);

        TraineeTask::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Task berhasil dibuat!'
        ]);
    }

    public function edit($id)
    {
        $task = TraineeTask::findOrFail($id);
        
        // Pastikan user hanya bisa edit task miliknya sendiri
        if (!Auth::guard('admin')->check() && $task->trainee_id !== Auth::id()) {
            abort(403);
        }

        return view('trainee-tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = TraineeTask::findOrFail($id);
        
        // Pastikan user hanya bisa edit task miliknya sendiri
        if (!Auth::guard('admin')->check() && $task->trainee_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'task' => 'required|string|max:255',
            'desc' => 'required|string',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
        ]);

        $task->update($request->only(['task', 'desc', 'start_date', 'deadline']));

        return response()->json([
            'success' => true,
            'message' => 'Task berhasil diupdate!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $task = TraineeTask::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Progress,Done,Late,Canceled'
        ]);

        $task->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate!'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        // Hanya admin yang bisa bulk delete
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }

        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:trainee_tasks,id'
        ]);

        TraineeTask::whereIn('id', $request->task_ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tasks berhasil dihapus!'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new TraineeTasksImport, $request->file('excel_file'));

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diimport!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status']);
        
        return Excel::download(
            new TraineeTasksExport($filters), 
            'trainee-tasks-' . date('Y-m-d-H-i-s') . '.xlsx'
        );
    }
}
