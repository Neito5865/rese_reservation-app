<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        // バリデーションルールを設定
        $this->validator($request->all())->validate();

        // 新規ユーザーの作成
        $user = $this->createUser($request->all());

        // イベントを発火（メール確認などのため）
        event(new Registered($user));

        // ログイン状態にする
        auth()->login($user);

        // thanksページにリダイレクト
        return redirect()->route('verification.notice');
    }

    // バリデーションルール
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^[a-zA-Z0-9]+$/'],
        ]);
    }

    // ユーザー作成ロジック
    protected function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}
