<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getFilterName($filter_id){
        $getFilterName = ProductsFilter::select('filter_name')->where('id',$filter_id)
        ->first();

        return $getFilterName->filter_name;
        
    }

    public function filter_values(){
        return $this->hasMany('App\Models\ProductsFiltersValue','filter_id');
    }

    public static function productFilters(){
        $productFilters = ProductsFilter::with('filter_values')->where('status',1)
        ->get()->toArray();
        return $productFilters;
    }

    public static function filterAvailable($filter_id,$category_id){
     $filterAvailable = ProductsFilter::select('cat_ids')->where(['id'=>$filter_id,'status'=>1])
     ->first()->toArray();
     $catIdsArr = explode(",",$filterAvailable['cat_ids']);
     if(in_array($category_id,$catIdsArr)){
        $available = "Yes";
     }else{
        $available = "No";
     }
     return $available;
    }


    public static function getSize($url){
    $categoryDetails = Category::categoryDetails($url);
    $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])
    ->pluck('id')->toArray();
    $getProductSizes = ProductsAttribute::select('size')->whereIn('product_id'
    ,$getProductIds)->groupBy('size')->pluck('size')->toArray();

    return $getProductSizes;
    }

    public static function getColor($url){
        $categoryDetails = Category::categoryDetails($url);
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])
        ->pluck('id')->toArray();
        $getColors = Product::select('product_color')->whereIn('id'
        ,$getProductIds)->groupBy('product_color')->pluck('product_color')->toArray();
    
        return $getColors;
        }

        public static function getBrands($url){
            $categoryDetails = Category::categoryDetails($url);
            $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])
            ->pluck('id')->toArray();
            $brandIds = Product::select('brand_id')->whereIn('id'
            ,$getProductIds)->groupBy('brand_id')->pluck('brand_id')->toArray();
            $brandDetails = Brand::select('id','name')->whereIn('id',$brandIds)->get()->toArray();
        
            return $brandDetails;
            }
}
