<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Register(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'sometimes',
            'fcm' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'address' => $request->address,
            'gender' => $request->gender,
            'cabang' => $request->cabang,
            'fcm' => $request->fcm,
            'shift' => $request->shift,
            'tanggal' => $request->tanggal
        ]);

        $user = User::where('email', $request->email)->first();
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        try {
            return ResponseFormmater::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Register Success');
        }

        catch(Exception $error) {
            return ResponseFormmater::error([
                'message' => 'Register Failed',
                'error' => $error
            ], 'Register Failed', 404);
        }
    }

    public function Login(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $crendetials = request(['email', 'password']);

            if(!Auth::attempt($crendetials)) {
                return ResponseFormmater::error([
                    'message' => 'Unauthorized'
                ], 'Unauthorized Failed', 404);
            }

            $user = User::where('email', $request->email)->first();

            if(!Hash::check($request->password, $user->password, [])) {
                throw new Exception('password is incorrect');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormmater::success([
                'access_token' =>  $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login Success');
        }

        catch(Exception $error) {
            return ResponseFormmater::error([
                'message' => 'Login Failed',
                'error' => $error
            ], 'Login Failed', 404);
        }
    }

    public function updateUser(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->all();

        if($request->hasFile('avatar')) {

            if($request->file('avatar')->isValid()) {
                Storage::disk('upload')->delete($user->avatar);
                $avatar = $request->file('avatar');
                $extensions = $avatar->getClientOriginalExtension();
                $userAvatar = "user/".date('YmdHis').".".$extensions;
                $uploadPath = \env('UPLOAD_PATH'). "/user";
                $request->file('avatar')->move($uploadPath, $userAvatar);
                $data['avatar'] = $userAvatar;
            }
        }

        if($request->input('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        else {
            $data = Arr::except($data,['password']);
        }

        $user->update($data);
        return ResponseFormmater::success(
            $user,
            'Update User Berhasil'
        );
    }

    public function userList (Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit',10);
        $name = $request->input('name');
        $role = $request->input('role');

        if($id) {
            $user = User::find($id);

            if($user) {
                return ResponseFormmater::success(
                    $user,
                    'Data User berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'User tidak ada',
                    404
                );
            }
        }


        $user = User::query();

        if($name) {
            $user->where('name', 'LIKE', '%' . $name . '%');
        }


        if($role) {
            $user->where('role', 'LIKE', '%' . $role . '%');
        }

        return ResponseFormmater::success(
            $user->paginate($limit),
            'List User Berhasil diambil'
        );
    }



    public function deleteUser(Request $request , $id) {
        $user = User::findOrFail($id);
        Storage::disk('upload')->delete($user->avatar);

        $user->delete();
        return ResponseFormmater::success(
            $user,
            'Data User Berhasil di delete'
        );

    }
}
