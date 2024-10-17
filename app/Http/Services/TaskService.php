<?php

namespace App\Http\Services;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService
{
    public function storeTask($data)
    {
        $task =Task::create($data);
        return $task;
    }
    public function indexTask($request)
    {
        $tasks = Task::query();
        
        if ($request->has('type')) {
            $tasks->byType($request->query('type'));
        }
        if ($request->has('status')) {
            $tasks->byStatus($request->query('status'));
        }
        if ($request->has('assigned_to')) {
            $tasks->byAssignedTo($request->query('assigned_to'));
        }
        if ($request->has('due_date')) {
            $tasks->byDueDate($request->query('due_date'));
        }
        if ($request->has('priority')) {
            $tasks->byPriority($request->query('priority'));
        }
        if ($request->has('depends_on')) {
            $tasks->withoutDependencies(); // لتصفية المهام التي تعتمد على مهام أخرى
        }

        $tasks = $tasks->get();
        return $tasks;
        }
        public function updateStatusTask($request,$task)
        {
            $task->update(['status' => $request->status]);

        $task->statusUpdates()->create([
            'status' => $request->status,
        ]);

        // تحديث حالة المهام التابعة
        if ($request->status === 'Completed') {
            $task->dependentTasks()->update(['status' => 'Open']);
        } elseif ($request->status === 'Blocked') {
            // تغيير حالة المهام المعتمدة على هذه المهمة إلى Blocked 
            $task->dependentOn()->update(['status' => 'Blocked']);
        }
            return $task;
        }
}
