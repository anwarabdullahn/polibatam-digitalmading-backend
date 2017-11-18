<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddAnnouncement extends FormRequest
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
        'description'     => 'required',
      ];
  }

  public function withValidator($validator)
  {
    if ($validator->fails()) {
      return redirect()->route('announcement')->withErrors($validator, 'add');
    }
  }
}
