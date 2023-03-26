<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

    public function vendorListing($vendorid){
      // Get Vendor Shop Name
      $getVendorShop = Vendor::getVendorShop($vendorid);
      // Get Vendor Products
      $vendorProducts = Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);
      $vendorProducts = $vendorProducts->paginate(30);
      return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
    }

    public function detail($id){
      $productDetails = Product::with(['section','category','vendor','brand','attributes'=>function($query){
       $query->where('stock','>',0)->where('status',1);
      },'images'])->find($id)->toArray();
      $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
       //dd($productDetails);

      // Get Similar Products
      $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])
      ->where('id','!=',$id)->limit(6)->inRandomOrder()->get()->toArray();
      //dd($similarProducts);

      // Set Session for Resently Viewed Products
      if(empty(Session::get('session_id'))){
         $session_id = md5(uniqid(rand(),true));
      }else{
         $session_id = Session::get('session_id');
      }

      Session::put('session_id',$session_id);

      // Insert product in table if not already exists
      $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>
      $id , 'session_id'=>$session_id])->count();
      if($countRecentlyViewedProducts==0){
         DB::table('recently_viewed_products')->insert(['product_id'=>
         $id , 'session_id'=>$session_id]);
      }

      // Get Recently Viewed Products Ids
      $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id',
      '!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');

      // Get Recently Viewed Products
      $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->get()->toArray();

      // Get Group Products (Product Colors)
      $groupProducts = array();
      if(!empty($productDetails['group_code'])){
         $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->where(['group_code'
         =>$productDetails['group_code'],'status' => 1])->get()->toArray();
         //dd($groupProducts);
      }

      $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
      return view('front.products.detail')->with(compact('productDetails','categoryDetails',
      'totalStock','similarProducts','recentlyViewedProducts','groupProducts'));
    }

    public function getProductPrice(Request $request){
      if($request->ajax()){
         $data = $request->all();

         $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],
         $data['size']);

         return $getDiscountAttributePrice;
      }
    }

    public function cartAdd(Request $request){
      if($request->isMethod('post')){
         $data = $request->all();
         //echo "<pre>"; print_r($data); die;

         // Check Product Stock is available or not
         $getProductStock = ProductsAttribute::getProductStock($data['product_id'],
         $data['size']);
         if($getProductStock<$data['quantity']){
            return redirect()->back()->with('error_message','Required Quantity is
            not available!');
         }

         // Generate Session Id if not exists
         $session_id = Session::get('session_id');
         if(empty($session_id)){
            $session_id  = Session::getId();
            Session::put('session_id',$session_id);
         }

         // Check Products if already exists in the User Cart
         if(Auth::check()){
            // User is logged in 
             $user_id = Auth::user()->id;
             $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'
             =>$user_id])->count();
         }else{
            // User is not logged in 
            $user_id = 0;
            $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'
            =>$session_id])->count();
         }

         // Save Product in carts table
         $item = new Cart;
         $item->session_id = $session_id;
         $item->user_id = $user_id;
         $item->product_id = $data['product_id'];
         $item->size = $data['size'];
         $item->quantity = $data['quantity'];
         $item->save();
         return redirect()->back()->with('success_message','Product has been added in Cart! <a 
      style="text-decoration:underline !important" href="/cart">View Cart</a>');
      }

    }

    public function cart(){
      $getCartItems = Cart::getCartItems();
     // dd($getCartItems);
      return view('front.products.cart')->with(compact('getCartItems'));
    }
}
