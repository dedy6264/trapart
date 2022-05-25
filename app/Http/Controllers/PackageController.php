<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('tracking.info');
        return view('divisi.content');
    }

    public function store(Request $request)
    {
        $resi=Package::join('couriers','packages.courier_id','=','couriers.id')
        ->join('trackings','packages.id','=','trackings.package_id')
        ->where('packages.resi',$request->resi)
        ->select('couriers.courier_name','packages.resi','packages.status','trackings.tracking')
        ->first();
        if($resi==null){
//nembak api
$url="https://api.binderbyte.com";
            $response = Http::withBody(
                base64_encode($photo), 'image/jpeg'
            )
            ->post($url,[
                'name'=>'uhyiuewhfiuwe',
            ]);




        return view('tracking.info', compact('resi'));
        }
        return view('tracking.info', compact('resi'));
    }
    public function cek_resi(Request $request)
    {
        dd($request);
    }

}
