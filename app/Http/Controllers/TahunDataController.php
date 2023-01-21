<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TahunData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TahunDataController extends Controller
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

    public function index()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $tahun_data = TahunData::get();
        return view('tahun_data.index', compact('tahun_data'));
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

        $tahun_data = TahunData::get();
        return view('tahun_data.create', compact('tahun_data'));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importData' => 'required'
        ]);

        if ($request->hasFile('importData')) {
            $path = $request->file('importData')->getRealPath();

            $tahun_data = Excel::load($path, function($reader){})->get();
            $a = collect($tahun_data);

            if (!empty($a) && $a->count()) {
                foreach ($a as $key => $value) {
                    $insert[] = [
                            'tahun_data' => $value->tahun_data];

                    TahunData::create($insert[$key]);
                        
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
        $this->validate($request, [
            'tahun_data' => 'required|string|max:255'
        ]);

        TahunData::create([
                'tahun_data' => $request->get('tahun_data'),
            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');

        return redirect()->route('tahun_data.index');

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

        $tahun_data = TahunData::findOrFail($id);

        return view('tahun_data.show', compact('tahun_data'));
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

        $tahun_data = TahunData::findOrFail($id);
        return view('tahun_data.edit', compact('tahun_data'));
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
        TahunData::find($id)->update([
            'tahun_data' => $request->get('tahun_data')
        ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('tahun_data.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TahunData::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('tahun_data.index');
    }
}
