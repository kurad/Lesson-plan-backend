<?php

namespace App\Http\Requests\Department;

use App\DTO\Department\UpdateDepartmentDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
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
        $this->dto = new UpdateDepartmentDto($this->validated());
    }
}