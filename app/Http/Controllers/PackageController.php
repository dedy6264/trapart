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
        $c=Courier::select('id','courier_name')->get();
        
        return view('divisi.content',compact('c'));
    }

    public function store(Request $request)
    {
        // \DB::enableQueryLog(); // Enable query log

        $resi=Package::join('couriers','packages.courier_id','=','couriers.id')
        ->join('details','packages.id','=','details.package_id')
        ->where('couriers.id',$request->kurir)
        ->where('packages.resi',$request->resi)
        ->select('couriers.courier_name',
        'packages.resi',
        'packages.status',
        'details.origin',
        'details.destination',
        'details.sender',
        'details.reciever')
        ->first();
        // dd(\DB::getQueryLog()); // Show results of log
        $c=Courier::select('id','courier_name')->get();
        $listKurir=Courier::where('id',$request->kurir)->select('courier_code')->first();
        if($resi==null){
            //nembak api
            $key=env('API_KEY');
            $api="/v1/track";
            $url="https://api.binderbyte.com";
            $payload=[
                'api_key'=>$key,
                'courier'=>$listKurir->courier_code,
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
                        // $idCourier=$kurir['id'];
                        $startDate=$response['data']['summary']['date'];
                        if($response['data']['summary']['date']==""){
                            $startDate=null;
                        }
                        $savePackage=DB::table('packages')->insertGetId([
                            'courier_id'=>$request->kurir,
                            'resi'=>$response['data']['summary']['awb'],
                            'status'=>$response['data']['summary']['status'],
                            'weight'=>(int)$response['data']['summary']['weight'],
                            'amount'=>(int)$response['data']['summary']['amount'],
                            'start_date'=>$startDate,
                            'desc'=>$response['data']['summary']['desc'],
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);
                        // // dd($savePackage);
                        $idPackage=$savePackage;
                        // $saveTracking=
                        $tracking=array();
                        foreach($response['data']['history'] as $his){
                            array_push($tracking,$his);
                            // $a=json_encode($his);
                            // $b=json_decode($a);
                            // dump($a);
                            // dump($b->date);
                            // dd($b);     
                            DB::table('trackings')->insert([
                                'package_id'=>$idPackage,
                                'tracking'=>json_encode($his),
                                'created_at'=>now(),
                                'updated_at'=>now(),
                            ]);
                        }
                        
                        // dd($tracking);
                        // $saveDetail=
                        DB::table('details')->insert([
                            'package_id'=>$idPackage,
                            'origin'=>$response['data']['detail']['origin'],
                            'destination'=>$response['data']['detail']['destination'],
                            'sender'=>$response['data']['detail']['shipper'],
                            'reciever'=>$response['data']['detail']['receiver'],
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);
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
                        return view('tracking.info', compact('resi','c'));
                    
                    }
                    $resi=null;
                    return view('tracking.info', compact('resi','c'));


        }
// dd($resi->status);
if($resi->status!="DELIVERED"){
    $a=$this->update_tracking($listKurir->courier_code,$request->resi);
}
        $track=Tracking::join('packages','trackings.package_id','=','packages.id')
        ->where('packages.resi',$request->resi)
        ->select('tracking')
        ->get();
        $tracking=array();
        for ($i=0; $i <count($track); $i++) { 
            $b=$track[$i]['tracking'];
            $d=json_decode($b,true);
            array_push($tracking,$d);
        }
            $resi=array([
                'courier_name'=>$resi['courier_name'],
                'resi'=>$resi['resi'],
                'status'=>$resi['status'],
                'weight'=>$resi['weight'],
                'amount'=>$resi['amount'],
                'start_date'=>$resi['start_date'],
                'desc'=>$resi['desc'],
                'origin'=>$resi['origin'],
                'destination'=>$resi['destination'],
                'sender'=>$resi['sender'],
                'reciever'=>$resi['reciever'],
                'tracking'=>$tracking,
            ]);
    
        // }
        return view('tracking.info', compact('resi','c'));
    }
    public function cek_resi(Request $request)
    {
        dd($request);
    }
    public function update_tracking($code,$resi)
    {
        dump($code);
        dd($resi);
        $key=env('API_KEY');
            $api="/v1/track";
            $url="https://api.binderbyte.com";
            $payload=[
                'api_key'=>$key,
                'courier'=>$code,
                'awb'=>$resi,
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
                        // $idCourier=$kurir['id'];
                        $startDate=$response['data']['summary']['date'];
                        if($response['data']['summary']['date']==""){
                            $startDate=null;
                        }
                        $savePackage=DB::table('packages')->insertGetId([
                            'courier_id'=>$request->kurir,
                            'resi'=>$response['data']['summary']['awb'],
                            'status'=>$response['data']['summary']['status'],
                            'weight'=>(int)$response['data']['summary']['weight'],
                            'amount'=>(int)$response['data']['summary']['amount'],
                            'start_date'=>$startDate,
                            'desc'=>$response['data']['summary']['desc'],
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);
                        // // dd($savePackage);
                        $idPackage=$savePackage;
                        // $saveTracking=
                        $tracking=array();
                        foreach($response['data']['history'] as $his){
                            array_push($tracking,$his);
                            // $a=json_encode($his);
                            // $b=json_decode($a);
                            // dump($a);
                            // dump($b->date);
                            // dd($b);     
                            DB::table('trackings')->insert([
                                'package_id'=>$idPackage,
                                'tracking'=>json_encode($his),
                                'created_at'=>now(),
                                'updated_at'=>now(),
                            ]);
                        }
                        
                        // dd($tracking);
                        // $saveDetail=
                        DB::table('details')->insert([
                            'package_id'=>$idPackage,
                            'origin'=>$response['data']['detail']['origin'],
                            'destination'=>$response['data']['detail']['destination'],
                            'sender'=>$response['data']['detail']['shipper'],
                            'reciever'=>$response['data']['detail']['receiver'],
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);
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
                        return view('tracking.info', compact('resi','c'));
                    
                    }
                    $resi=null;
                    return view('tracking.info', compact('resi','c'));
    }
    public function send_req()
    {
        dd($request);
    }

}
