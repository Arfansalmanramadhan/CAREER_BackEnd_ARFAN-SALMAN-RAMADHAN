<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'nama_user' => 'required',
                'email' => 'required|email|unique:user',
                'username' => 'required',
                'password' => 'required|min:8|confirmed', // Menggunakan password_confirmation
                'password_confirmation' => 'required|same:password|min:8'
            ]);
            $request['password'] = Hash::make($request->password);
            $user = User::create([
                'nama_user' => $request->nama_user,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request['password'],
            ]);
            DB::commit();
            return response()->json([
                'message' => 'register berhasil ',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:username|email',
            'username' => 'required_without:email',
            'password' => 'required|min:8',

        ]);

        if ($request->filled('email')) {
            $loginType = 'email';
            $loginValue = $request->email;
        } else {
            $loginType = 'username';
            $loginValue = $request->username;
        }
        if (!Auth::attempt([$loginType => $loginValue, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Login sukses',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    public function index()
    {
        $user = User::select(
            'id',
            'nama_user',
            'email',
            'username',
            "created_at",
            "updated_at"

        )->get();
        return response()->json([
            'status'  => true,
            'data' => $user
        ]);
    }
    public function edit(string $id)
    {
        $user = User::find($id);
        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'nama_user' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('user')->ignore($id), // abaikan user yang sedang diupdate
                ],
                'username' => [
                    'required',
                    Rule::unique('user')->ignore($id),
                ],
            ]);
            $user = User::findOrFail($id);

            $user->nama_user = $request->nama_user;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->save();

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data berhasil diperbbarui",
                "data" => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "persan" => "Data gagal diperbarui",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $User = User::find($id)
            ->delete();
        return response()->json([
            "success" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }
    public function logout()
    {
        if (!Auth::check()) {
            return response()->json([
                "message" => "Anda belum masuk"
            ], 401);
        }
        auth()->user()->tokens()->delete();
        return response()->json([
            "message" => "Logout sukses"
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
}
