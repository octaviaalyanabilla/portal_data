<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use App\Models\TahunData;
use App\Models\InputData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class CekDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('auth');
    }

    // ajax calling helper
    public function getJenis($web_jenis_data_id){
        $data = JenisData::where('web_data_utama_id', $web_jenis_data_id)->get();
        return response()->json($data);
    }
     public function getKategori($web_kategori_data_id){
        $datakategori = KategoriData::where('web_jenis_data_id', $web_kategori_data_id)->get();
        return response()->json($datakategori);
    }
    //end ajax calling helper
    public function index()
    {
        // if(Auth::user()->level == 'admin_user') {
        //     Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
        //     return redirect()->to('/');
        // }

        $cek_datas = InputData::get();
        $data_utama = DataUtama::all();
        $jenis_data = JenisData::all();
        $kategori_data = KategoriData::all();
        $tahun_data = TahunData::all();
        return view('cek_data.cekdata', compact('cek_datas', 'tahun_data', 'data_utama', 'jenis_data', 'kategori_data'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data_utama = DataUtama::all();
        $jenis_data = JenisData::all();
        $kategori_data = KategoriData::all();
        $tahun_data = TahunData::all();
        return view('cek_data.create', compact('data_utama', 'jenis_data', 'kategori_data', 'tahun_data'));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importData' => 'required'
        ]);

        if ($request->hasFile('importData')) {
            $path = $request->file('importData')->getRealPath();

            $cek_data = Excel::load($path, function($reader){})->get();
            $a = collect($cek_data);

            if (!empty($a) && $a->count()) {
                foreach ($a as $key => $value) {
                    $insert[] = [
                            'jumlah_data' => $value->jumlah_data,];

                    InputData::create($insert[$key]);
                        
                    }
            };
        }
        alert()->success('Berhasil.','Data telah diimport!');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = InputData::where('id',$request->input('id'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('cek_data');
        }

        $this->validate($request, [
            'jumlah_data' => 'required|string|max:255',
        ]);

        InputData::create($request->all());

        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('cek_data.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $cek_datas = InputData::findOrFail($id);

        return view('cek_data.show', compact('cek_datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $cek_data = InputData::findOrFail($id);
        $data_utama = DataUtama::get();
        $jenis_data = JenisData::get();
        $kategori_data = KategoriData::get();
        $tahun_data = TahunData::get();
        return view('cek_data.edit', compact('cek_data', 'jenis_data', 'data_utama', 'kategori_data', 'tahun_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        InputData::find($id)->update($request->all());

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('cek_data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InputData::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('cek_data.index');
    }
}
