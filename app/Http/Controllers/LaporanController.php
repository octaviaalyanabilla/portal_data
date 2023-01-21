<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use App\Models\InputData;
use App\Models\TahunData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
        $this -> middleware('auth');
    }

    public function data() {
        return view('laporan.data');
    }

    public function dataPdf() {

        $users = User::get();
        $data_utama = DataUtama::get();
        $jenis_data = JenisData::get();
        $kategori_data = KategoriData::get();
        $tahun_data = TahunData::get();
        $input_data = InputData::get();
        $pdf = PDF::loadView('laporan.data_pdf', compact('data_utama','users','jenis_data','kategori_data','tahun_data', 'input_data'));
        return $pdf -> download('laporan_data_'.date('Y-m-d_H-i-s').
            '.pdf');
    }
}