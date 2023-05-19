<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Auth\LoginDto;

class LoginFormRequest extends FormRequest
{

    public LoginDto $dto;
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
            "email" => "required|email",
            "password" => "required|string"
        ];
    }
    public function passedValidation()
    {
        $this->dto = new LoginDto($this->validated());
    }
}
