<?php

namespace App\Http\Requests\LessonActivity;

use App\DTO\LessonActivity\CreateLessonActivitiesDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateLessonActivityRequest extends FormRequest
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
            "teacherActivities" => "required|string",
            "learnerActivities" => "required|string",
            "competences" => "required|string",
            "lessonPartId" => "required|integer",
        ];
    }

    public function passedValidation()
    {
        $this->dto = new CreateLessonActivitiesDto($this->validated());
    }
}
