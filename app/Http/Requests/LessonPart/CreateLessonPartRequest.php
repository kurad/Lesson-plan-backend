<?php

namespace App\Http\Requests\LessonPart;

use App\DTO\LessonParts\CreateLessonPartDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class CreateLessonPartRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            "type" => 'required|string',
            "duration" => "required|integer",
            "lessonId" => "required|integer",
        ];
    }
    public function passedValidation()
    {
        $this->dto = new CreateLessonPartDto($this->validated());
    }
}