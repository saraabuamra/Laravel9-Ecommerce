<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class FilterController extends Controller
{
    public function filters(){
        Session::put('page','filters');
        $filters = ProductsFilter::get()->toArray();
        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValues(){
        Session::put('page','filters');
        $filters_values = ProductsFiltersValue::get()->toArray();
       // dd($filters_values);
        return view('admin.filters.filters_values')->with(compact('filters_values'));
    }


    
    public function updateFilterValueStatus(Request $request){
        if($request->ajax()){
           $data = $request->all();
           if($data['status']=="Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           ProductsFiltersValue::where('id',$data['filter_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
       }

    public function updateFilterStatus(Request $request){
        if($request->ajax()){
           $data = $request->all();
           if($data['status']=="Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           ProductsFilter::where('id',$data['filter_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
       }

       public function deleteFilter($id){
        ProductsFilter::destroy($id);
       return redirect()->back()->with('success_message','Filter has been deleted successfully');
     }


     public function addEditFilter(Request $request,$id=null){
        Session::put('page','filters');
        if($id==""){
        $title = "Add Filter Columns";
        $filter = new ProductsFilter;
        $message = "Filter added successfully!";
        }else{
            $title = "Edit Filter Columns";
            $filter = ProductsFilter::find($id);
            $message = "Filter updated successfully!"; 
        }

        //Get Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get()->toArray();
        if($request->isMethod('post')){
            $data = $request->all();
    
            $cat_ids = implode(',',$data['cat_ids']);
            //save Filter column details in product_filters table
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->status = 1;
            $filter->save();

            //Add filter column in products table
            DB::statement('Alter table products add '.$data['filter_column'].' varchar(255)
            after description');

            return redirect('admin/filters')->with('success_message',$message);
        }
        return view('admin.filters.add_edit_filter')->with(compact('title','filter','categories','message'));
       }

       public function addEditFilterValue(Request $request,$id=null){
        Session::put('page','filters');
        if($id==""){
        $title = "Add Filter Value";
        $filter = new ProductsFiltersValue;
        $message = "Filter Value added successfully!";
        }else{
            $title = "Edit Filter Value";
            $filter = ProductsFiltersValue::find($id);
            $message = "Filter Value updated successfully!"; 
        }

        if($request->isMethod('post')){
            $data = $request->all();
            
            //save Filter values details in product_filters_values table
            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = $data['filter_value'];
            $filter->status = 1;
            $filter->save();


            return redirect('admin/filters-values')->with('success_message',$message);
        }
        // Get Filters
        $filters = ProductsFilter::where('status',1)->get()->toArray();

        return view('admin.filters.add_edit_filter_value')->with(compact('title','filter','filters','message'));
       }

       public function categoryFilters(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $category_id  = $data['category_id'];
            return response()->json([
                'view'=>(String)View::make('admin.filters.category_filters')->with(compact(
                    'category_id'))
                ]);
        }
       }
}
