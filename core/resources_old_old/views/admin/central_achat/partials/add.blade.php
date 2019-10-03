{{-- @push('styles')
  <link rel="stylesheet" href="{{asset('assets/user/css/jquery.datetimepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}">
@endpush
 --}}
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">NOUVEAU PRODUIT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="uploadForm" class="product-upload-form" onsubmit="upload(event)" enctype="multipart/form-data">
          {{csrf_field()}}
          <label for="" class="sec-txt">Aperçu des images<span class="text-danger">**</span></label>
          <div class="">
            <table class="table table-striped" id="imgtable">

            </table>
          </div>
          <div class="form-group">
              <label class="btn base-bg txt-white" style="width:200px;color:white;cursor:pointer;">
                <input id="imgs" style="display:none;" type="file" />
                 <i class="fa fa-plus"></i> Ajouter une photo
             </label>
             <p class="no-margin"><small class="text-danger">Maximum 5 images, peuvent être téléchargées</small></p>
             <p id="errpreimg" class="em no-margin text-danger"></p>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group margin-bottom-20">
                    <label>Titre <span class="text-danger">**</span></label>
                    <input name="title" type="text" class="form-control" placeholder="Entrer le titre...">
                    <p id="errtitle" class="em no-margin text-danger"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group margin-bottom-20">
                        <label>Stock (quantité) <span class="text-danger">**</span></label>
                        <input name="quantity" type="text" class="form-control" placeholder="Entrer la quantité...">
                        <p id="errquantity" class="em no-margin text-danger"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group margin-bottom-20">
                        <label>Prix ({{$gs->base_curr_text}})<span class="text-danger">**</span></label>
                        <input name="price" type="text" class="form-control" placeholder="Entrer le prix...">
                        <p id="errprice" class="em no-margin text-danger"></p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                <div class="form-group margin-bottom-20">
                    <label>Categories <span class="text-danger">**</span></label>
                    <select name="category" type="text" class="form-control" v-model="catid" @change="showsubcats()">
                      <option value="" selected disabled>Sélectionner une catégorie</option>
                      @foreach ($cats as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                      @endforeach
                    </select>
                    <input type="hidden" name="cat_helper" value="">
                    <p id="errcat" class="em no-margin text-danger"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group margin-bottom-20">
                    <label>Sous catégories <span class="text-danger">**</span></label>
                    <select name="subcategory" type="text" class="form-control" v-model="subcatid" id="selsub" @change="showattrs()">
                      <option value="" selected disabled>Sélectionner une sous catégorie</option>
                    </select>
                    <input type="hidden" name="subcat_helper" value="">
                    <p id="errsubcat" class="em no-margin text-danger"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group margin-bottom-20">
                    <label>Code produit<span >(Optional)</span></label>
                    <input name="product_code" type="text" class="form-control" placeholder="Entrez le code produit ...">
                    <small class="text-danger">Si vous ne spécifiez pas un code de produit unique, il sera généré automatiquement.</small>
                    <p id="errcode" class="em no-margin text-danger"></p>
                </div>
              </div>
          </div>
          <div id="proattrsid"></div>
          <div class="form-group margin-bottom-20">
              <label>Description <span class="text-danger">**</span></label>
              <textarea class="form-control" id="desc" rows="10"></textarea>
              <p id="errdesc" class="em no-margin text-danger"></p>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header base-bg" style="background-color:#00635a">
                    <h3 class="text-white mb-0">Offre</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group margin-bottom-20">
                          <label class="d-block">Offre <span>**</span></label>
                           <input class="form-control" data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                              data-width="100%" type="checkbox"
                              name="offer" onchange="changeOffer()">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group margin-bottom-20 d-none" id="offerType">
                          <label class="d-block">Type Offre  <span class="text-danger">**</span></label>
                          <input class="form-control" data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                             data-width="100%" type="checkbox" data-on="Percentage" data-off="Fixed"
                             name="offer_type" id="offerTypeToggle">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group margin-bottom-20 d-none" id="offerAmount">
                          <label>Compte <span class="text-danger">**</span></label>
                          <input class="form-control" name="offer_amount" type="text" placeholder="Entrer le montant de l'offre ...">
                          <div id="calcTotal"></div>
                          <p id="errofferamount" class="em no-margin text-danger"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header base-bg" style="background-color:#00635a">
                    <h3 class="text-white mb-0">Vente Flash </h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group margin-bottom-20">
                          <label class="d-block">Vente Flash  <span>**</span></label>
                          <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                             data-width="100%" type="checkbox"
                             name="flash_sale">
                        </div>
                      </div>

                      <div class="col-md-10 d-none" id="flashsale">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group margin-bottom-20">
                              <label class="d-block">Type <span>**</span></label>
                              <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                 data-width="100%" type="checkbox" data-on="Percentage" data-off="Fixed"
                                 name="flash_type">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group margin-bottom-20">
                              <label class="d-block">Montant <span>**</span></label>
                              <div class="form-check form-check-inline">
                                <input class="input-field" type="text" name="flash_amount" value="" autocomplete="off" placeholder="Entrez le montant du flash">

                              </div>
                              <p id="errflashamount" class="em no-margin text-danger"></p>
                              <div id="calcTotalFlash"></div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group margin-bottom-20">
                              <label class="d-block">Date <span>**</span></label>
                              <div class="form-check form-check-inline">
                                <input id="flash_date" class="input-field" type="text" name="flash_date" value="" placeholder="Entrez la date du flash">
                              </div>
                              <p id="errflashdate" class="em no-margin text-danger"></p>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group margin-bottom-20">
                              <label class="d-block">Temps interval <span>**</span></label>
                              <div class="form-check form-check-inline">
                                <select class="input-field" name="flash_interval">
                                  @foreach ($flashints as $key => $flashint)
                                    <option value="{{$flashint->id}}">{{$flashint->start_time . " - " . $flashint->end_time}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">ENREGISTRER</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
      </div>
    </div>
  </div>
</div>
@section('js-scripts')
  <script src="{{asset('assets/user/js/jquery.datetimepicker.full.min.js')}}"></script>
  <script src="{{asset('assets/admin/js/bootstrap-toggle.min.js')}}"></script>

  <script>
    function changeOffer() {
      let offer = $("input[name='offer']:checked").val();
      if (offer == 'on') {
        $("#offerType").removeClass("d-none");
        $("#offerAmount").removeClass("d-none");
        $("#offerType").addClass("d-block");
        $("#offerAmount").addClass("d-block");

        $('#offerTypeToggle').bootstrapToggle();
      } else {
        $("#offerType").removeClass("d-block");
        $("#offerAmount").removeClass("d-block");
        $("#offerType").addClass("d-none");
        $("#offerAmount").addClass("d-none");
      }
    }
  </script>

  <script>
    $(document).ready(function() {
      var curr = '{{$gs->base_curr_text}}';
      $("input[name='offer_amount'], input[name='price'], input[name='offer_type']").on('input', function(event) {
        let offeramount = $("input[name='offer_amount']").val();
        let offertype = $("input[name='offer_type']:checked").val();
        let price = $("input[name='price']").val();
        // if offer amount is present
        if (offeramount.length > 0) {
          // if price is present
          if (price.length > 0) {
            $("#calcTotal").html('');
            $("#calcTotal").removeClass('text-danger');
            // what is the offer type, take action depending on the type
            if (offertype == 'on') {
              // if offer type is Percentage...
              let offer = (offeramount*price)/100;
              let total = price - offer;
              $("#calcTotal").html('<strong>Prix: </strong>'+price + ' ' + curr +'<br/><strong>Offre: </strong>'+offer + ' ' + curr +'<br/><strong>Total: </strong>' + total + ' ' + curr);
            } else {
              // if offer type is Fixed...
              let total = price - offeramount;
              $("#calcTotal").html('<strong>Prix: </strong>'+price + ' ' + curr + '<br/><strong>Offre: </strong>'+offeramount + ' ' + curr+'<br/><strong>Total: </strong>' + total + ' ' + curr);
            }
            console.log(offeramount);
          } else {
            $("#calcTotal").html('Entrez le prix en premier');
            $("#calcTotal").addClass('text-danger')
          }
        }
      });
      $("input[name='offer_type']").on('change', function(event) {
        let offeramount = $("input[name='offer_amount']").val();
        let offertype = $("input[name='offer_type']:checked").val();
        let price = $("input[name='price']").val();
        // if offer amount is present
        if (offeramount.length > 0) {
          // if price is present
          if (price.length > 0) {
            $("#calcTotal").html('');
            $("#calcTotal").removeClass('text-danger');
            // what is the offer type, take action depending on the type
            if (offertype == 'on') {
              // if offer type is Percentage...
              let offer = (offeramount*price)/100;
              let total = price - offer;
              $("#calcTotal").html('<strong>Prix: </strong>'+price+'<br/><strong>Offre: </strong>'+offer+'<br/><strong>Total: </strong>' + total);
            } else {
              // if offer type is Fixed...
              let total = price - offeramount;
              $("#calcTotal").html('<strong>Prix: </strong>'+price+'<br/><strong>Offre: </strong>'+offeramount+'<br/><strong>Total: </strong>' + total);
            }
            console.log(offeramount);
          } else {
            $("#calcTotal").html('Entrez le prix en premier');
            $("#calcTotal").addClass('text-danger')
          }
        }
      });
      $("input[name='flash_amount'], input[name='price']").on('input', function(event) {
        let flashamount = $("input[name='flash_amount']").val();
        let flashtype = $("input[name='flash_type']:checked").val();
        let price = $("input[name='price']").val();
        // if offer amount is present
        if (flashamount.length > 0) {
          // if price is present
          if (price.length > 0) {
            $("#calcTotalFlash").html('');
            $("#calcTotalFlash").removeClass('text-danger');
            // what is the offer type, take action depending on the type
            if (flashtype == 'on') {
              // if offer type is Percentage...
              let offer = (flashamount*price)/100;
              let total = price - offer;
              $("#calcTotalFlash").html('<strong>Prix: </strong>'+price + ' ' + curr +'<br/><strong>Offre: </strong>'+offer + ' ' + curr +'<br/><strong>Total: </strong>' + total + ' ' + curr);
            } else {
              // if offer type is Fixed...
              let total = price - flashamount;
              $("#calcTotalFlash").html('<strong>Prix: </strong>'+price + ' ' + curr + '<br/><strong>Offre: </strong>'+flashamount + ' ' + curr+'<br/><strong>Total: </strong>' + total + ' ' + curr);
            }
            console.log(flashamount);
          } else {
            $("#calcTotalFlash").html('Entrez le prix en premier');
            $("#calcTotalFlash").addClass('text-danger')
          }
        }
      });
      $("input[name='flash_type']").on('change', function(event) {
        let flashamount = $("input[name='flash_amount']").val();
        let flashtype = $("input[name='flash_type']:checked").val();
        let price = $("input[name='price']").val();
        // if offer amount is present
        if (flashamount.length > 0) {
          // if price is present
          if (price.length > 0) {
            $("#calcTotalFlash").html('');
            $("#calcTotalFlash").removeClass('text-danger');
            // what is the offer type, take action depending on the type
            if (flashtype == 'on') {
              // if offer type is Percentage...
              let offer = (flashamount*price)/100;
              let total = price - offer;
              $("#calcTotalFlash").html('<strong>Prix: </strong>'+price+'<br/><strong>Offre: </strong>'+offer+'<br/><strong>Total: </strong>' + total);
            } else {
              // if offer type is Fixed...
              let total = price - flashamount;
              $("#calcTotalFlash").html('<strong>Prix: </strong>'+price+'<br/><strong>Offre: </strong>'+flashamount+'<br/><strong>Total: </strong>' + total);
            }
            console.log(flashamount);
          } else {
            $("#calcTotalFlash").html('Entrez le prix en premier');
            $("#calcTotalFlash").addClass('text-danger')
          }
        }
      });
    });
  </script>
@endsection
@section('preimgscripts')
  <script>
  $(document).ready(function() {
    $('#flash_date').datetimepicker({
     format:'Y/m/d',
     timepicker: false
    });

    $("input[name='flash_sale']").on('change', function () {
      let flashsale = $("input[name='flash_sale']:checked").val();
      if (flashsale == 'on') {
        $("#flashsale").removeClass('d-none');
        $("#flashsale").addClass('d-block');
      } else {
        $("#flashsale").removeClass('d-block');
        $("#flashsale").addClass('d-none');
      }
    })
  });

    var el = 0;
    var imgs = [];

    $(window).load(function(){
      $.get(
        '{{route('package.validitycheck')}}',
        function(data) {
          // console.log(data);

          if (data.products == 0) {
            $("#dangerAlert").addClass('d-block');
            $("#successAlert").addClass('d-none');
          } else if (data.products > 0) {
            $("#successAlert").addClass('d-block');
            $("#dangerAlert").addClass('d-none');
          }
        }
      );
    });

    $(document).on('change', '#imgs', function(e) {
        if (this.files.length && imgs.length < 5) {
          el++;
          $("#imgtable").append('<tr class="trcl" id="tr'+(el-1)+'"><td><img class="preimgs"></td><td><button class="rmvbtn btn btn-danger" type="button" onclick="rmvimg('+(el-1)+')"><i class="fa fa-times"></i></button></td></tr>');
          var file = this.files[0];
          var reader = new FileReader();

          reader.onload = function(e) {
              var data = e.target.result;

              document.getElementsByClassName('preimgs')[el-1].setAttribute('src', data);
              document.getElementsByClassName('preimgs')[el-1].setAttribute('style', 'width:150px');
          };

          reader.readAsDataURL(file);
          imgs.push(file);
          console.log(imgs);
        }

    });

    function rmvimg(index) {
        $("#tr"+index).remove();
        imgs.splice(index, 1);
        console.log(imgs);
        var trcl = document.getElementsByClassName('trcl');
        var rmvbtn = document.getElementsByClassName('rmvbtn');
        for(el=0; el<trcl.length; el++) {
            trcl[el].setAttribute('id', 'tr'+el);
            rmvbtn[el].setAttribute('onclick', 'rmvimg('+el+')');
        }
    }


    function upload(e) {
      e.preventDefault();

      swal({
        title: "Checking...",
        text: "Please wait",
        icon: "{{asset('assets/user/img/ajax-loading.gif')}}",
        buttons: false,
        closeOnClickOutside: false
      });

      var uploadForm = document.getElementById('uploadForm');
      var fd = new FormData(uploadForm);
      var descriptionElement = new nicEditors.findEditor('desc');
      description = descriptionElement.getContent();
      for (var i = 0; i < imgs.length; i++) {
        fd.append('images[]', imgs[i]);
      }
      fd.append('description', description);
      $.ajax({
        url: '{{route('vendor.product.store')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          swal.close();
          console.log(data);
          var em = document.getElementsByClassName('em');
          for (var i = 0; i < em.length; i++) {
            em[i].innerHTML = '';
          }

          if (data == "no_product") {
            swal("Alert!", "You have to buy a package to upload product!", "error");
          }
          if (data=="success") {

            window.location = "{{url()->current()}}";
          }
          // if error occurs
          if(typeof data.error != 'undefined') {
            if (typeof data.title != 'undefined') {
              document.getElementById('errtitle').innerHTML = data.title[0];
            }
            if (typeof data.quantity != 'undefined') {
              document.getElementById('errquantity').innerHTML = data.quantity[0];
            }
            if (typeof data.price != 'undefined') {
              document.getElementById('errprice').innerHTML = data.price[0];
            }
            if (typeof data.cat_helper != 'undefined') {
              document.getElementById('errcat').innerHTML = data.cat_helper[0];
            }
            if (typeof data.subcat_helper != 'undefined') {
              document.getElementById('errsubcat').innerHTML = data.subcat_helper[0];
            }
            if (typeof data.description != 'undefined') {
              document.getElementById('errdesc').innerHTML = data.description[0];
            }
            if (typeof data.images != 'undefined') {
              document.getElementById('errpreimg').innerHTML = data.images[0];
            }
            if (typeof data.offer_amount != 'undefined') {
              document.getElementById('errofferamount').innerHTML = data.offer_amount[0];
            }
            if (typeof data.flash_amount != 'undefined') {
              document.getElementById('errflashamount').innerHTML = data.flash_amount[0];
            }
            if (typeof data.flash_date != 'undefined') {
              document.getElementById('errflashdate').innerHTML = data.flash_date[0];
            }
            if ("proattr" in data) {
              data.proattr[0]; // object
              for (var key in data.proattr[0]) {
                document.getElementById(`err${key}`).innerHTML = data.proattr[0][key];
              }
            }
          }
        }
      });
    }
  </script>
@endsection