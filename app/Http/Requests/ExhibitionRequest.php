<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
            ],
            'category_ids' => [
                'required',
                'array',
                'min:1',
            ],
            'category_ids.*' => [
                'exists:categories,id',
            ],
            'condition' => [
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'brand_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:255',
            ],
            'price' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => '商品画像を選択してください',
            'image.image' => '商品画像を正しく選択してください',
            'image.mimes' => '商品画像はJPEGまたはPNG形式で選択してください',
            'image.max' => '商品画像は2MB以内で選択してください',

            'category_ids.required' => 'カテゴリーを選択してください',
            'category_ids.array' => 'カテゴリーを正しく選択してください',
            'category_ids.min' => 'カテゴリーを1つ以上選択してください',
            'category_ids.*.exists' => '選択されたカテゴリーが正しくありません',

            'condition.required' => '商品の状態を選択してください',

            'name.required' => '商品名を入力してください',
            'name.max' => '商品名は255文字以内で入力してください',

            'brand_name.max' => 'ブランド名は255文字以内で入力してください',

            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',

            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は数字で入力してください',
            'price.min' => '販売価格は1円以上で入力してください',
        ];
    }
}