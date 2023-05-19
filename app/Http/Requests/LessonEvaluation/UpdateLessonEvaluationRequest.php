<?php

namespace App\Http\Requests\LessonEvaluation;

use App\DTO\LessonEvaluation\UpdateLessonEvaluationDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonEvaluationRequest extends FormRequest
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
            "content" => "required|string",
            "lesson_part_id" => "required|integer",
        ];
    }

    public function passedValidation()
    {
        $this->dto = new UpdateLessonEvaluationDto($this->validated());
    }
}
