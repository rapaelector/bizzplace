<?php

namespace App\Http\Controllers\Vendor;

use App\Vendor;
use App\Product;
use App\Service;
use App\Category;
use App\Evenement;
use Carbon\Carbon;
use App\Immobilier;
use App\Subcategory;
use App\FlashInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $data['flashints'] = FlashInterval::all();
        $data['cats'] = Category::where('status', 1)->get();
        $vendor_role = Auth::guard('vendor')->user()->id;
        $vendor = Vendor::find($vendor_role);
         if ($vendor->products != 0) {
          $today = new \Carbon\Carbon(Carbon::now());
          $existingVal = new \Carbon\Carbon($vendor->expired_date);
          if ($today->gt($existingVal)) {
            $vendor->products = 0;
            $vendor->expired_date = NULL;
            $vendor->save();
            send_email($vendor->email,$vendor->shop_name,$vendor->phone , $vendor->email,"Le forfait d'abonnement a expiré!", "Votre forfait d'abonnement a expiré. S'il vous plaît acheter un nouveau forfait d'abonnement.");
          }
        }
        $vendor_role = Auth::guard('vendor')->user()->shop_name;
        $data['var'] =Vendor::with('roles')->where('shop_name',$vendor_role)->first()->roles->isEmpty();
        $data['categoris']=Category::where('name',$slug)->first();
        $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $data['slug']=[
            'slug'=>$slug
        ];
        $data['subcats'] = Subcategory::where('status', 1)
                            ->where('category_id',$data['categoris']->id)
                            ->get();
        $data['immobiliers'] = DB::table('immobiliers')
                                  /*   ->join('categories','immobiliers.category_id','=','categories.id')
                                    ->where('categories.validation','=','yes') */
                                    ->get();
        // dd($vendor_role);
        $data['products'] = Product::where('vendor_id', $vendor->id)->orderBy('id', 'DESC')->where('deleted', 0)->paginate(10);
        $data['services'] = Service::where('vendor_id', $vendor->id)->orderBy('id', 'DESC')->where('deleted', 0)->get();
        $data['evenements'] = Evenement::where('vendor_id', $vendor->id)->orderBy('id', 'DESC')->where('deleted', 0)->get();
        // $data['emplois'] = Emploi::where('vendor_id', 1)->orderBy('id', 'DESC')->where('deleted', 0)->get();

        if($data['categoris']->true_name=='PRODUITS'){
            $views= view('vendor.product.manage',$data);
        }elseif($data['categoris']->true_name=='ANNUAIRES'){
            $views= view('vendor.partenaires.index',$data);
        }elseif($data['categoris']->true_name=='EVENEMENTS'){
            $views= view('vendor.event.manage',$data);
        }elseif($data['categoris']->true_name=='EMPLOIS'){
            $views= view('vendor.emplois.manage',$data);
        }elseif($data['categoris']->true_name=='IMMOBILIERS'){
            $views= view('vendor.immobilier.manage',$data);
        }elseif($data['categoris']->true_name=='SERVICES'){
            $views= view('vendor.service.manage',$data);
        }
        return $views;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
