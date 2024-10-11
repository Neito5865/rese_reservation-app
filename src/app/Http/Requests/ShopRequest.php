<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'shopName' => 'required|string|max:100',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'detail' => 'required|string|',
            'shopImg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return[
            'shopName.required' => '店名を入力してください',
            'shopName.string' => '店名は文字列で入力してください',
            'shopName.max' => '100文字以内で入力してください',
            'area_id.required' => '必ず選択してください',
            'area_id.exists' => '指定したエリアは存在しません',
            'genre_id.required' => '必ず選択してください',
            'genre_id.exists' => '指定したジャンルは存在しません',
            'detail.required' => '詳細文を入力してください',
            'detail.string' => '詳細文は文字列で入力してください',
            'shopImg.image' => '指定のファイルは画像ファイルではありません',
            'shopImg.mimes' => '画像ファイルの拡張子はjpeg、png、jpg、gifのいずれかとしてください',
            'shopImg.max' => 'ファイルサイズは2MB以内の画像を登録してください',
        ];
    }
}
