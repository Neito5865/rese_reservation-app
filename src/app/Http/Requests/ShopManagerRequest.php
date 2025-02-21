<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $managerId = $this->route('manager_id');

        $rules = [
            'name' => 'required|string|max:191',
            'email' => [
                'required','string','email','max:191',Rule::unique('users')->ignore($managerId),
            ],
        ];

        if($this->isMethod('post')){
            $rules['password'] = [
                'required',
                'string',
                'min:8',
                'max:191',
                'regex:/^[a-zA-Z0-9]+$/',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return[
            'name.required' => '名前を入力してください',
            'name.string' => '名前は文字列で入力してください',
            'name.max' => '191文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスは文字列で入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'email.max' => '191文字以内で入力してください',
            'email.unique' => '指定のメールアドレスは既に登録されています',
            'password.required' => 'パスワードを入力してください',
            'password.string' => 'パスワードは文字列で入力してください',
            'password.min' => '8文字以上で入力してください',
            'password.max' => '191文字以内で入力してください',
            'password.regex' => 'パスワードには半角英数字のみを使用してください',
        ];
    }
}
