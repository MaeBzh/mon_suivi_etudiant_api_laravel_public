<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TutorResource;
use App\Models\Company;
use App\Models\Tutor;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\TutorRepository;
use App\Repositories\UserRepository;
use DB;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Recaller;
use Illuminate\Contracts\Auth\UserProvider;
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

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password'], $request->filled('remember')))) {
            $user = User::query()->whereEmail($request->email)->firstOrFail();
            $tutor = Tutor::query()->where('user_id', $user->getKey())->firstOrFail();
            if ($tutor) {
                $data = [
                    'status_code' => 200,
                    'access_token' => $user->createToken('authToken')->plainTextToken,
                    'token_type' => 'Bearer',
                    'connected_user' => $tutor
                ];

                if ($request->filled('remember')) {
                    $data['remember'] = $user->getAuthIdentifier() . '|' . $user->getRememberToken() . '|' . $user->getAuthPassword();
                }

                return response()->json($data);
            };
        }

        throw new AuthenticationException('Bad credentials');
    }

    public function remember(Request $request)
    {
        if ($request->filled('remember')) {
            $remember = $request->input('remember');
            $recaller = new Recaller($remember);
            /** @var UserProvider $userProvider */
            $userProvider = Auth::guard()->getProvider();
            /** @var User $user */
            $user = $userProvider->retrieveByToken($recaller->id(), $recaller->token());
            if ($user) {
                $tutor = Tutor::query()->where('user_id', $user->getKey())->first();
                if ($tutor) {
                    $tokenResult = $user->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'status_code' => 200,
                        'access_token' => $tokenResult,
                        'token_type' => 'Bearer',
                        'connected_user' => $tutor
                    ]);
                }
            }
        }
        
        throw new AuthenticationException('Token has expired');
    }

    public function register(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $this->userRepo->prepareAdminStore($request->input('user'));
            $companyAddress = $this->addressRepo->prepareStore($request->input('company.address'));
            $company = $this->companyRepo->prepareStore($request->input('company'), $companyAddress);
            $tutor = $this->tutorRepo->prepareStore($user, $company);
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'connected_user' => $tutor
            ]);
        });
    }
}
