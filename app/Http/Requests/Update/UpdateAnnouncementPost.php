<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementPost extends FormRequest
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
          'edittitle'         => 'required',
          'editdescription'   => 'required',
          'editimage'         => 'nullable',
        ];
    }
    public function withValidator($validator)
    {
      if ($validator->fails()) {
        return redirect()->route('announcement')->withErrors($validator, 'edit');
      }
    }
}
