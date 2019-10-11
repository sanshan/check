<?php

namespace App\Http\Requests\Task;

class TaskUpdateRequest extends TaskRequest
{
    public function rules()
    {
        return [
                'task_id' => 'required|integer|exists:tasks,id',
            ] + parent::rules();
    }
}
