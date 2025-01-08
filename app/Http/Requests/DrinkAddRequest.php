<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class DrinkAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            "drink" => "required|min:3|max:20",
            "amount" => "required|numeric",
            "type" => "required",
            "package" => "required"
        ];
    }

    public function messages() {

        return [
            "drink.required" => "Ital neve elvárt.",
            "drink.min" => "Túl rövid név.",
            "drink.max" => "Túl hosszú név.",
            "type.required" => "Típus elvárt.",
            "package.required" => "Kiszerelés elvárt."
        ];
    }

    public function failedValidation( Validator $validator ) {

        throw new HttpResponseException( response()->json([

            "success" => false,
            "message" => "Beviteli hiba",
            "data" => $validator->errors()
        ]));
    }
}
