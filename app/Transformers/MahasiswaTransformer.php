<?php

namespace App\Transformers;

use App\Mahasiswa;
use League\Fractal\TransformerAbstract;


class MahasiswaTransformer extends TransformerAbstract
{
  public function transform(Mahasiswa $mahasiswa)
  {
    return [
      'name'        => $mahasiswa->name,
      'nim'         => $mahasiswa->nim,
      'email'       => $mahasiswa->email,
      'avatar'      => url('profile/'.$mahasiswa->avatar),
      'registered'  => $mahasiswa->created_at->diffForhumans(),
    ];
  }
}
