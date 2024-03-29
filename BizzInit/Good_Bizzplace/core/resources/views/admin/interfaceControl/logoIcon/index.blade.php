@extends('admin.layout.master')

@push('styles')
<style media="screen">
  h3 {
    margin: 0px;
  }
</style>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Paramètre Logo & Icon </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">

          <div class="tile">
            <div class="row">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <div class="col-md-3">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h3 style="color:white"><i class="fa fa-cog"></i> Changer Images</h3>
                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.logoIcon.update')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                       <div class="row">
                         <div class="col-md-12">
                           <div class="form-group">
                              <label class="col-md-12"><strong style="text-transform: uppercase;">Logo d'en-tête </strong></label>
                              <div class="col-sm-12"><input name="logo" type="file" id="logo"></div>
                              <p class="col-md-12"><strong>[Transférez l'image 190 X 49 pour obtenir la meilleure qualité]</strong></p>
                              <label class="col-md-12"><strong style="text-transform: uppercase;">Logo de pied de page</strong></label>
                              <div class="col-sm-12"><input name="footer_logo" type="file" id="footerLogo"></div>
                              <p class="col-md-12"><strong>[Transférez l'image 190 X 49 pour obtenir la meilleure qualité]</strong></p>
                           </div>
                         </div>

                          <br>
                          <br>
                          <br>

                          <div class="col-md-12">
                            <div class="form-group">
                               <label class="col-md-12"><strong style="text-transform: uppercase;">favicon</strong></label>
                               <div class="col-sm-12"><input name="icon" type="file" id="icon"></div>
                               <p class="col-md-12"><strong>[Téléchargez l'image 25 X 25 pour une meilleure qualité]</strong></p>

                            </div>
                          </div>

                          <br>
                          <br>
                          <br>
                          <div class="col-md-12">
                            <div class="form-group">
                               <div class="col-sm-12"> <button type="submit" class="btn btn-primary btn-block">UPLOAD</button></div>
                            </div>
                          </div>

                       </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h3 style="color:white"><i class="fa fa-desktop"></i> Icône actuelle</h3>
                  </div>
                  <div class="card-body">
                    <img style="max-width:100%;" src="{{asset('assets/user/interfaceControl/logoIcon/icon.jpg')}}" alt="">
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h3 style="color:white"><i class="fa fa-desktop"></i> Logo d'en-tête</h3>
                  </div>
                  <div class="card-body">
                    <img style="max-width:100%;" src="{{asset('assets/user/interfaceControl/logoIcon/logo.jpg')}}" alt="">
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h3 style="color:white"><i class="fa fa-desktop"></i>Logo de pied de page</h3>
                  </div>
                  <div class="card-body">
                    <img style="max-width:100%;" src="{{asset('assets/user/interfaceControl/logoIcon/footer_logo.jpg')}}" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
  </main>
@endsection
