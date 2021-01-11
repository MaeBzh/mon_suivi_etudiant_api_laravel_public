<?php

namespace App\Http\Controllers;

use App\Http\Resources\TutorResource;
use App\Models\Company;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\TutorRepository;
use App\Repositories\UserRepository;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected TutorRepository $tutorRepo;
    protected UserRepository $userRepo;
    protected AddressRepository $addressRepo;
    protected CompanyRepository $companyRepo;

    public function __construct()
    {
        $this->tutorRepo = new TutorRepository();
        $this->userRepo = new UserRepository();
        $this->addressRepo = new AddressRepository();
        $this->companyRepo = new CompanyRepository();
    }

    public function login(Request $request)
    {
        try {
            $request->validate(['email' => 'email|required', 'password' => 'required']);

            if (Auth::attempt($request->only(['email', 'password']), $request->filled('remember'))) {
                $user = User::query()->whereEmail($request->email)->first();
                if ($user) {
                    $tokenResult = $user->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'status_code' => 200,
                        'access_token' => $tokenResult,
                        'token_type' => 'Bearer',
                        'connected_user' => $user
                    ]);
                };
            } else {
                return response()->json(['status_code' => 500, 'message' => 'Bad credentials']);
            }
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
                'error' => $error,
            ]);
        }
    }

    public function register(Request $request)
    {
        try {
            $tutor = DB::transaction(function () use ($request) {
                $user = $this->userRepo->prepareAdminStore($request->input('user'));
                $companyAddress = $this->addressRepo->prepareStore($request->input('company.address'));
                $company = $this->companyRepo->prepareStore($request->input('company'), $companyAddress);
                return $this->tutorRepo->prepareStore($user, $company);
            });

            return new TutorResource($tutor);
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
                'error' => $error,
            ]);
        }
    }
}
