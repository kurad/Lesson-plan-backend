<?php

namespace App\Http\Requests\LessonActivity;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\LessonActivity\UpdateTeacherActivitiesDto;


class UpdateTeacherActivityRequest extends FormRequest
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
            "teacher_activities" => "required|string",
        ];
    }

    public function passedValidation()
    {
        $this->dto = new UpdateTeacherActivitiesDto($this->validated());
    }
}