<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST': 
            case 'PUT':
            case 'PATCH': 
                return [
                    'name' => 'sometimes|required|string|max:255',
                    'description' => 'sometimes|required|string',
                    'start_date_time' => 'sometimes|required',
                    'end_date_time' => 'sometimes|required',
                    'location' => 'sometimes|nullable|string|max:255',
                    'header_image' => 'sometimes|nullable|string', 
                    'status' => 'sometimes|in:published,drafted',
                ];
            default:
                return [];
        }
    }
}