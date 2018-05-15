<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKuesionerPost extends FormRequest
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
            'pertanyaan1'   => 'required',
            'pertanyaan2'   => 'required',
            'pertanyaan3'   => 'required',
            'pertanyaan4'   => 'required',
        ];
    }

  public function messages()
  {
    return [
        'pertanyaan1.required' => 'Pertanyaan Pertama harus diisi.',
        'pertanyaan2.required' => 'Pertanyaan Kedua harus diisi.',
        'pertanyaan3.required' => 'Pertanyaan Ketiga harus diisi.',
        'pertanyaan4.required' => 'Pertanyaan Keempat harus diisi.',
    ];
  }

  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('kuesioner')->withErrors($validator, 'update');
    }
  }
}
