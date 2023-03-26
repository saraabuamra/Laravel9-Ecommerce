<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductsController extends Controller
{
    public function listing(Request $request){
      if($request->ajax()){
         $data = $request->all();
         $url = $data['url'];
         $_GET['sort'] = $data['sort'];
         $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
         if($categoryCount>0){
            $categoryDetails = Category::categoryDetails($url);
            $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
            ->where('status',1);

         //checking for Dynamic Filters
         $productFilters = ProductsFilter::productFilters();
         foreach ($productFilters as $key => $filter) {
            // If filter is selected
            if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && 
             !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
               $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);

             }
         }
    
            //checking for Sort 
            if(isset($_GET['sort']) && !empty($_GET['sort'])){
             if($_GET['sort']=="product_latest"){
                $categoryProducts->orderby('products.id','Desc');
             }else if($_GET['sort']=="price_lowest"){
                $categoryProducts->orderby('products.product_price','Asc');
             }else if($_GET['sort']=="price_highest"){
                $categoryProducts->orderby('products.product_price','Desc');
             }else if($_GET['sort']=="name_z_a"){
                $categoryProducts->orderby('products.product_name','Desc');
             }else if($_GET['sort']=="name_a_z"){
                $categoryProducts->orderby('products.product_name','Asc');
             }
            }
            
            //checking for Size 
            if(isset($data['size']) && !empty($data['size'])){
               $productIds = ProductsAttribute::select('product_id')->whereIn('size',
               $data['size'])->pluck('product_id')->toArray();
               $categoryProducts->whereIn('products.id',$productIds);
            }

             //checking for Color 
             if(isset($data['color']) && !empty($data['color'])){
               $productIds = Product::select('id')->whereIn('product_color',
               $data['color'])->pluck('id')->toArray();
               $categoryProducts->whereIn('products.id',$productIds);
            }
             
              //checking for Price 
              if(isset($data['price']) && !empty($data['price'])){
               foreach ($data['price'] as $key => $price) {
                  $priceArr = explode("-",$price);
                  $productIds[] = Product::select('id')->whereBetween('product_price',[
                     $priceArr[0],$priceArr[1]])->pluck('id')->toArray();
               }
               $productIds = call_user_func_array('array_merge',$productIds);
               $categoryProducts->whereIn('products.id',$productIds);
              }

              //checking for Brand 
             if(isset($data['brand']) && !empty($data['brand'])){
               $productIds = Product::select('id')->whereIn('brand_id',
               $data['brand'])->pluck('id')->toArray();
               $categoryProducts->whereIn('products.id',$productIds);
            }

            $categoryProducts = $categoryProducts->paginate(30);
            //dd($categoryDetails);
    
            return view('front.products.ajax_products_listing')->with(
             compact('categoryDetails','categoryProducts','url'));
         }else{
            abort(404);
         }
      }else{
         $url = Route::getFacadeRoot()->current()->uri();
     $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
     if($categoryCount>0){
        $categoryDetails = Category::categoryDetails($url);
        $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
        ->where('status',1);



        //checking for Sort 
        if(isset($_GET['sort']) && !empty($_GET['sort'])){
         if($_GET['sort']=="product_latest"){
            $categoryProducts->orderby('products.id','Desc');
         }else if($_GET['sort']=="price_lowest"){
            $categoryProducts->orderby('products.product_price','Asc');
         }else if($_GET['sort']=="price_highest"){
            $categoryProducts->orderby('products.product_price','Desc');
         }else if($_GET['sort']=="name_z_a"){
            $categoryProducts->orderby('products.product_name','Desc');
         }else if($_GET['sort']=="name_a_z"){
            $categoryProducts->orderby('products.product_name','Asc');
         }
        }
        $categoryProducts = $categoryProducts->paginate(30);
        //dd($categoryDetails);

        return view('front.products.listing')->with(
         compact('categoryDetails','categoryProducts','url'));
     }else{
        abort(404);
     }  
      }
   
    }
}
