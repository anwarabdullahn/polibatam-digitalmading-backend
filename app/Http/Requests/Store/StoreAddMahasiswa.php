<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddMahasiswa extends FormRequest
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
      'nim'       => 'required|unique:mahasiswas|numeric',
      'name'      => 'required',
      'email'     => 'required|email|unique:mahasiswas',
      'reemail'     => 'same:email',
      'password'  => 'required|min:6',
      'repassword'  => 'same:password',
      'verified'  => 'required',
    ];
  }

  public function messages()
  {
    return [
      'nim.required'       => 'NIM Harus diisi.',
      'nim.numeric'       => 'NIM Harus Angka.',
      'nim.unique'         => 'NIM telah digunakan.',
      'name.required'      => 'Nama Harus diisi.',
      'email.required'     => 'Alamat Email Harus diisi.',
      'email.email'        => 'Alamat Email tidak valid.',
      'email.unique'       => 'Alamat Email telah digunakan.',
      'reemail.same'       => 'Alamat Email Harus Sama.',
      'password.required'  => 'Password Harus diisi.',
      'password.min'       => 'Password minimal 6 karakter.',
      'repassword.same'    => 'Password Harus Sama.',
      'verified.required'  => 'Silahkan Pilih Status.',
    ];
  }

  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('mahasiswa')->withErrors($validator, 'add');
    }
  }
}
