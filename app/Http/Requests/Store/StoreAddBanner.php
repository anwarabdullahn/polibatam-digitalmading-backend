<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddBanner extends FormRequest
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
      'title'      => 'required',
      'image'     => 'required',
    ];
  }
  public function messages()
  {
    return [
      'title.required' => 'Judul harus diisi.',
      'image.required' => 'Banner harus diisi.',
    ];
  }

  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('banner')->withErrors($validator, 'add');
    }
  }
}
