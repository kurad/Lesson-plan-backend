<?php

namespace App\Http\Requests\Department;

use App\DTO\Department\CreateDepartmentDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
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
            "name" => "required|string",
        ];
    }

    public function passedValidation()
    {
        $this->dto = new CreateDepartmentDto($this->validated());
    }
}