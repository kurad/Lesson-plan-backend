<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Auth\UpdateProfileDto;

class UpdateProfileFormRequest extends FormRequest
{
    public UpdateProfileDto $dto;
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
            "firstName" => "required|string",
            "lastName" => "required|string",
            "departmentId" => "required|integer",
            "email" => "required|string|email",
            "phoneNumber" => "nullable|string",
            "password" => "required|string|min:6",
        ];
    }
    public function passedValidation()
    {
        $this->dto = new UpdateProfileDto($this->validated());
    }
}
