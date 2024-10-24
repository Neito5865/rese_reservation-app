<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'amount' => 'required|numeric|min:1',
            'shop_id' => 'required|exists:shops,id',
            'stripeToken' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'amount.required' => '金額を入力してください',
            'amount.numeric' => '金額は数値で入力してください',
            'amount.min' => '金額は1円以上である必要があります',
            'shop_id.required' => '店舗を選択してください',
            'shop_id.exists' => '選択された店舗は無効です',
            'stripeToken.required' => '決済に必要なトークンが見つかりません',
        ];
    }
}
