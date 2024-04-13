<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponsController extends Controller
{
    public function coupons()
    {
        Session::put('page', 'coupons');
        $coupons = Coupon::get()->toArray();
        //dd($coupons);
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }

    public function updateCouponStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Coupon::where('id', $data['coupon_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'coupon_id' => $data['coupon_id']]);
        }
    }

    public function deleteCoupon($id)
    {
        Coupon::destroy($id);
        return redirect()->back()->with('success_message', 'Coupon has been deleted successfully');
    }

    public function addEditCoupon($id =''){
     if($id = ''){
        $title = 'Add Coupon';
        $coupon = new Coupon;
        $message = 'Coupon added successfully';
     }else{
        $title = 'Edit Coupon';
        $coupon = Coupon::find($id);
        $message = 'Coupon updated successfully';
     }
        //Get Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get()->toArray();

        $brands = Brand::where('status',1)->get()->toArray();

        //Get All User Emails
        $users = User::select('email')->where('status',1)->get();

     return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','message','categories','brands','users'));
    }

    
}
