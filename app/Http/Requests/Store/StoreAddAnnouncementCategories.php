<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddAnnouncementCategories extends FormRequest
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
      'name'      => 'required|alpha',
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'Judul Pengumuman dibutuhkan.',
      'name.alpha' => 'Judul Pengumuman hanya Karakter Alphabet'
    ];
  }

  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('category')->withErrors($validator, 'add');
    }
  }
}
