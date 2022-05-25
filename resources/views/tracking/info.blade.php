@extends('content.index')
@section('content')
 <!-- Icons Grid-->
 <section class="features-icons bg-light text-center">
    <div class="container">
@if ($resi==null)
<h3>Your package is not register</h3>
    
@else
<table>
    <thead>
        <tr>
        <td>Nama Pengiriman</td><td>{{$resi->resi;}}</td>
        </tr>
        <tr>
        <td>Tgl Pengiriman</td>
        </tr>
        <tr>
        <td>Alamat Asal</td>
        </tr>
    </thead>
    <tbody>
<tr>
<td></td>
</tr>
    </tbody>
</table>
@endif
            

    </div>
</section>
@endsection