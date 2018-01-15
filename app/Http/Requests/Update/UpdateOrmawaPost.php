<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrmawaPost extends FormRequest
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
      'editname'      => 'required',
      'editemail'     => 'required|email|unique:users,email,'.$this->edit_id.',id',
      'editnotelpon'  => 'nullable|numeric',
      'editpassword'  => 'nullable|min:6',
      'editconfirm_password' => 'same:editpassword'
    ];
  }
  
  public function messages()
  {
    return [
      'editname.required' => 'Nama Ormawa harus diisi.',
      'editemail.required' => 'Email harus diisi.',
      'editemail.email' => 'Email harus dalam format email.',
      'editemail.unique' => 'Email telah dipakai.',
      'editnotelpon.numeric' => 'Nomor telfon harus angka.',
      'editpassword.min' => 'Password kurang dari jumlah minimal (6).',
      'editconfirm_password.same' => 'Password konfirmasi harus sama.',
      'editconfirm_email.same' => 'Email konfirmasi harus sama.',
    ];
  }

  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('ormawa')->withErrors($validator, 'edit');
    }
  }
}
