<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'question_content' => 'required|max:1000',
            'other_information' => 'required|max:1000',
            'impression' => 'required|max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'question_content' => '面接で聞かれた質問',
            'other_information' => 'その他情報',
            'impression' => '所感・アドバイス等'
        ];
    }
}
