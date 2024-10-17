<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\TaskService;

class TaskController extends Controller
{ 
    protected $TaskService;

    public function __construct(TaskService $TaskService)
    {
        // حقن خدمة TaskService
        $this->TaskService = $TaskService;
    }

    public function store(TaskRequest $request)
    {   
    try {
        $task = $this->TaskService->storeTask($request->validated());

        return response()->json($task, 201);

    } catch (ModelNotFoundException $e) {
            Log::error($e);
            return response()->json('We didn\'t find anything', 404);
        } catch (RelationNotFoundException $e) {
            Log::error($e);
            return response()->json('We didn\'t find any relation', 404);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json('Something went wrong', 500);
        }
        
    }

    public function index(Request $request)
    {  try{

        $tasks = $this->TaskService->indexTask($request);
        return response()->json($tasks);

    } catch (\Exception $e) {
        Log::error($e);
        return response()->json('Something went wrong',500);
       } catch (ModelNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find anything',404);
       } catch (RelationNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find any realtion',404);
       }
    }

    public function show(Task $task)
    {  try{
        return response()->json($task->load('dependentTasks','comments','attachments'));
       } catch (\Exception $e) {
        Log::error($e);
        return response()->json('Something went wrong',500);
       } catch (ModelNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find anything',404);
       } catch (RelationNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find any realtion',404);
       }
    }

    public function update(TaskRequest $request, Task $task)
    {   try{
        $task->update($request->validated());

        return response()->json($task);
       } catch (\Exception $e) {
        Log::error($e);
        return response()->json('Something went wrong',500);
       } catch (ModelNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find anything',404);
       } catch (RelationNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find any realtion',404);
       }
    }

    public function destroy(Task $task)
    {  try{
        $task->delete();

        return response()->json(null, 204);
       } catch (\Exception $e) {
        Log::error($e);
        return response()->json('Something went wrong',500);
       } catch (ModelNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find anything',404);
       } catch (RelationNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find any realtion',404);
       }
    }

    public function updateStatus(Request $request, Task $task)
    {   try{
        $task = $this->TaskService->updateStatusTask($request,$task);
        return response()->json($task->load('dependentTasks'));
       } catch (\Exception $e) {
        Log::error($e);
        return response()->json('Something went wrong',500);
       } catch (ModelNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find anything',404);
       } catch (RelationNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find any realtion',404);
       }
    }

    public function reassign(Request $request, Task $task)
    {   try{
        $task->update(['assigned_to' => $request->assigned_to]);

        return response()->json($task);
       } catch (\Exception $e) {
        Log::error($e);
        return response()->json('Something went wrong',500);
       } catch (ModelNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find anything',404);
       } catch (RelationNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find any realtion',404);
       }
    }

    public function assign(Request $request, Task $task)
    {   try{
        $task->update(['assigned_to' => $request->user_id]);

        return response()->json($task);
       } catch (\Exception $e) {
        Log::error($e);
        return response()->json('Something went wrong',500);
       } catch (ModelNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find anything',404);
       } catch (RelationNotFoundException $e) {
           Log::error($e);
           return response()->json('We didnt find any realtion',404);
       }
    }
    
}