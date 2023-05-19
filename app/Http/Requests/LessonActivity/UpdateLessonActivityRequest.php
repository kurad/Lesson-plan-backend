<?php

namespace App\Http\Requests\LessonActivity;

<<<<<<< HEAD
use App\DTO\LessonActivity\UpdateTeacherActivitiesDto;
=======
use App\DTO\LessonStudentActivities\UpdateLessonActivitiesDto;
>>>>>>> 268eceb (Added some changes)
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonActivityRequest extends FormRequest
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
<<<<<<< HEAD
        $this->dto = new UpdateTeacherActivitiesDto ($this->validated());
    }
}
=======
        $this->dto = new UpdateLessonActivitiesDto($this->validated());
    }
}
>>>>>>> 268eceb (Added some changes)
