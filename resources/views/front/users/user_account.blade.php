@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Account</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Home</a>
                </li>
                <li class="is-marked">
                    <a href="account.html">Account</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Account-Page -->
<div class="page-account u-s-p-t-80">
    <div class="container">
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
        <div class="row">
            <!-- Account Details -->
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <h2 class="account-h2 u-s-m-b-20" style="font-size: 18px">Update Contact Details</h2>
                    <p id="account-error"></p>
                    <p id="account-success"></p>
                    <form id="accountForm" action="javascript:;" method="POST">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-email">Email
                                <span class="astk">*</span>
                            </label>
                            <input value="{{Auth::user()->email}}" readonly disabled 
                            style="background-color: #e9e9e9"
                            class="text-field">
                            <p id="account-email"></p>
                        </div>  
                        <div class="u-s-m-b-30">
                            <label for="user-name">Name
                                <span class="astk">*</span>
                            </label>
                            <input id="user_name" name="name" type="text" value="{{Auth::user()->name}}"
                            class="text-field">
                            <p id="account-name"></p>
                        </div> 
                        <div class="u-s-m-b-30">
                            <label for="user-address">Address
                                <span class="astk">*</span>
                            </label>
                            <input id="user_address" name="address" type="text" value="{{Auth::user()->address}}"
                            class="text-field">
                            <p id="account-address"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-city">City
                                <span class="astk">*</span>
                            </label>
                            <input id="user_city" name="city" type="text" value="{{Auth::user()->city}}"
                            class="text-field">
                            <p id="account-city"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-state">State
                                <span class="astk">*</span>
                            </label>
                            <input id="user_state" name="state" type="text" value="{{Auth::user()->state}}"
                            class="text-field">
                            <p id="account-state"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-country">Country
                                <span class="astk">*</span>
                            </label>
                            <select class="text-field" id="user_country" name="country" style="color: #495057;">
                                <option value="">Select Country</option>
                                  @foreach ($countries as $country)
                                  <option value="{{$country['country_name']}}" @if (isset($vendorDetails['shop_country'])
                                   && $country['country_name'] ==Auth::user()->country) selected
                                       @endif>{{$country['country_name']}}
                                 </option>   
                                  @endforeach
                             </select>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-pincode">Pincode
                                <span class="astk">*</span>
                            </label>
                            <input id="user_pincode" name="pincode" type="text" value="{{Auth::user()->pincode}}"
                            class="text-field">
                            <p id="account-pincode"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-mobile">Mobile
                                <span class="astk">*</span>
                            </label>
                            <input id="user_mobile" name="mobile" type="text" value="{{Auth::user()->mobile}}"
                            class="text-field">
                            <p id="account-mobile"></p>
                        </div>
                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Update Details</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Account Details /- -->
            <!-- Update Password -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20" style="font-size: 18px">Update Password</h2>
                    <p id="password-success"></p>
                    <p id="password-error"></p>
                    <form id="passwordForm" action="javascript:;" method="post">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="current_password">Current Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="current_password" name="current_password" 
                            class="text-field" placeholder="Current Password">
                            <p id="password-current_password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="new_password">New Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="new_password" name="new_password" 
                            class="text-field" placeholder="New Password">
                            <p id="password-new_password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="confirm_password">Confirm Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="confirm_password" name="confirm_password"
                             class="text-field" placeholder="Confirm Password">
                             <p id="password-confirm_password"></p>
                        </div>
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Update Password /- -->
        </div>
    </div>
</div>
<!-- Account-Page /- -->


@endsection