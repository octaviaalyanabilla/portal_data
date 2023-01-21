<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class JenisDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getKategori($web_kategori_data_id){
        $datakategori = KategoriData::where('web_jenis_data_id', $web_kategori_data_id)->get();
        return response()->json($datakategori);
    }

    public function index()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $jenis_datas = JenisData::get();
        return view('jenis_data.index', compact('jenis_datas'));
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

        return view('jenis_data.create', compact('data_utama'));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importData' => 'required'
        ]);

        if ($request->hasFile('importData')) {
            $path = $request->file('importData')->getRealPath();

            $jenis_data = Excel::load($path, function($reader){})->get();
            $a = collect($jenis_data);

            if (!empty($a) && $a->count()) {
                foreach ($a as $key => $value) {
                    $insert[] = [
                            'nama_jenis_data' => $value->nama_jenis_data];

                    JenisData::create($insert[$key]);

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
        $count = JenisData::where('id',$request->input('id'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('jenis_data');
        }

        $this->validate($request, [
            'nama_jenis_data' => 'required|string|max:255',
        ]);

        $jenis_data = JenisData::create($request->all());
        $kategori_data = $request->kategori_data;
        foreach ($kategori_data as $key => $value) {
            KategoriData::create([
                'web_jenis_data_id'=>$jenis_data->id,
                'nama_kategori_data'=>$value,
            ]);
        }
        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('jenis_data.index');

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

        $jenis_datas = JenisData::findOrFail($id);

        return view('jenis_data.show', compact('jenis_datas'));
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

        $jenis_datas = JenisData::findOrFail($id);
        $data_utama = DataUtama::get();
        return view('jenis_data.edit', compact('jenis_datas', 'data_utama'));
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
        JenisData::find($id)->update($request->all());

        KategoriData::where('web_jenis_data_id',$id)->delete();
        $kategori_data = $request->kategori_data;
        foreach ($kategori_data as $key => $value) {
            KategoriData::create([
                'web_jenis_data_id'=>$id,
                'nama_kategori_data'=>$value,
            ]);
        }
        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('jenis_data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JenisData::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('jenis_data.index');
    }
}
