@extends('admin.layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Update Vendor Details</h3>
                            {{-- <h6 class="font-weight-normal mb-0">Update Admin Password</h6> --}}
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="justify-content-end d-flex">
                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                                        id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true">
                                        <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                        <a class="dropdown-item" href="#">January - March</a>
                                        <a class="dropdown-item" href="#">March - June</a>
                                        <a class="dropdown-item" href="#">June - August</a>
                                        <a class="dropdown-item" href="#">August - November</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($slug=="personal")
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Personal Information</h4>
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error: </strong>{{ Session::get('error_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success: </strong>{{ Session::get('success_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Vendor Username/Email</label>
                                <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_name">Name</label>
                                <input type="text" class="form-control" id="vendor_name"
                                    value="{{ Auth::guard('admin')->user()->name }}" name="vendor_name" placeholder="Enter Vendor Name" required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_address">Address</label>
                                <input type="text" class="form-control" id="vendor_address"
                                   @if (isset($vendorDetails['address']))
                                   value="{{$vendorDetails['address']}}" @endif name="vendor_address" placeholder="Enter Vendor Address" required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_city">City</label>
                                <input type="text" class="form-control" id="vendor_city"
                                @if (isset($vendorDetails['city'])) value="{{$vendorDetails['city']}}" @endif name="vendor_city" placeholder="Enter Vendor City" required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_state">State</label>
                                <input type="text" class="form-control" id="vendor_state"
                                @if (isset($vendorDetails['state'])) value="{{$vendorDetails['state']}}" @endif name="vendor_state" placeholder="Enter Vendor State" required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_country">Country</label>
                                {{-- <input type="text" class="form-control" id="vendor_country"
                                    value="{{$vendorDetails['country']}}" name="vendor_country" placeholder="Enter Vendor Country" required> --}}
                                    <select class="form-control" id="vendor_country" name="vendor_country" style="color: #495057;>
                                        <option value="">Select Country</option>
                                          @foreach ($countries as $country)
                                          <option value="{{$country['country_name']}}" @if (isset($vendorDetails['country']) && $country['country_name']
                                          ==$vendorDetails['country']) selected
                                               @endif>{{$country['country_name']}}
                                         </option>   
                                          @endforeach
                                     </select>
                            </div>
                            <div class="form-group">
                                <label for="vendor_pincode">Pincode</label>
                                <input type="text" class="form-control" id="vendor_pincode"
                                  @if (isset($vendorDetails['pincode']))  
                                 value="{{$vendorDetails['pincode']}}" @endif name="vendor_pincode" placeholder="Enter Vendor Pincode" required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Mobile</label>
                                <input type="text" class="form-control" id="vendor_mobile"
                                    placeholder="Enter 10 Digit Mobile Number"
                                    @if (isset($vendorDetails['mobile'])) value="{{$vendorDetails['mobile']}}" @endif name="vendor_mobile" required
                                    maxlength="10" minlength="10">
                            </div>
                            <div class="form-group">
                              <label for="vendor_image">Photo</label>
                              <input type="file" class="form-control" id="vendor_image"
                               name="vendor_image">
                               @if(!empty(Auth::guard('admin')->user()->image))
                               <br>
                                   <img  src="{{url('admin/images/photos/'.Auth::guard('admin')->user()->image)}}" width="100px" height="100px"/>
                                   <input type="hidden" name="current_vendor_image" value="{{Auth::guard('admin')->user()->image}}">
                               @endif
                          </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
                </div>
            
         
            @elseif ($slug=="business")
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Business Information</h4>
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error: </strong>{{ Session::get('error_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success: </strong>{{ Session::get('success_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Vendor Username/Email</label>
                                <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="shop_name">Shop Name</label>
                                <input type="text" class="form-control" id="shop_name"
                                  @if (isset($vendorDetails['shop_name']))
                                  value="{{$vendorDetails['shop_name']}}" @endif name="shop_name" placeholder="Enter Shop Name" >
                            </div>
                            <div class="form-group">
                                <label for="shop_address">Shop Address</label>
                                <input type="text" class="form-control" id="shop_address"
                                @if (isset($vendorDetails['shop_address'])) value="{{$vendorDetails['shop_address']}}" @endif name="shop_address" placeholder="Enter Shop Address" >
                            </div>
                            <div class="form-group">
                                <label for="shop_city">Shop City</label>
                                <input type="text" class="form-control" id="shop_city"
                                @if (isset($vendorDetails['shop_city']))  value="{{$vendorDetails['shop_city']}}" @endif name="shop_city" placeholder="Enter Shop City" >
                            </div>
                            <div class="form-group">
                                <label for="shop_state">Shop State</label>
                                <input type="text" class="form-control" id="shop_state"
                                @if (isset($vendorDetails['shop_state']))  value="{{$vendorDetails['shop_state']}}" @endif  name="shop_state" placeholder="Enter Shop State" >
                            </div>
                            <div class="form-group">
                                <label for="shop_country">Shop Country</label>
                                {{-- <input type="text" class="form-control" id="shop_country"
                                    value="{{$vendorDetails['shop_country']}}" name="shop_country" placeholder="Enter Shop Country" required> --}}
                                    <select class="form-control" id="shop_country" name="shop_country" style="color: #495057;">
                                       <option value="">Select Country</option>
                                         @foreach ($countries as $country)
                                         <option value="{{$country['country_name']}}" @if (isset($vendorDetails['shop_country'])
                                          && $country['country_name'] ==$vendorDetails['shop_country']) selected
                                              @endif>{{$country['country_name']}}
                                        </option>   
                                         @endforeach
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="shop_pincode">Shop Pincode</label>
                                <input type="text" class="form-control" id="shop_pincode"
                                @if (isset($vendorDetails['shop_pincode'])) value="{{$vendorDetails['shop_pincode']}}" @endif name="shop_pincode" placeholder="Enter Shop Pincode" >
                            </div>
                            <div class="form-group">
                                <label for="shop_mobile">Shop Mobile</label>
                                <input type="text" class="form-control" id="shop_mobile"
                                    placeholder="Enter 10 Digit Mobile Number"
                                    @if (isset($vendorDetails['shop_mobile'])) value="{{$vendorDetails['shop_mobile']}}"@endif name="shop_mobile" 
                                    maxlength="10" minlength="10">
                            </div>
                            <div class="form-group">
                                <label for="shop_website">Shop Website</label>
                                <input type="text" class="form-control" id="shop_website"
                                @if (isset($vendorDetails['shop_website']))  value="{{$vendorDetails['shop_website']}}" @endif name="shop_website" placeholder="Enter Shop Website" >
                            </div>
                            <div class="form-group">
                                <label for="business_license_number">Business License Number</label>
                                <input type="text" class="form-control" id="business_license_number"
                                @if (isset($vendorDetails['business_license_number'])) value="{{$vendorDetails['business_license_number']}}" @endif name="business_license_number" placeholder="Enter Business License Number" >
                            </div>
                            <div class="form-group">
                                <label for="gst_number">GST Number</label>
                                <input type="text" class="form-control" id="gst_number"
                                @if (isset($vendorDetails['gst_number'])) value="{{$vendorDetails['gst_number']}}" @endif name="gst_number" placeholder="Enter GST Number" >
                            </div>
                            <div class="form-group">
                                <label for="pan_number">PAN Number</label>
                                <input type="text" class="form-control" id="pan_number"
                                @if (isset($vendorDetails['pan_number'])) value="{{$vendorDetails['pan_number']}}" @endif name="pan_number" placeholder="Enter PAN Number" >
                            </div>
                            <div class="form-group">
                             <label for="address_proof">Address Proof</label>
                             <select class="form-control" name="address_proof" id="address_proof" style="color: #495057;>
                               <option value="Passport" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Passport")
                                   selected @endif>Passport</option>
                               <option value="Voting Card" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Voting Card")
                               selected @endif>Voting Card</option>
                               <option value="PAN" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="PAN")
                               selected @endif>PAN</option>
                               <option value="Driving License" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Driving License")
                               selected @endif>Driving License</option>
                               <option value="Aadhar Card" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Aadhar Card")
                               selected @endif>Aadhar Card</option>
                             </select>
                            </div>
                            <div class="form-group">
                              <label for="address_proof_image">Address Proof Image</label>
                              <input type="file" class="form-control" id="address_proof_image"
                               name="address_proof_image">
                               @if(!empty($vendorDetails['address_proof_image']))
                               <br>
                                   <img  src="{{url('admin/images/proofs/'.$vendorDetails['address_proof_image'])}}" width="100px" height="100px"/>
                                   <input type="hidden" name="current_address_proof" value="{{$vendorDetails['address_proof_image']}}">
                               @endif
                          </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
                </div>
            @elseif ($slug=="bank")
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Bank Information</h4>
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error: </strong>{{ Session::get('error_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success: </strong>{{ Session::get('success_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Vendor Username/Email</label>
                                <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="account_holder_name">Account Holder Name</label>
                                <input type="text" class="form-control" id="account_holder_name"
                                  @if (isset($vendorDetails['account_holder_name']))   
                                 value="{{$vendorDetails['account_holder_name']}}" @endif  name="account_holder_name" placeholder="Enter Account Holder Name" required>
                            </div>
                            <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name"
                                @if (isset($vendorDetails['bank_name']))  value="{{$vendorDetails['bank_name']}}" @endif name="bank_name" placeholder="Enter Bank Name" required>
                            </div>
                            <div class="form-group">
                                <label for="account_number">Account Number</label>
                                <input type="text" class="form-control" id="account_number"
                                @if (isset($vendorDetails['account_number'])) value="{{$vendorDetails['account_number']}}" @endif name="account_number" placeholder="Enter Account Number" required>
                            </div>
                            <div class="form-group">
                                <label for="bank_ifsc_code">Bank Ifsc Code</label>
                                <input type="text" class="form-control" id="bank_ifsc_code"
                                @if (isset($vendorDetails['bank_ifsc_code']))  value="{{$vendorDetails['bank_ifsc_code']}}" @endif name="bank_ifsc_code" placeholder="Enter Bank Ifsc Code" required>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
                </div>
            @endif
        </div> 
    @endsection
