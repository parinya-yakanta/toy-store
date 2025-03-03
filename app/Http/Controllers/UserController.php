<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Helpers\GoToHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'employee')->paginate(10);
        return view('pages.user.index', compact('users'));
    }

    public function profile(Request $request)
    {
        $userCode = $request->query('ref', 0);
        $user = User::where('code', $userCode)->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if (auth()->user()->role === 'employee' && auth()->user()->id !== $user->id) {
            return back()->with('error', 'You are not authorized to view this page');
        }

        return view('pages.user.profile', compact('user'));
    }

    public function create(Request $request)
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return GoToHelper::validator($validator, $validator->errors()->first());
        }

        $checkEmail = User::where('email', $request->email)->first();

        if ($checkEmail) {
            return GoToHelper::error('Email already exists');
        }

        $inputs = [
            'code' => 'EMP' . Str::upper(Str::random(3)) . date('YmdHis'),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'status' => 'active',
            'phone' => $request->phone,
            'address' => $request->address,
            'email_verified_at' => now(),
        ];

        DB::transaction(function () use ($request, $inputs) {
            $user = User::create($inputs);

            if ($request->hasFile('avatar')) {
                $avatar = CommonHelper::saveFile($request->file('avatar'), 'avatar', $user->id);
                $user->update(['avatar' => $avatar]);
            }
        });

        return GoToHelper::success('User created successfully', 'users.index');
    }

    public function update(Request $request)
    {
        $userCode = $request->query('ref', 0);
        $user = User::where('code', $userCode)->first();

        if (!$user) {
            return GoToHelper::error('User not found');
        }

        if (auth()->user()->role === 'employee' && auth()->user()->id !== $user->id) {
            return GoToHelper::error('You are not authorized to view this page');
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);

        if ($validator->fails()) {
            return GoToHelper::validator($validator, $validator->errors()->first());
        }

        $inputs = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $inputs['password'] = Hash::make($request->password);
        }

        DB::transaction(function () use ($request, $user, $inputs) {
            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    CommonHelper::deleteFile($user->avatar);
                }

                $inputs['avatar'] = CommonHelper::saveFile($request->file('avatar'), 'avatar', $user->id);
            }

            $user->update($inputs);
        });

        return GoToHelper::success('User updated successfully', 'users.edit', ['ref' => $user->code]);
    }

    public function delete(Request $request)
    {
        $userCode = $request->query('ref', 0);
        $user = User::where('code', $userCode)->first();

        if (!$user) {
            return GoToHelper::error('User not found');
        }

        DB::beginTransaction();
        try {
            $user->update(['deleted_by' => auth()->user()->id]);
            $user->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return GoToHelper::error('An error occurred while deleting the user');
        }

        return GoToHelper::success('User deleted successfully', 'users.index');
    }

    public function edit(Request $request)
    {
        $userCode = $request->query('ref', 0);
        $user = User::where('code', $userCode)->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if (auth()->user()->role === 'employee' && auth()->user()->id !== $user->id) {
            return back()->with('error', 'You are not authorized to view this page');
        }

        return view('pages.user.edit', compact('user'));
    }
}
