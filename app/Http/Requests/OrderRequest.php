<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => 'required|max:255',
            'customer_surname' => 'String|max:255',
            'customer_phone' => 'required|regex:/[78][0-9]{10}/',
            'customer_email' => 'required|email',
            'customer_address' => 'required',
            'privacy' => 'accepted',
            'pay_handler' => 'exists:App\PayHandler,id'
        ];
    }
}
