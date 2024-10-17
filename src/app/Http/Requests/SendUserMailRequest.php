<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendUserMailRequest extends FormRequest
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
        return [
            'to' => 'required|email',
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
        ];
    }

    public function messages()
    {
        return[
            'to.required' => 'メールアドレスを入力してください',
            'to.email' => 'メールアドレスはメール形式で入力してください',
            'subject.required' => '件名を入力してください',
            'subject.string' => '件名は文字列で入力してください',
            'subject.max' => '100文字以内で入力してください',
            'message.required' => '本文を入力してください',
            'message.string' => '本文は文字列で入力してください',
        ];
    }
}
