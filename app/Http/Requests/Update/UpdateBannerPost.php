<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerPost extends FormRequest
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
      'edittitle'      => 'required',
    ];
  }
  public function messages()
  {
    return [
      'edittitle.required' => 'Judul harus diisi.',
    ];
  }
  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('banner')->withErrors($validator, 'edit');
    }
  }
}
