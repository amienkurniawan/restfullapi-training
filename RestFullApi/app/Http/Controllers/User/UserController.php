<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transformInput:' . UserResource::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach (request()->query() as $query => $value) {
            $attribute = UserResource::originalAttribute($query);
            if (isset($attribute, $value)) {
                $users = $users->where($attribute, $value);
            }
        }
        if (request()->has('sort_by')) {
            $attribute = UserResource::originalAttribute(request()->sort_by);
            $users = $users->sortBy->{$attribute};
        }
        $users = self::paginate($users);
        return UserResource::collection($users)->values();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute filed is need email',
            'confirmed' => 'The :attribute filed is not same',
            'unique' => 'The :attribute field is must unique',
            'min' => 'The :attribute field must have a minimum 6 length'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),  403);
        }

        // $this->validate($request, $rules);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = $request->has('verified') && ($request->verified === true || $request->verified === 1) ? User::VERIFIED_USER : User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = $request->has('admin') && ($request->admin === true || $request->admin === 1) ? User::ADMIN_USER : User::REGULAR_USER;
        $user = User::create($data);
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            // 'admin' => 'in:' . User::ADMIN_USER . '.' . User::REGULAR_USER,
        ];

        $messages = [
            'email' => 'The :attribute filed is need email',
            'confirmed' => 'The :attribute filed is not same',
            'unique' => 'The :attribute field is must unique',
            'min' => 'The :attribute field must have a minimum 6 length',
            // 'in' => 'The :attribute must be one of the following types: ' . User::ADMIN_USER . ' : ' . User::REGULAR_USER,
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),  403);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email !== $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('only verified user can modify the admin field', 409);
            }
            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('you need to specify a different value to update', 422);
        }

        $user->save();
        return $this->showOne($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return response()->json(['data' => $users], 200);
    }

    /**
     * function to verified user 
     * 
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();

        return $this->showMessage('the account has been verirified successfully');
    }
    /**
     * function to resend verification email
     * 
     */
    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->showMessage('User Already verified');
        }
        retry(5, function () use ($user) {
            Mail::to($user->email)->send(new UserCreated($user));
        }, 1000);

        return $this->showMessage('Verification email has been Resend');
    }
}
