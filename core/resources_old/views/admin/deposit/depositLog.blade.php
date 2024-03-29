@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1><i class="fa fa-dashboard"></i>Historique des depôts</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
           <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Tableau de bord</a></li>
        </ul>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($deposits) == 0)
            <div class="tile">
              <h2 class="text-center">Aucun depôt trouvé</h2>
            </div>
          @else
            <div class="tile">
               <h3 class="tile-title pull-left">Liste de depôt</h3>
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Serial</th>
                           <th scope="col">Boutique</th>
                           <th scope="col">Passerelle</th>
                           <th scope="col">Montant</th>
                           <th scope="col">Livraison</th>
                           <th scope="col">Montant USD</th>
                           <th scope="col">Transaction ID</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($deposits as $deposit)
                         <tr>
                           <td>{{++$i}}</td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.vendorDetails', $deposit->vendor_id)}}">{{$deposit->vendor->shop_name}}</a></td>
                            <td data-label="Email">{{$deposit->gateway->main_name}}</td>
                            <td data-label="Nom utilisateur">{{round($deposit->amount, $gs->dec_pt)}} {{$gs->base_curr_text}}</td>
                            <td data-label="Mobile">{{round($deposit->charge, $gs->dec_pt)}} {{$gs->base_curr_text}}</td>
                            <td data-label="Balance">{{round($deposit->usd_amo, $gs->dec_pt)}} USD</td>
                            <td  data-label="Details">{{$deposit->trx}}</td>
                         </tr>
                       @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="text-center">
                 {{$deposits->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
