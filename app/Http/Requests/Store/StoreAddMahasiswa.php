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
         'nim'       => 'required|unique:mahasiswas',
         'name'      => 'required',
         'email'     => 'required|email|unique:mahasiswas',
         'password'  => 'required|min:6'
       ];
     }

     public function messages()
     {
       return [
         'name.required'      => 'Nama Harus diisi.',
         'email.required'     => 'Alamat Email Harus diisi.',
         'email.email'        => 'Alamat Email tidak valid.',
         'email.unique'       => 'Alamat Email telah digunakan.',
         'nim.required'       => 'NIM Harus diisi.',
         'nim.unique'         => 'NIM telah digunakan.',
         'password.required'  => 'Password Harus diisi.',
         'password.min'       => 'Password minimal 6 karakter.',
       ];
     }

     public function withValidator($validator)
     {
       if ($validator->fails()) {
         $errors = $validator->errors();
         // dd($errors);
         foreach ($errors->all() as $message) {
           return response()->json([
            'message' => $errors
           ], 406);
           break;
         }
       }
     }
}
