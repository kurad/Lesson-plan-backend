<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ClassSetupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LessonPartsController;

use App\Http\Controllers\LessonActivityController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LessonPartCompetenceController;
use App\Http\Controllers\LessonPartEvaluationController;
use App\Http\Controllers\LessonPartLearnerActivityController;
use App\Http\Controllers\LessonPartTeacherActivityController;

Route::post('/register', [AuthController::class, 'registerUser']);
Route::post('/admin/register', [UserController::class, 'registerUser'])->middleware('auth:api');;
Route::post('login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:api');
Route::get('/user/{id}', [UserManagementController::class, 'getUserDetails'])->whereNumber('id')->middleware('auth:api');
Route::get('/user/roles', [UserManagementController::class, 'getRoles']);
Route::get('/user/roles/{id}', [UserManagementController::class, 'editRole']);
Route::post('/signin', [UserController::class, 'signin']);
Route::get('get-subjects', [DropdownController::class, 'getSubjects'])->middleware('auth:api');
Route::get('get-units', [DropdownController::class, 'getUnits'])->middleware('auth:api');

Route::prefix("/v1")->group(function () {

    Route::prefix("/auth")->group(function () {
        Route::post("login", [AuthController::class, "login"]);
        Route::post("signup", [AuthController::class, "registerUser"]);
        Route::get("user", [UserController::class, "getUser"]);

        //     Route::get('profile', [AuthController::class, "profile"]);
        //     Route::put("profile/{id}", [AuthController::class, "updateProfile"]);
        //     Route::post("logout", [AuthController::class, "logout"]);
    });
    Route::prefix("user-management")->group(function () {

        Route::get("", [UserManagementController::class, "allUsers"]); // get all users
        Route::post("", [UserManagementController::class, "create"]); // create user
        Route::get("{id}", [UserManagementController::class, "getUser"])->whereNumber("id"); // get user details
        Route::get("/users", [UserManagementController::class, "getAllUsers"]);
        Route::get("department/{id}", [UserManagementController::class, "getUserDepartment"])->whereNumber("id"); // get user details
        Route::put("{id}", [UserManagementController::class, "updateUser"])->whereNumber("id"); // update user details
        Route::delete("{id}", [UserManagementController::class, "destroyUser"])->whereNumber("id"); // delete user
    });

    Route::prefix("departments")->group(function () {

        Route::get("", [DepartmentController::class, "departments"]); // get all department
        Route::post("", [DepartmentController::class, "create"]); // create user
        Route::get("{id}", [DepartmentController::class, "getDepartment"])->whereNumber("id"); // get department details
        Route::put("{id}", [DepartmentController::class, "updateDepartment"])->whereNumber("id"); // update department details
        Route::delete("{id}", [DepartmentController::class, "destroyDepartment"])->whereNumber("id"); // delete department
    });

    // Route::prefix("user-type")->group(function () {

    //     Route::get("", [UserTypeController::class, "index"]); // get all department

    //     Route::get("{id}", [UserTypeController::class, "show"])->whereNumber("id"); // get department details
    //     Route::put("{id}", [UserTypeController::class, "update"])->whereNumber("id"); // update department details
    //     Route::delete("{id}", [UserTypeController::class, "destroy"])->whereNumber("id"); // delete department
    // });

    Route::prefix("class-setup")->group(function () {

        Route::get("", [ClassSetupController::class, "index"]); // get all classes
        Route::post("", [ClassSetupController::class, "store"])->middleware('auth:api'); // create class
        Route::get("{id}", [ClassSetupController::class, "show"])->whereNumber("id"); // get class details
        Route::get("user/", [ClassSetupController::class, "userClasses"])->middleware('auth:api');
        Route::put("{id}", [ClassSetupController::class, "update"])->whereNumber("id"); // update class details
        Route::delete("{id}", [ClassSetupController::class, "destroy"])->whereNumber("id"); // delete class
    });

    Route::prefix("subject-management")->group(function () {

        Route::get("", [SubjectController::class, "index"])->middleware('auth:api'); // get all subjects
        Route::post("", [SubjectController::class, "store"])->middleware('auth:api'); // create new subject
        Route::get("detail/{id}", [SubjectController::class, "show"])->whereNumber("id")->middleware('auth:api'); // get subject details
        Route::get("user/", [SubjectController::class, "userSubjects"])->whereNumber("id")->middleware('auth:api'); // get user's subjects
        Route::get("class/{id}", [SubjectController::class, "classSubjects"])->whereNumber("id"); // get user's subjects
        Route::get("class/subject", [SubjectController::class, "classWithSubjects"])->whereNumber("id"); // get user's subjects
        Route::get("user/class/{id}", [SubjectController::class, "classUserSubjects"])->whereNumber("id")->middleware('auth:api'); // get user's subjects
        Route::put("{id}", [SubjectController::class, "update"])->whereNumber("id"); // update department details
        Route::delete("{id}", [SubjectController::class, "destroy"])->whereNumber("id"); // delete department
    });

    Route::prefix("unit-management")->group(function () {

        Route::get("", [UnitController::class, "index"]); // get all department
        Route::get("units/", [UnitController::class, "Units"]); //Get grouped units by users
        Route::post("", [UnitController::class, "store"]); // create user
        Route::get("{id}", [UnitController::class, "show"])->whereNumber("id"); // get department details
        Route::get("subject", [UnitController::class, "subjectsUnit"])->whereNumber("id")->middleware('auth:api'); 
        Route::get("user", [UnitController::class, "unitsPerUser"])->whereNumber("id")->middleware('auth:api'); 
        Route::put("{id}", [UnitController::class, "update"])->whereNumber("id"); // update department details
        Route::delete("{id}", [UnitController::class, "destroy"])->whereNumber("id"); // delete department
    });

    Route::prefix("lesson-management")->group(function () {

        Route::get("", [LessonsController::class, "index"]); // get all lessons
        Route::post("", [LessonsController::class, "store"]); // create new lesson
        Route::get("{id}", [LessonsController::class, "show"])->whereNumber("id"); // get lesson details
        Route::get("subject/{id}", [LessonsController::class, "lessonsPerUnit"])->whereNumber("id"); // get unit's lessons
        Route::put("{id}", [LessonsController::class, "update"])->whereNumber("id"); // update lesson details
        Route::delete("{id}", [LessonsController::class, "destroy"])->whereNumber("id"); // delete lesson
        Route::get("latest", [LessonsController::class, "latestLesson"])->middleware('auth:api'); 
        Route::get("lessons/user/", [LessonsController::class, "lessonsPerUser"])->middleware('auth:api'); 
        Route::get("lesson/user/{id}", [LessonsController::class, "getLessonToPlan"])->middleware('auth:api'); 
        Route::get("lesson/pdf/{id}", [LessonsController::class, "lessonPlanPDF"])->whereNumber("id"); 

        Route::get("last/", [LessonsController::class, "getLastId"]);
    });

    Route::prefix("lesson-part-management")->group(function () {

        Route::get("", [LessonPartsController::class, "index"]); // get all lessons
        Route::post("", [LessonPartsController::class, "store"]); // create new lesson
        Route::get("{id}", [LessonPartsController::class, "show"])->whereNumber("id"); // get lesson details
        Route::get("lesson/{id}", [LessonPartsController::class, "lessonPartPerLesson"])->whereNumber("id")->middleware('auth:api');

        Route::get("single/{id}", [LessonPartsController::class, "lessonPartsPerOneLesson"])->whereNumber("id");
        Route::get("get-lesson/{id}", [LessonPartsController::class, "getLessonPart"])->whereNumber("id")->middleware('auth:api');
        Route::get("activity/{id}", [LessonPartsController::class, "lessonPartsActivities"])->whereNumber("id")->middleware('auth:api');
        Route::get("parts/{id}", [LessonPartsController::class, "checkLessonParts"])->whereNumber("id");
        Route::put("{id}", [LessonPartsController::class, "update"])->whereNumber("id"); // update lesson part details
        Route::delete("{id}", [LessonPartsController::class, "destroy"])->whereNumber("id"); // delete lesson
    });

    Route::prefix("lesson-evaluation")->group(function () {

        Route::get("", [LessonPartEvaluationController::class, "index"]); // get all lessons
         Route::get("evaluations/{id}", [LessonPartEvaluationController::class, "lessonEvaluationPerUser"])->whereNumber("id")->middleware('auth:api'); 
        Route::post("", [LessonPartEvaluationController::class, "store"]); // create new lesson evaluation
        Route::get("{id}", [LessonPartEvaluationController::class, "show"])->whereNumber("id"); // get lesson details
        Route::put("{id}", [LessonPartEvaluationController::class, "update"])->whereNumber("id"); // update lesson part details
        Route::delete("{id}", [LessonPartEvaluationController::class, "destroy"])->whereNumber("id"); // delete lesson
    });

    Route::prefix("lesson-competence")->group(function () {

        Route::get("", [LessonPartCompetenceController::class, "index"]); // get all lessons
        Route::post("", [LessonPartCompetenceController::class, "store"]); // create new lesson evaluation
        Route::get("{id}", [LessonPartCompetenceController::class, "show"])->whereNumber("id"); // get lesson details
        Route::put("{id}", [LessonPartCompetenceController::class, "update"])->whereNumber("id"); // update lesson part details
        Route::delete("{id}", [LessonPartCompetenceController::class, "destroy"])->whereNumber("id"); // delete lesson
    });

    Route::prefix("teacher-activities")->group(function () {

        Route::get("", [LessonPartTeacherActivityController::class, "index"]); // get all lessons
        Route::post("", [LessonPartTeacherActivityController::class, "store"]); // create new lesson evaluation
        Route::get("{id}", [LessonPartTeacherActivityController::class, "show"])->whereNumber("id"); // get lesson details
        Route::get("teacher/activity/{id}", [LessonPartTeacherActivityController::class, "getTeacherActivities"])->whereNumber("id");
        Route::get("get-activity/{id}", [LessonPartTeacherActivityController::class, "getTeacherActivities"])->whereNumber("id");
        Route::put("{id}", [LessonPartTeacherActivityController::class, "update"])->whereNumber("id"); // update lesson part details
        Route::delete("{id}", [LessonPartTeacherActivityController::class, "destroy"])->whereNumber("id"); // delete lesson
    });

    Route::prefix("learner-activities")->group(function () {

        Route::get("", [LessonPartLearnerActivityController::class, "index"]); // get all lessons
        Route::post("", [LessonPartLearnerActivityController::class, "store"]); // create new lesson evaluation
        Route::get("{id}", [LessonPartLearnerActivityController::class, "show"])->whereNumber("id"); // get lesson details
        Route::get("learner/get-activity/{id}", [LessonPartLearnerActivityController::class, "getLearnerActivities"])->whereNumber("id");
        Route::put("{id}", [LessonPartLearnerActivityController::class, "update"])->whereNumber("id"); // update lesson part details
        Route::delete("{id}", [LessonPartLearnerActivityController::class, "destroy"])->whereNumber("id"); // delete lesson
    });

    Route::prefix("lesson-activities")->group(function () {

        Route::get("", [ActivitiesController::class, "lessonActivities"]); // get all lessons
        Route::get("activities/{id}", [ActivitiesController::class, "lessonActivitiesPerUser"])->whereNumber("id");
        Route::get("get-activity/{id}", [ActivitiesController::class, "lessonActivityPerUser"])->whereNumber("id");
        Route::get("activities/{id}", [ActivitiesController::class, "lessonActivitiesPerUser"])->whereNumber("id")->middleware('auth:api');
        Route::post("", [ActivitiesController::class, "store"]); // create new lesson evaluation
        Route::get("{id}", [ActivitiesController::class, "show"])->whereNumber("id"); // get lesson details
        Route::get("learner/get-activity/{id}", [ActivitiesController::class, "getLearnerActivities"])->whereNumber("id");
        Route::put("{id}", [ActivitiesController::class, "update"])->whereNumber("id"); // update lesson part details
        Route::put("teacher-activity/{id}", [ActivitiesController::class, "updateTeacherActivity"]);
        Route::delete("{id}", [ActivitiesController::class, "destroy"])->whereNumber("id"); // delete lesson
    });
});