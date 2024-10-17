<?php

namespace AppHttpControllers;

use AppHttpControllersController;
use AppModelsTask;
use IlluminateHttpRequest;
use IlluminateSupportFacadesLog;
use AppJobsGenerateDailyReport;

class ReportController extends Controller
{
    // Method to retrieve daily tasks and dispatch a report generation job
    public function dailyTasks()
    {   
        try {
            // Retrieve tasks that are due today
            $dailyTasks = Task::whereDate('due_date', now()->toDateString())
                ->get();
            
            // Dispatch a job to generate a daily report with the retrieved tasks
            GenerateDailyReport::dispatch($dailyTasks);
            
            // Return the list of daily tasks as a JSON response
            return response()->json($dailyTasks);
        } catch (ModelNotFoundException $e) {
            // Log the error if the model is not found
            Log::error($e);
            // Return a 404 response indicating nothing was found
            return response()->json('We didnt find anything', 404);
        } catch (RelationNotFoundException $e) {
            // Log the error if there is a relation issue
            Log::error($e);
            // Return a 404 response indicating no relations were found
            return response()->json('We didnt find any relation', 404);
        } catch (Exception $e) {
            // Log any other exceptions that may occur
            Log::error($e);
            // Return a 500 response indicating an internal server error
            return response()->json('Something went wrong', 500);
        }
    }
}
