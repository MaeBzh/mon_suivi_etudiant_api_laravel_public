<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DebriefController;
use App\Http\Controllers\API\DiplomaController;
use App\Http\Controllers\API\DocumentController;
use App\Http\Controllers\API\DocumentTypeController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\ScorecardController;
use App\Http\Controllers\API\SkillTemplateController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TutorController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/addresses', AddressController::class);
    Route::apiResource('/companies', CompanyController::class);
    Route::apiResource('/contacts', ContactController::class);
    Route::apiResource('/debriefs', DebriefController::class);
    Route::apiResource('/tutors', TutorController::class);
    Route::apiResource('/schools', SchoolController::class);
    Route::apiResource('/students', StudentController::class);
    Route::apiResource('/skillTemplates', SkillTemplateController::class);
    Route::apiResource('/diplomas', DiplomaController::class);
    Route::apiResource('/documentTypes', DocumentTypeController::class);
    Route::apiResource('/documents', DocumentController::class);
    Route::apiResource('/scorecards', ScorecardController::class);
});
