<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Unit;

class DropdownController extends Controller
{
    public function getSubjects()
    {
        $userId = Auth::user()->id;
        $subjects = Subject::join('class_setups','class_setups.id','=','subjects.class_id')
                            ->where("class_setups.user_id", "=", $userId)

        //where("user_id", "=", $userId)
                            ->get(['class_setups.name as className','subjects.name as subjectName','subjects.id']);

        return response()->json($subjects);
    }

    public function getUnits(Request $request)
    {
        $data = Unit::where('subject_id',$request->subject_id)->get();

        return response()->json($data);
    }
}
