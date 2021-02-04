<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetStoreRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\EmailConfirm;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ConfirmEmailNotification;
use App\Notifications\ResetPasswordNotification;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmailConfirmRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\TutorRepository;
use App\Repositories\UserRepository;
use DB;
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
    protected PasswordResetRepository $passResetRepo;
    protected EmailConfirmRepository $emailConfirmRepo;

    public function __construct()
    {
        $this->tutorRepo = new TutorRepository();
        $this->userRepo = new UserRepository();
        $this->addressRepo = new AddressRepository();
        $this->companyRepo = new CompanyRepository();
        $this->passResetRepo = new PasswordResetRepository();
        $this->emailConfirmRepo = new EmailConfirmRepository();
    }

    public function login(LoginRequest $request)
    {
        $remember = $request->filled('remember');
        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $user = User::query()->whereEmail($request->input('email'))->first();
            if ($user) {
                return $user->generateAuthResponse($remember);
            };
        }

        throw new AuthenticationException('Bad credentials');
    }

    public function remember(Request $request)
    {
        if ($request->filled('remember')) {
            $remember = $request->input('remember');
            // transform cookie
            $recaller = new Recaller($remember);
            /** @var UserProvider $userProvider */
            $userProvider = Auth::guard()->getProvider();
            /** @var User $user */
            $user = $userProvider->retrieveByToken($recaller->id(), $recaller->token());
            if ($user) {
                return $user->generateAuthResponse();
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
            $this->tutorRepo->prepareStore($user, $company);
            $emailConfirm = $this->emailConfirmRepo->prepareStore(['email' => $user->email, 'url' => $request->url]);
            $user->notify(new ConfirmEmailNotification($emailConfirm));
            return response()->json();
        });
    }

    public function confirmEmail(string $token)
    {
        return DB::transaction(function () use ($token){
            $emailConfirm = EmailConfirm::whereToken($token)->firstOrFail();
            $user = User::whereEmail($emailConfirm->email)->firstOrFail();
            $this->userRepo->setModel($user)->activeAccount();
            $this->userRepo->setModel($user)->verifyAccount();
            return redirect()->away($emailConfirm->url)->with(['token'=> $token, 'email' => $user->email]);
        });
    }

    public function resetPasswordRequestToken(PasswordResetStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::whereEmail($request->email)->first();
            if ($user) {
                $this->passResetRepo->prepareStore($request->all());

                $user->notify(new ResetPasswordNotification($user));
            }
        });

        return response()->json([
            'status_code' => 200,
            'email' => $request->email,
            'message' => 'A reset link has been sent at ' . $request->email
        ]);
    }

    public function validateRequestPassword(string $token)
    {
        $passwordReset = PasswordReset::whereToken($token)->firstOrFail();
        return redirect()->away($passwordReset->url)->with('token', $token);
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $passwordReset = PasswordReset::whereToken($request->token)->first();
        if ($passwordReset) {
            /** @var User $user */
            $user = User::query()->with('tutor')->whereEmail($passwordReset->email)->first();
            if ($user && $user->tutor) {
                $updatedUser = $this->userRepo->setModel($user)->prepareUpdatePassword(['password' => $request->password]);
                return $updatedUser->generateAuthResponse();
            }
        }

        throw new AuthenticationException('Token is not valid');
    }
}
