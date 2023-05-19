<?php

namespace App\Http\Requests\LessonPart;

use App\DTO\LessonParts\UpdateLessonPartDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonPartRequest extends FormRequest
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
            "duration" => "required|integer",
            "lessonId" => "required|integer",
        ];
    }
    public function passedValidation()
    {
        $this->dto = new UpdateLessonPartDto($this->validated());
    }
}