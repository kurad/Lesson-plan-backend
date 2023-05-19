<?php

namespace App\Http\Requests\UserRole;

use App\DTO\UserRole\CreateRoleDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRoleRequest extends FormRequest
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
            "name" => "required",
        ];
    }
    public function passedValidation()
    {
        $this->dto = new CreateRoleDto($this->validated());
    }
}
