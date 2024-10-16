<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ShopManagerReservationRequest extends FormRequest
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
            'date' => ['required', 'date', function($attribute, $value, $fail){
                if(Carbon::parse($value)->isBefore(Carbon::today())){
                    $fail('予約日は今日以降を選択してください');
                }
            }],
            'time' => ['required', function($attribute, $value, $fail){
                $reservationDate = Carbon::parse($this->input('date'));
                $reservationTime = Carbon::createFromFormat('H:i', $value);
                if($reservationDate->isToday() && $reservationTime->isBefore(Carbon::now())){
                    $fail('予約時間は現在の時間以降を選択してください');
                }
            }],
            'numberPeople' => ['required', 'integer', 'min:1'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(){
        return [
            'date.required' => '予約日は必須です',
            'date.date' => '正しい日付を入力してください',
            'time.required' => '予約時間は必須です',
            'numberPeople.required' => '予約人数は必須です',
            'numberPeople.integer' => '予約人数は整数で入力してください',
            'numberPeople.min' => '予約人数は1人以上で指定してください',
            'user_id.required' => 'ユーザーを選択してください',
            'user_id.exists' => '指定したユーザーは存在しません',
        ];
    }
}
