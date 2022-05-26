@extends('content.index')
@section('content')
 <!-- Icons Grid-->
 <section class="features-icons bg-light text-center">
    <div class="container">
@if ($resi==null)
<h3>Your package is not register</h3>
    
@else
<table border='1'>
    <thead>
        <tr>
        <td>Nama Pengiriman</td><td>{{$resi[0]['courier_name']}}</td>
        </tr>
        <tr>
        <td>Tgl Pengiriman</td><td>{{$resi[0]['start_date']}}</td>
        </tr>
        <tr>
        <td>Alamat Asal</td><td></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($resi[0]['tracking'] as $user)
   <tr>
       <td>{{$user['date']}}</td>
       <td>{{$user['desc']}}</td>
   </tr>
@endforeach

    </tbody>
</table>
@endif
            

    </div>
</section>
@endsection