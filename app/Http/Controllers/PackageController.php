<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\{Package,Courier,Tracking,Detail};
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
        // $savePackage=DB::table('packages')->insertGetId([
        //     'courier_id'=>1,
        //     'resi'=>"2345erwerw34",
        //     'status'=>"DELIVERED",
        //     'weight'=>0,
        //     'amount'=>0,
        //     'start_date'=>"2022-09-09 00:00:00",
        //     'desc'=>"",
        // ]);
        // dd($savePackage);
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
        $listKurir=Courier::select('courier_name','id')->get()->toArray();
        // dd(json_encode($listKurir));
// foreach($listKurir as $kurir){
//     echo $kurir;
// }
        //jika tidak ditemukan di db->check api
        if($resi==null){
            //nembak api
            $key=env('API_KEY');
            $api="/v1/track";
            $url="https://api.binderbyte.com";
            foreach($listKurir as $kurir){
                        // dump($kurir['courier_name']);
                $courier=$kurir['courier_name'];
                $payload=[
                    'api_key'=>$key,
                    'courier'=>$courier,
                    'awb'=>$request->resi,
                ];
                $response = Http::get($url.$api,$payload)->json();
                // dd($response['data']['summary']['status']);
                        //jika status success
                        // dd($response['data']['history'][3]);

                    if($response['status']=="200"){
                        // dd($response['data']['summary']);
                        //jika status terkirim
                        // if($response['data']['summary']['status']=="DELIVERED"){
                            //check apakah corier sudah tersimpan
                            // $courier=Courier::Where('courier_name',$response['data']['summary']['courier'])
                            // ->select('*')
                            // ->get();
                            // if($courier->courier_name==null){
                                //simpan nama courier jka tidak ditemukan
                                // $saveCourier=Courier::create([
                                //     'courier_name'=>$response['data']['summary']['courier'],
                                //     'courier_code'=>$response['data']['summary']['courier'],
                                // ]);
                        $idCourier=$kurir['id'];
                        $startDate=$response['data']['summary']['date'];
                        if($response['data']['summary']['date']==""){
                            $startDate=null;
                        }
                        // $savePackage=DB::table('packages')->insertGetId([
                        //     'courier_id'=>$idCourier,
                        //     'resi'=>$response['data']['summary']['awb'],
                        //     'status'=>$response['data']['summary']['status'],
                        //     'weight'=>(int)$response['data']['summary']['weight'],
                        //     'amount'=>(int)$response['data']['summary']['amount'],
                        //     'start_date'=>$startDate,
                        //     'desc'=>$response['data']['summary']['desc'],
                        //     'created_at'=>now(),
                        //     'updated_at'=>now(),
                        // ]);
                        // dd($savePackage);
                        // $idPackage=$savePackage;
                        // $saveTracking=
                        $tracking=array();
                        foreach($response['data']['history'] as $his){
                            array_push($tracking,$his);
                            // DB::table('trackings')->insert([
                            //     'package_id'=>$idPackage,
                            //     'tracking'=>json_encode($his),
                            //     'created_at'=>now(),
                            //     'updated_at'=>now(),
                            // ]);
                        }
                        
                        // dd($tracking);
                        // $saveDetail=
                        // DB::table('details')->insert([
                        //     'package_id'=>$idPackage,
                        //     'origin'=>$response['data']['detail']['origin'],
                        //     'destination'=>$response['data']['detail']['destination'],
                        //     'sender'=>$response['data']['detail']['shipper'],
                        //     'reciever'=>$response['data']['detail']['receiver'],
                        //     'created_at'=>now(),
                        //     'updated_at'=>now(),
                        // ]);
                        // dd($tracking);
                        
                        $resi=array([
                            'courier_name'=>$response['data']['summary']['courier'],
                            'resi'=>$response['data']['summary']['awb'],
                            'status'=>$response['data']['summary']['date'],
                            'weight'=>$response['data']['summary']['weight'],
                            'amount'=>$response['data']['summary']['amount'],
                            'start_date'=>$response['data']['summary']['date'],
                            'desc'=>$response['data']['summary']['desc'],
                            'origin'=>$response['data']['detail']['origin'],
                            'destination'=>$response['data']['detail']['destination'],
                            'sender'=>$response['data']['detail']['shipper'],
                            'reciever'=>$response['data']['detail']['receiver'],
                            'tracking'=>$tracking,
                        ]);
                        // dd($resi);
                        return view('tracking.info', compact('resi'));
                            // }
                            
                        // }
                    }
            }
            return view('tracking.info', compact('resi'));

        }
        return view('tracking.info', compact('resi'));
    }
    public function cek_resi(Request $request)
    {
        dd($request);
    }

}
