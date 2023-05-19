<?php

namespace App\Http\Requests\Unit;

use App\DTO\Unit\UpdateUnitDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
            "title" => "required|string",
            "unitNo" => "required|integer",
            "unitCompetence" => "required|string",
            "subjectId" => "required|integer",

        ];
    }
    public function passedValidation()
    {
        $this->dto = new UpdateUnitDto($this->validated());
    }
}