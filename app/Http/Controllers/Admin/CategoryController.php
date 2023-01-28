<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentCategory'])->get()->toArray();
       // dd($categories);
        return view('admin.categories.categories')->with(compact('categories'));
    }

    
    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
           $data = $request->all();
           if($data['status']=="Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           Category::where('id',$data['category_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
       }

       public function deleteCategory($id){
          Category::destroy($id);
         return redirect()->back()->with('success_message','Category has been deleted successfully');
       }


       public function addEditCategory(Request $request,$id=null){
        Category::put('page','categories');
        if($id==""){
        $title = "Add Category";
        $category = new Category;
        $message = "Category added successfully!";
        }else{
            $title = "Edit Category";
            $category = Category::find($id);
            $message = "Category updated successfully!"; 
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $validated = $request->validate([
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ]);
            $category->name = $data['category_name'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message',$message);
        }
        return view('admin.categories.add_edit_category')->with(compact('title','category','message'));
       }
}
