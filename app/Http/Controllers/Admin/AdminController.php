<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\VendorsBankDetail;
use App\Models\VendorsBusinessDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        return View('admin.dashboard');
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $validated = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);

        //     if(Auth::guard('admin')->attempt([
        //         'email'=>$data['email'],
        //         'password'=>$data['password'],
        //         'status'=>1])){
        //             return redirect('admin/dashboard');
        //         }else{
        //             return redirect()->back()->with('error_message','Invalid Email or Password');
        //         }
        // }

        if(Auth::guard('admin')->attempt([
            'email'=>$data['email'],
            'password'=>$data['password']])){
                if(Auth::guard('admin')->user()->type == "vendor" && Auth::guard('admin')->user()->confirm
                == "No"){
                    return redirect()->back()->with('error_message','Please confirm Your email
                    to activate your Vendor Account');
                }else if(Auth::guard('admin')->user()->type != "vendor" &&
                 Auth::guard('admin')->user()->status == "0"){
                    return redirect()->back()->with('error_message','Your admin account is not active');
                }else{
                    return redirect('admin/dashboard'); 
                }    
            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }
        }
        return view('admin.login');
    }


    public function updateAdminPassword(Request $request){
        Session::put('page','update-admin-password');
        if($request->isMethod('post')){
            $data = $request->all();
            //check if current  password entered by admin is correct
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            // Check if new password is matching with confirm password
            if($data['confirm_password']==$data['new_password']){
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>
                bcrypt($data['new_password'])]);
                return redirect()->back()->with('success_message','Password has been updated successfully!');
            }else{
                return redirect()->back()->with('error_message','New Password and Confirm Password does not match!');
            }
            }else{
                return redirect()->back()->with('error_message','Your current password is Incorrect!');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
       return view('admin.settings.update-admin-password')->with(compact('adminDetails'));
    }
    public function checkAdminPassword(Request $request){
        $data = $request->all();
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateAdminDetails(Request $request){
        Session::put('page','update-admin-details');
        if($request->isMethod('post')){
            $data = $request->all();

            $validated = $request->validate([
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ]);
            //upload admin image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //Get Image Extention
                    $extention = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extention;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    //upload the image
                    Image::make($image_tmp)->save($imagePath);

                }
            }elseif(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";
            }
            Admin::where('id',Auth::guard('admin')->user()->id)
            ->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            return redirect()->back()->with('success_message','Admin details updated successfully!');
        }
      return view('admin.settings.update-admin-details');
     
    }

    public function updateVendorDetails($slug,Request $request){
        if($slug=="personal"){
            Session::put('page','update-personal-details');
            if($request->isMethod('post')){
                $data = $request->all();

                $validated = $request->validate([
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile' => 'required|numeric',
                ]);
                //upload vendor image
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid()){
                        //Get Image Extention
                        $extention = $image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extention;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        //upload the image
                        Image::make($image_tmp)->save($imagePath);
    
                    }
                }elseif(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                }else{
                    $imageName = "";
                }
                //update in admins table
                Admin::where('id',Auth::guard('admin')->user()->id)
                ->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'image'=>$imageName]);
                //update in vendors table
                Vendor::where('id',Auth::guard('admin')->user()->vendor_id)
                ->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],
                'address'=>$data['vendor_address'],'city'=>$data['vendor_city'],
                'state'=>$data['vendor_state'],'country'=>$data['vendor_country'],
                'pincode'=>$data['vendor_pincode']]);
                return redirect()->back()->with('success_message','Vendor details updated successfully!');
            }
            $vendorCount = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails = array();
            }

        }elseif($slug=="business"){
            Session::put('page','update-business-details');
            if($request->isMethod('post')){
                $data = $request->all();

                $validated = $request->validate([
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required|numeric',
                    'address_proof'=>'required',
                ]);
                //upload vendor image
                if($request->hasFile('address_proof_image')){
                    $image_tmp = $request->file('address_proof_image');
                    if($image_tmp->isValid()){
                        //Get Image Extention
                        $extention = $image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extention;
                        $imagePath = 'admin/images/proofs/'.$imageName;
                        //upload the image
                        Image::make($image_tmp)->save($imagePath);
    
                    }
                }elseif(!empty($data['current_address_proof'])){
                    $imageName = $data['current_address_proof'];
                }else{
                    $imageName = "";
                }
                $vendorCount =VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
                ->count();
                if($vendorCount>0){
                    //update in vendors_business_details table
                    VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
                    ->update(['shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],
                    'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],
                    'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],
                    'shop_pincode'=>$data['shop_pincode'],'shop_website'=>$data['shop_website'],
                    'business_license_number'=>$data['business_license_number'],
                    'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],
                    'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);
                }else{
                    //update in vendors_business_details table
                    VendorsBusinessDetail::insert(['vendor_id'=>Auth::guard('admin')->user()
                    ->vendor_id,'shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],
                    'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],
                    'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],
                    'shop_pincode'=>$data['shop_pincode'],'shop_website'=>$data['shop_website'],
                    'business_license_number'=>$data['business_license_number'],
                    'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],
                    'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);
                }
              
                return redirect()->back()->with('success_message','Vendor business details updated successfully!');
            }
            $vendorCount =VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
            ->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
                ->first()->toArray();
            }else{
                $vendorDetails = array();
            }
            // dd($vendorDetails);
        }elseif($slug=="bank"){
            Session::put('page','update-bank-details');
            if($request->isMethod('post')){
                $data = $request->all();

                $validated = $request->validate([
                    'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'bank_name' => 'required',
                    'account_number' => 'required|numeric',
                    'bank_ifsc_code'=>'required',
                ]);
             
                $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
                ->count();
                if($vendorCount>0){
                  //update in vendors_bank_details table
                   VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
                  ->update(['account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],
                   'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);
                   return redirect()->back()->with('success_message','Vendor bank details updated successfully!');
                }else{
                //update in vendors_bank_details table
                VendorsBankDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->
                vendor_id,'account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],
                'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);
                return redirect()->back()->with('success_message','Vendor bank details updated successfully!');
                }
             
            }
            $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
            ->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)
            ->first()->toArray(); 
            }else{
                $vendorDetails = array();
            }
           
        }
        $countries  = Country::where('status',1)->get()->toArray();
        return view('admin.settings.update-vendor-details')->with(compact('slug','vendorDetails','countries'));

    }

    public function admins($type=null){
     $admins =Admin::query();
     if(!empty($type)){
        $admins = $admins->where('type',$type);
        $title = ucfirst($type)."s";
        Session::put('page','view_'.strtolower($title));
     }else{
        $title = "All Admins/Subadmins/Vendors";
        Session::put('page','view_all');
     }
     $admins = $admins->get()->toArray();
     return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function viewVendorDetails($id){
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
         //dd($vendorDetails);
        return view('admin.admins.view-vendor-details')->with(compact('vendorDetails'));

    }

    public function updateAdminStatus(Request $request){
     if($request->ajax()){
        $data = $request->all();
        if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
        $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();
        if($adminDetails['type'] =="vendor" && $status==1){
            Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);
             // Send Approval Email 
             $email = $adminDetails['email'];
             $messageData = [
            'email' => $adminDetails['email'],
            'name' => $adminDetails['name'],
            'mobile' => $adminDetails['mobile'],
         ];
 
         Mail::send('emails.vendor_approved', $messageData, function($message)use($email){
           $message->to($email)->subject('Vendor Account is Approved');  
         });

        }
        return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
     }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }


}

