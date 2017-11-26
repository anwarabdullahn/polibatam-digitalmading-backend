<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddOrmawa extends FormRequest
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
           'nama'      => 'required',
           'email'     => 'required|email|unique:users,email',           
           'confirm_email' => 'same:email',
           'password'  => 'required|min:6',
           'confirm_password' => 'same:password'
         ];
     }

     public function messages()
     {
       return [
         'nama.required' => 'Nama Ormawa harus diisi.',
         'email.required' => 'Email harus diisi.',
         'email.email' => 'Email harus dalam format email.',
         'email.unique' => 'Email telah dipakai.',
         'password.required' => 'Password harus diisi.',
         'password.min' => 'Password kurang dari jumlah minimal.',
         'confirm_email.same' => 'Email konfirmasi harus sama.',
         'confirm_password.same' => 'Password konfirmasi harus sama.',
       ];
     }

     public function withValidator($validator)
     {
       if ($validator->fails()) {
         return redirect()->route('ormawa')->withErrors($validator, 'add');
       }
     }
}
