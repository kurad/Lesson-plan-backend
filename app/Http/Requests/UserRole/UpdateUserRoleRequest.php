<?php

namespace App\Http\Requests\UserRole;

use App\DTO\UserRole\UpdateUserRoleDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
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
            "role_id" => "required|integer",
        ];
    }
    public function passedValidation()
    {
        $this->dto = new UpdateUserRoleDto($this->validated());
    }
}