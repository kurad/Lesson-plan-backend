<?php

namespace App\Http\Requests\UserType;

use App\DTO\UserType\UpdateUserTypeDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserTypeRequest extends FormRequest
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
        $this->dto = new UpdateUserTypeDto($this->validated());
    }
}