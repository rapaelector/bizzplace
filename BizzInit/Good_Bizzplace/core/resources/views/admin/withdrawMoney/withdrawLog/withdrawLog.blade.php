@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i>HISTORIQUE</h3>
        </div>
        <ul class="app-breadcrumb breadcrumb">
           <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">TABLEAU DE BORD</a></li>
        </ul>
     </div>
     <div class="row">
        <div class="col-md-12">
            <div class="tile">
              @if (count($withdraws) == 0)
                <h3 class="text-center">AUCUNE DONNÉE DISPONIBLE !</h3>
              @else
                <div class="table-scrollable">
                   <table class="table table-bordered table-hover">
                      <thead>
                         <tr>
                            <th> # </th>
                            <th> METHODE </th>
                            <th> BOUTIQUE </th>
                            <th> AMOUNT </th>
                            <th> CHARGE </th>
                            <th> TIME </th>
                            <th> TRX # </th>
                            <th> STATUS</th>
                            <th> DETAILS </th>
                         </tr>
                      </thead>
                      <tbody>
                        @php
                          $i = 0;
                        @endphp
                        @foreach ($withdraws as $withdraw)
                        <tr class="warning">
                           <td> {{++$i}} </td>
                           <td> {{$withdraw->withdrawMethod->name}} </td>
                           <td><a target="_blank" href="{{route('admin.vendorDetails', $withdraw->vendor->id)}}">{{$withdraw->vendor->shop_name}}</a></td>
                           <td class="bold"> {{round($withdraw->amount, $gs->dec_pt)}} {{$gs->base_curr_text}} </td>
                           <td> {{round($withdraw->charge, $gs->dec_pt)}} {{$gs->base_curr_text}} </td>
                           <td> {{$withdraw->created_at->format('l jS \\of F Y h:i:s A')}}  </td>
                           <td> {{$withdraw->trx}} </td>
                           <td> {{$withdraw->status}} </td>
                           <td> <a target="_blank" href="{{route('withdrawLog.show', $withdraw->id)}}" class="btn btn-primary"> <i class="fa fa-desktop"></i> DETAILS </a> </td>
                        </tr>
                        @endforeach
                      </tbody>
                   </table>
                </div>
              @endif

               <!-- print pagination -->
               <div class="row">
                  <div class="text-center">
                     {{$withdraws->links()}}
                  </div>
               </div>
               <!-- row -->
               <!-- END print pagination -->
        </div>
     </div>
   </div>
  </main>

@endsection
