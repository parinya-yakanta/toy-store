<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        $checkAuth = Auth::user();
        if ($checkAuth) {
            return to_route('dashboard.index');
        }

        return view('pages.auth.login');
    }

    public function loginStore(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required|min:8|max:20',
                ],
                [
                    'email.required' => 'Please enter your email.',
                    'password.required' => 'Please enter your password',
                    'password.regex' => 'The password must be at least 8 characters',
                ]
            );

            if ($validator->fails()) {
                flash()->addWarning($validator->errors()->first());

                return back()->withInput()->withErrors($validator->errors());
            }

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                flash()->addWarning('Invalid email and password.');

                return back()->withInput()->withErrors($validator->errors());
            }

            $credentials = ['email' => $user->email, 'password' => $request->password];
            $attempt = Auth::attempt($credentials, $request->filled('remember'));

            if (! $attempt) {
                flash()->addWarning("Can't sign in because email or password is wrong.");

                return back()->withInput()->withErrors($validator->errors());
            }

            DB::beginTransaction();

            $update = $user->update(['last_login' => Carbon::now(), 'ip' => $request->ip()]);

            if (! $update) {
                DB::rollBack();

                return back();
            }

            DB::commit();

            return to_route('auth.login');
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function forgot(Request $request)
    {
        $checkAuth = Auth::user();
        if ($checkAuth) {
            return to_route('dashboard.index');
        }

        return view('pages.auth.forgot');
    }

    public function forgotStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users',
            ]
        );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();

        $token = Str::random(64);

        $checkCreateToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if ($checkCreateToken) {
            $createTime = Carbon::parse($checkCreateToken->created_at);
            $addTime = $createTime->addMinutes(5);
            $diffTime = Carbon::parse($addTime)->format('Y-m-d H:i:s');
            $now = Carbon::now()->format('Y-m-d H:i:s');

            if ($now < $diffTime) {
                return back()->with('fail', "We've emailed you a link to reset your password. Please wait 5 minutes for subsequent submissions.");
            } else {
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            }
        }

        $createToken = DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        if (! $createToken) {
            DB::rollBack();

            return back()->with('fail', 'create token fail!');
        }

        $sendEmail = Mail::send('emails.forgot-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->from(env('MAIL_FROM_ADDRESS', 'no-reply@mailjet.xxx.dev'), 'Toy Store');
            $message->subject('Reset Password Toy Store');
        });

        if (! $sendEmail) {
            DB::rollBack();

            return back()->with('fail', 'send email fail!');
        }

        DB::commit();

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function resetPassword($token)
    {
        $checkCreateToken = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (! $checkCreateToken) {
            return to_route('auth.forgot');
        }

        return view('pages.auth.reset-password', ['token' => $token, 'email' => $checkCreateToken->email]);
    }

    public function resetPasswordStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ]
        );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();

        $checkEmailToken = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])->first();

        if (! $checkEmailToken) {
            return back()->withInput()->with('fail', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            DB::rollBack();

            return back()->withInput()->with('fail', 'user not found!');
        }

        $updatePassword = $user->update(['password' => Hash::make($request->password)]);

        if (! $updatePassword) {
            DB::rollBack();

            return back()->withInput()->with('fail', 'update password fail!');
        }

        $removeToken = DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        if (! $removeToken) {
            DB::rollBack();

            return back()->withInput()->with('fail', 'update password fail!');
        }

        $credentials = ['email' => $request->email, 'password' => $request->password];
        $attempt = Auth::attempt($credentials);

        if (! $attempt) {
            flash()->addWarning("Can't sign in because email or password is wrong.");

            return to_route('auth.login');
        }

        $updateLogin = $user->update(['last_login' => Carbon::now(), 'ip' => $request->ip()]);

        if (! $updateLogin) {
            DB::rollBack();

            return back()->withInput()->with('fail', 'update login fail!');
        }

        DB::commit();

        return to_route('auth.login');
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();

        return to_route('auth.login');
    }
}
