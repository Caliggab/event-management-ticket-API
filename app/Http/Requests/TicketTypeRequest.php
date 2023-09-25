<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketTypeRequest extends FormRequest
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
            'description' => 'sometimes|nullable|string',
            'event_id' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',

            'total_quantity' => 'sometimes|nullable|integer|min:0',
            'available_quantity' => 'sometimes|nullable|integer|min:0',
            
            // 'sale_start_date' => 'required|date_format:Y-m-d H:i:s',
            // 'sale_end_date' => 'required|date_format:Y-m-d H:i:s|after:sale_start_date',
            // 'purchase_limit' => 'nullable|integer|min:1'
        ];
    }


}
