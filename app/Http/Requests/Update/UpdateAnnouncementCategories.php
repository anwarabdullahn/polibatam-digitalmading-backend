<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementCategories extends FormRequest
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
        'editname'         => 'required|alpha',
      ];
    }
    public function messages()
    {
      return [
        'editname.required' => 'Judul Pengumuman dibutuhkan.',
        'editname.alpha' => 'Judul Pengumuman hanya Karakter Alphabet'
      ];
    }

    public function withValidator($validator)
    {
      if ($validator->fails()) {
        return redirect()->route('announcement')->withErrors($validator, 'edit');
      }
    }
}
