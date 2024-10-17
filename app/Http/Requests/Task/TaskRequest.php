<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:Bug,Feature,Improvement',
            'status' => 'nullable|in:Open,In Progress,Completed,Blocked',
            'priority' => 'nullable|in:Low,Medium,High',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}