<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordPost extends FormRequest
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
      'oldpassword'         => 'required',
      'newpassword'         => 'required|min:6',
      'renewpassword'       => 'same:newpassword',
    ];
  }
  public function messages()
  {
    return [
      'oldpassword.required' => 'Password Lama Harus diisi.',
      'newpassword.required' => 'Password Baru Harus diisi.',
      'newpassword.min' => 'Password kurang dari jumlah minimal (6).',
      'renewpassword.same' => 'Password Baru Harus Sama.',
    ];
  }

  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('profile')->withErrors($validator, 'edit');
    }
  }
}
