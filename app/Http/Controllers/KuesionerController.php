<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Kuesioner;
use App\Pertanyaan;
use App\AuthMahasiswa;
use App\Http\Requests\Update\UpdateKuesionerPost;
use App\Transformers\PertanyaanTransformer;

class KuesionerController extends Controller
{
    public function __construct()
    {
        $this->kuesioners = Kuesioner::all();
        $this->pertanyaan = Pertanyaan::first();
    }

    public function index()
    {
        if (Auth::user()->role =='super') {
            // dd($this->pertanyaan);
            return view ('layouts.admins.mahasiswa.kuesioner')->with('pertanyaan' , $this->pertanyaan)->with('kuesioners' , $this->kuesioners);
        }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function updatePertanyaan(UpdateKuesionerPost $request)
    {
        if(Auth::user()->role=='super'){
            $pertanyaan = $this->pertanyaan;
            if($pertanyaan){
                $pertanyaan->pertanyaan1 = $request->pertanyaan1;
                $pertanyaan->pertanyaan2 = $request->pertanyaan2;
                $pertanyaan->pertanyaan3 = $request->pertanyaan3;
                $pertanyaan->pertanyaan4 = $request->pertanyaan4;
                if($pertanyaan->save()){
                    return redirect()->route('kuesioner')->with('info','Pertanyaan Kuesioner Berhasil diubah !!');
                }return redirect()->route('kuesioner')->with('gagal','Gagal Merubah Pertanyaan Kuesioner !!');
            }return redirect()->route('kuesioner')->with('gagal','Invalid Credential !!');
        }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function submitKuesioner(Request $request)
    {
        $authorization = $request->header('Authorization');
        $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
        $id = $authMahasiswa->id_mahasiswa;

        if ($authMahasiswa) {
            $kuesioner = Kuesioner::where('id_mahasiswa',  $id)->first();
            // dd($authMahasiswa->id);
            if($kuesioner){
                // dd($kuesioner);
                $kuesioner->jawaban1 = $request->jawaban1;
                $kuesioner->jawaban2 = $request->jawaban2;
                $kuesioner->jawaban3 = $request->jawaban3;
                $kuesioner->jawaban4 = $request->jawaban4;
                $kuesioner->id_mahasiswa = $id;

                if($kuesioner->save()){
                    return response()->json([
                        'message' => 'Kuesioner Berhasil diubah !'
                    ], 200);
                }return response()->json([
                    'message' => 'Kuesioner Gagal diubah !'
                ], 400);
            }

            $messsages = array(
                'id_mahasiswa.required' => 'Credential Dibutuhkan !!',
                'jawaban1.required'     => 'Jawaban Harus diisi.',
                'jawaban2.required'     => 'Jawaban Harus diisi.',
                'jawaban3.required'     => 'Jawaban Harus diisi.',
                'jawaban4.required'     => 'Jawaban Harus diisi.',
            );

            $validator = Validator::make($request->all(), [
                'id_mahasiswa'  => 'required',
                'jawaban1'      => 'required',
                'jawaban2'      => 'required',
                'jawaban3'      => 'required',
                'jawaban4'      => 'required',
            ], $messsages);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                'message' => $errors->first()
                ], 406);
            }

            $input = array(
                'id_mahasiswa'  => $id,
                'jawaban1'      => $request->jawaban1,
                'jawaban2'      => $request->jawaban2,
                'jawaban3'      => $request->jawaban3,
                'jawaban4'      => $request->jawaban4,
            );

            $submit = Kuesioner::create($input);

            if($submit){
                return response()->json([
                    'message' => 'Kuesioner Berhasil disubmit!'
                ], 201);
            }return response()->json([
                'message' => 'Gagal Submit Kuesioner !'
            ], 400);
        }
        $messageResponse['message'] = 'Invalid Credentials';
        return response($messageResponse, 401);
    }

    public function getKuesioner(Request $request)
    {
        $authorization = $request->header('Authorization');
        $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
        if ($authMahasiswa) {
            $response = fractal()
            ->item($this->pertanyaan)
            ->transformWith(new PertanyaanTransformer)
            ->toArray();

            return response()->json(array('result' => $response['data']), 200);
        }
        $messageResponse['message'] = 'Invalid Credentials';
        return response($messageResponse, 401);
    }

    public function delete(Request $request)
    {
        if (Auth::user()->role =='super') {
            $kuesioner = Kuesioner::where('id',$request->hapus_id)->first();
            if($kuesioner->delete()){
                return redirect()->route('kuesioner')->with('info','Kuesioner Berhasil dihapus !!');
            }return redirect()->route('kuesioner')->with('gagal','Kuesioner Gagal dihapus !!');
        }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }
}
