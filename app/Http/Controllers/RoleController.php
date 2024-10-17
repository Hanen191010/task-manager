<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role; // Import the Role model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import the Log facade for logging errors
use Illuminate\Support\Facades\Cache; // Import the Cache facade for caching data

class RoleController extends Controller
{   
    /*
     * Retrieves all roles from the database and returns them as a JSON response.
     *
     * This method uses caching to improve performance. The roles are cached for 150 seconds.
     * If the roles are not found in the cache, they are retrieved from the database and then cached.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    { 
        try {
            // Retrieve all roles from the cache if they exist.
            // If not, fetch them from the database and store them in the cache for 150 seconds.
            $roles = Cache::remember('roles', 150, function () {
                return Role::all();
            });

            // Return the roles as a JSON response.
            return response()->json($roles);
        } catch (ModelNotFoundException $e) {
            // Log the error and return a 404 Not Found response.
            Log::error($e);
            return response()->json('We didn\'t find anything', 404);
        } catch (RelationNotFoundException $e) {
            // Log the error and return a 404 Not Found response.
            Log::error($e);
            return response()->json('We didn\'t find any relation', 404);
        } catch (\Exception $e) {
            // Log the error and return a 500 Internal Server Error response.
            Log::error($e);
            return response()->json('Something went wrong', 500);
        }
    }
}
