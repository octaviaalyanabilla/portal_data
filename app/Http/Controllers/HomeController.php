<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use App\Models\TahunData;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        $datautama = DataUtama::get();
        $jenisdata = JenisData::get();
        $kategoridata = KategoriData::get();
        $tahundata = TahunData::get();
        return view('home', compact('datautama','users','jenisdata','kategoridata','tahundata'));
    }
}
