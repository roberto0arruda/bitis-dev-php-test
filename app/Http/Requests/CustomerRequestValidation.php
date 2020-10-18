<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CustomerRequestValidation extends FormRequest
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
        $id = $this->segment(3);

        $rules = [
            'email' => "email:filter|unique:customers,email,{$id},id"
        ];

        if ($id == null) {
            $rules['name'] = 'required';
            $rules['email'] = "required|email:filter|unique:customers";
        }

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $email = $this->input('email');
        $customer = Customer::withTrashed()->where('email', $email)->first();

        $validator->after(function ($validator) use ($customer) {
            if ($customer && $customer->deleted_at) {
                $validator->errors()->add('restored', 'Customer restored of the trash!');
                $customer->restore();
            }
        });
    }
}
