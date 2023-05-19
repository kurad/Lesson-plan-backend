<?php

namespace App\Http\Requests\Classes;

use App\DTO\Classes\UpdateClassDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRequest extends FormRequest
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
            "size" => "required|integer",
            "SEN" => "nullable|integer",
            "location" => "required|string",
        ];
    }
    public function passedValidation()
    {
        $this->dto = new UpdateClassDto($this->validated());
    }
}