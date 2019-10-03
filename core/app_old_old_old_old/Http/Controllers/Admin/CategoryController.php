<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Emploi;
use App\Product;
use App\Service;
use App\Category;
use App\Evenement;
use App\Immobilier;
use App\Allcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index() {
      $data['cats'] = Category::latest()->paginate(10);
      return view('admin.category.index', $data);
    }

    public function liste_produit($slug){
      $cat_id = Category::where('slug',$slug)->first()->id;
      if(empty(Product::where('category_id',$cat_id)->paginate(10))){
        $var = Product::where('category_id',$cat_id)->paginate(10);
      }elseif (empty(Emploi::where('category_id',$cat_id)->paginate(10))) {
        $var = Emploi::where('category_id',$cat_id)->paginate(10);
      }elseif (empty(Evenement::where('category_id',$cat_id)->paginate(10))) {
        $var = Evenement::where('category_id',$cat_id)->paginate(10);
      }elseif (empty(Service::where('category_id',$cat_id)->paginate(10))) {
        $var = Service::where('category_id',$cat_id)->paginate(10);
      }elseif (empty(Immobilier::where('category_id',$cat_id)->paginate(10))) {
        $var = Immobilier::where('category_id',$cat_id)->paginate(10);
      }else{
        $var = Allcategory::where('category_id',$cat_id)->paginate(10); 
      }
      $data['products_cats'] = $var;
      return view('admin.articleForCategories.index',$data);
    }

    public function store(Request $request) {
      $validatedRequest = $request->validate([
        'name' => 'required',
        'description_short'=>'required',
        'description_long'=>'required'
      ]);

      $category = new Category;
      $category->name = $request->name;
      $category->true_name = strtoupper($request->name);
      $category->slug = Str::slug($request->name);
      $category->description_short = $request->description_short;
      $category->description_long = $request->description_long;
      $category->validation = $request->validation;
      $category->save();

      Session::flash('success', 'Catégorie ajoutée avec succès');
      return redirect()->back();
    }

    public function update(Request $request) {
      $validatedRequest = $request->validate([
        'name' => 'required',
        'description_short'=>'required',
        'description_long'=>'required'
      ]);

      $cat = Category::find($request->statusId);
      $cat->name = $request->name;
      // $cat->true_name = strtoupper($request->name);
      $cat->slug = Str::slug($request->name);
      $cat->status = $request->status;
      $cat->description_short = $request->description_short;
      $cat->description_long = $request->description_long;
      $cat->validation = $request->validation;
      $cat->save();

      Session::flash('success', 'Catégorie mise à jour avec succès');
      return redirect()->back();
    }

    public function update_activate(Request $request) {
      $cat = Category::find($request->statusId);
      $cat->product_validate = $request->status;
      $cat->save();

      Session::flash('success', 'Activation éffectuée avec succès !!!');
      return redirect()->back();
    }

    public function delete(Request $request){
      if($request->ajax()){
          $category = Category::find($request->id);
          $category->delete();
          return response()->json([
              'result' =>'success'
          ]);
      }

}
}
