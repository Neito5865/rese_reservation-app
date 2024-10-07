<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'is_anonymous' => 'required',
            'evaluation' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return[
            'is_anonymous.required' => '必ず選択してください',
            'evaluation.required' => '評価を選択してください',
            'comment.string' => 'コメントは文字列で入力してください',
            'comment.max' => 'コメントは1000文字以内で入力してください',
        ];
    }
}
