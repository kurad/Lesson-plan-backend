<?php

namespace App\Http\Requests\UserType;

use App\DTO\UserType\CreateUserTypeDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserTypeRequest extends FormRequest
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
            "type" => "required|string",
        ];
    }
    public function passedValidation()
    {
        $this->dto = new CreateUserTypeDto($this->validated());
    }
}