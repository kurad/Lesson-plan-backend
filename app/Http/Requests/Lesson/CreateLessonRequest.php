<?php

namespace App\Http\Requests\Lesson;

use App\DTO\Lesson\CreateLessonDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateLessonRequest extends FormRequest
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
            "unitId" => "required|integer",
            "topicArea" => "required|string",
            "duration" => "required|integer",
            "lessonDate" => "required|date",
            "instructions" => "nullable|string",
            "knowledge" => "required|string",
            "skills" => "required|string",
            "attitudes" => "required|string",
            "materials" => "required|string",
            "description" => "required|string",
            "reference" => "required|string",


        ];
    }


    public function passedValidation()
    {
        $this->dto = new CreateLessonDto($this->validated());
    }
}