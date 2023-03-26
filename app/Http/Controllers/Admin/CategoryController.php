<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get()->toArray();
        //dd($categories);
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
        Session::put('page','categories');
        if($id==""){
            //Add Category Functionality
        $title = "Add Category";
        $category = new Category;
        $getCategories = array();
        $message = "Category added successfully!";
        }else{
            //Edit Category Functionality
            $title = "Edit Category";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'
            =>$category['section_id']])->get();
            $message = "Category updated successfully!"; 
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $validated = $request->validate([
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ]);

            if($data['category_discount']==""){
                $data['category_discount']=0;
            }

             //upload Category image
             if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    //Get Image Extention
                    $extention = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extention;
                    $imagePath = 'front/images/category_images/'.$imageName;
                    //upload the image
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            }else{
                $category->category_image = " ";
            }
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message',$message);
        }
        //Get All Sections
        $getSections = Section::get()->toArray();
    
        return view('admin.categories.add_edit_category')->with(compact('title','category','message','getSections','getCategories'));
       }

       public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$data['section_id']])->get();
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }    
    
       }

       public function deleteCategoryImage($id){
        //get category image
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        //get category image path
        $category_image_path = 'front/images/category_images/';

        //delete category image from category_images folder if exists
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }
        //delete category image from categories folder 
        Category::where('id',$id)->update(['category_image'=>'']);

       return redirect()->back()->with('success_message','Category Image has been deleted successfully');
     }
}
