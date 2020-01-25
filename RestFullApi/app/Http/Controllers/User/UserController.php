<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Log;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users, 200);
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
        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::findOrFail($id);
        return $this->showOne($users, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $users)
    {
        Log::debug($request->all());
        Log::info($users->id);
        $rules = [
            'email' => 'email|unique:users,email,' . $users->id,
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
            $users->name = $request->name;
        }

        if ($request->has('email') && $users->email !== $request->email) {
            $users->verified = User::UNVERIFIED_USER;
            $users->verification_token = User::generateVerificationCode();
            $users->email = $request->email;
        }

        if ($request->has('password')) {
            $users->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$users->isVerified()) {
                return $this->errorResponse('only verified user can modify the admin field', 409);
            }
            $users->admin = $request->admin;
        }

        if (!$users->isDirty()) {
            return $this->errorResponse('you need to specify a different value to update', 422);
        }
        $users->save();
        return response()->json(['data' => $users], 200);
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
     * @param string $tokent
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
}
