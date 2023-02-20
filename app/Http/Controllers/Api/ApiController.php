<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\FlareClient\Api;

class ApiController extends Controller
{
    public function getAllSections()
{
   $getsections =Section::all();

    return response()->json(['sections'=>$getsections]);
}

public function sectionDetails(Request $request)
{
    if(!$request->input('id')){

        return response()->json([
            'success' => false,
            'message' => "id parameters is required!",
        ], 400);

    }else{
        $validatedData = request()->validate([
            'id' => ['required', 'numeric'],
        ]);
        $section = Section::find($validatedData['id']);
        if(!$section){
            return response()->json([
                'success' => false,
                'message' => 'The Section not found',
            ],404);
        }
        return response()->json([
            'success' => true,
            'section' => $section,
        ],200);
    }
   
    }  
    


public function search(Request $request) {

    $data = $request->get('data');

    $search_drivers = Category::where('id', 'like', "%{$data}%")
                     ->orWhere('parent_id', 'like', "%{$data}%")
                     ->orWhere('section_id', 'like', "%{$data}%")
                     ->orWhere('category_name', 'like', "%{$data}%")
                     ->orWhere('description', 'like', "%{$data}%")
                     ->get();

    return Response::json([
        'data' => $search_drivers
    ]);     
}

}
