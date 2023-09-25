<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'total_quantity' => 'sometimes|nullable|integer|min:1',
            'available_quantity' => 'sometimes|nullable|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|nullable|string',
            'ticket_type_id' => 'sometimes|required|string',
            'event_id' => 'sometimes|required|string',
            'order_id' => 'sometimes|required|string',
            'user_id' => 'sometimes|required|string',
            'status' => 'sometimes|nullable|string',
            'location' => 'sometimes|nullable|string',
            'start_date_time' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'end_date_time' => 'sometimes|required|date_format:Y-m-d H:i:s|after:sale_start_date',
            'purchase_limit' => 'sometimes|nullable|integer|min:1',
        ];
    }
}
