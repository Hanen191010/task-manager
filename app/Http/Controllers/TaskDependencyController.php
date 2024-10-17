<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// Import the necessary request class for validation
use App\Http\Requests\Task\TaskDependencyRequest; 
use App\Models\Task; // Import the Task model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import the Log facade for logging errors
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import the ModelNotFoundException
use Illuminate\Database\Eloquent\Relations\RelationNotFoundException; // Import the RelationNotFoundException

class TaskDependencyController extends Controller
{
    /**
     * Creates a dependency between two tasks.
     *
     * This method attaches a dependent task to the specified task, updating the status of the dependent task if necessary.
     * 
     * @param Request $request The request containing the dependent task ID
     * @param Task $task The task object to which the dependency should be added
     * @return \Illuminate\Http\JsonResponse Returns the updated task (with its dependencies) as JSON
     */
    public function storeDependencies(Request $request, Task $task)
    {
        try {
            // Attach the dependent task to the task using the 'dependentTasks' relationship
            $task->dependentTasks()->attach($request->dependent_task_id);

            // Check if the task's status is "In Progress"
            if ($task->status == 'In Progress') {
                // Find the dependent task using its ID
                $dependentTask = Task::findOrFail($request->dependent_task_id);

                // If the dependent task exists
                if ($dependentTask) {
                    // Set the status of the dependent task to "Blocked"
                    $dependentTask->status = 'Blocked'; 

                    // Save the changes to the dependent task
                    $dependentTask->save(); 
                }
            }

            // Return the updated task (with its dependencies) as a JSON response
            return response()->json($task->load('dependentTasks'));

        } catch (\Exception $e) {
            // Log the error and return a 500 Internal Server Error response
            Log::error($e);
            return response()->json('Something went wrong', 500);
        } catch (ModelNotFoundException $e) {
            // Log the error and return a 404 Not Found response
            Log::error($e);
            return response()->json('We didnt find anything', 404);
        } catch (RelationNotFoundException $e) {
            // Log the error and return a 404 Not Found response
            Log::error($e);
            return response()->json('We didnt find any realtion', 404);
        }
    }

    /**
     * Removes a dependency between two tasks.
     *
     * This method detaches the dependent task from the specified task.
     *
     * @param Task $task The task object from which the dependency should be removed
     * @param Task $dependentTask The dependent task object
     * @return \Illuminate\Http\JsonResponse Returns a 204 No Content response
     */
    public function destroyDependencies(Task $task, Task $dependentTask)
    {
        try {
            // Detach the dependent task from the task using the 'dependentTasks' relationship
            $task->dependentTasks()->detach($dependentTask->id);

            // Return a 204 No Content response indicating successful detachment
            return response()->json(null, 204);

        } catch (\Exception $e) {
            // Log the error and return a 500 Internal Server Error response
            Log::error($e);
            return response()->json('Something went wrong', 500);
        } catch (ModelNotFoundException $e) {
            // Log the error and return a 404 Not Found response
            Log::error($e);
            return response()->json('We didnt find anything', 404);
        } catch (RelationNotFoundException $e) {
            // Log the error and return a 404 Not Found response
            Log::error($e);
            return response()->json('We didnt find any realtion', 404);
        }
    }
}
