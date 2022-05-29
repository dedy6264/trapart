@extends('content.index')
@section('content')
 <!-- Icons Grid-->
 <section class="features-icons bg-light text-center">
    <div class="container">
@if ($resi==null)
<h3>Your package is not register</h3>
    
@else
<div class="container">
    <table class="striped">
        <tbody>
            <tr>
                <td>Kurir : </td>
                <td scope="col">{{$resi[0]['courier_name']}}</td>
            </tr>
            <tr>
                <td>No Resi : </td>
                <td scope="col">{{$resi[0]['resi']}}</td>
            </tr>
            <tr>
                <td>Status : </td>
                <td scope="col">{{$resi[0]['status']}}</td>
            </tr>
            <tr>
                <td>Berat : </td>
                <td scope="col">{{$resi[0]['weight']}}</td>
            </tr>
            <tr>
                <td>Biaya : </td>
                <td scope="col">{{$resi[0]['amount']}}</td>
            </tr>
            <tr>
                <td>Tgl Kirim : </td>
                <td scope="col">{{$resi[0]['start_date']}}</td>
            </tr>
            <tr>
                <td>Asal : </td>
                <td scope="col">{{$resi[0]['origin']}}</td>
            </tr>
            <tr>
                <td>Tujuan : </td>
                <td scope="col">{{$resi[0]['destination']}}</td>
            </tr>
            <tr>
                <td>Pengirim : </td>
                <td scope="col">{{$resi[0]['sender']}}</td>
            </tr>
            <tr>
                <td>Penerima : </td>
                <td scope="col">{{$resi[0]['reciever']}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped">
        <tbody>
            @foreach ($resi[0]['tracking'] as $user)
             <tr>
                 <td>{{$user['date']}}</td>
                 <td>{{$user['desc']}}</td>
             </tr>
            @endforeach
   
        </tbody>
    </table>
</div>
@endif
            

    </div>
</section>
@endsection