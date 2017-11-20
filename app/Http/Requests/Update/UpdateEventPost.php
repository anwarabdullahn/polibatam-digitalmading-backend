<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventPost extends FormRequest
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
         'edittitle'         => 'required',
         'editdescription'   => 'required',
         'editimage'         => 'nullable',
       ];
     }
     public function messages()
     {
       return [
         'edittitle.required' => 'Judul Event dibutuhkan.',
         // 'image.max' => 'Thumnail Event dibutuhkan.',
         'editimage.required' => 'Deskripsi Event dibutuhkan.',
       ];
     }

     public function withValidator($validator)
     {
       if ($validator->fails()) {
         return redirect()->route('event')->withErrors($validator, 'edit');
       }
     }
}
