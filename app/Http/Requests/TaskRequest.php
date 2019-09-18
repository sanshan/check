<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    use RequestMessages;
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
        $rules = [
            'gas_station_id'                => 'required|integer|exists:gas_stations,id',
            'start_date'                    => 'required|date_format:d.m.Y',
            'end_date'                      => 'required|date_format:d.m.Y',
            'type_of_checklists_id'         => 'required|integer|exists:type_of_checklists,id',
            'user_id'                       => 'required|integer|exists:users,id',
        ];

        switch($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'task_id'               => 'required|integer|exists:tasks,id',
                ] + $rules;
            //case 'DELETE':
        }

    }
}
