<?php use App\Models\Product; ?>
@extends('front.layout.layout')

@section('content')
 <!-- Page Introduction Wrapper -->
 <div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Cart</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{url('/')}}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{url('/cart')}}">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form>
                    <!-- Products-List-Wrapper -->
                    <div class="table-wrapper u-s-m-b-60">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getCartItems as $item)
                                <?php
                                $getDiscountAttributePrice = Product::getDiscountAttributePrice(
                                    $item['product_id'],$item['size']);
                                 ?>
                                <tr>
                                    <td>
                                        <div class="cart-anchor-image">
                                            <a href="single-product.html">
                                                <img src="{{asset('front/images/product_images/small/'.$item['product']['product_image'])}}" alt="Product">
                                                <h6>{{$item['product']['product_name']}} ({{$item['product']['product_code']}}) - {{$item['size']}}<br>
                                                    Color: {{$item['product']['product_color']}}<br>
                                                </h6>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-price">
                                            @if ($getDiscountAttributePrice['discount'] > 0)
                                            <div class="price-template" style="margin-left: -20px" >
                                                <div class="item-new-price">
                                                    ${{ $getDiscountAttributePrice['final_price'] }}
                                                </div>
                                                <div class="item-old-price" style="margin-left: -35px">
                                                    ${{ $getDiscountAttributePrice['product_price'] }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ${{ $getDiscountAttributePrice['final_price'] }}
                                                </div>
                                            </div>
                                        @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-quantity">
                                            <div class="quantity">
                                                <input type="text" class="quantity-text-field" value="{{$item['quantity']}}">
                                                <a class="plus-a" data-max="1000">&#43;</a>
                                                <a class="minus-a" data-min="1">&#45;</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-price">
                                            ${{ $getDiscountAttributePrice['final_price'] * $item['quantity'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-wrapper">
                                            <button class="button button-outline-secondary fas fa-sync"></button>
                                            <button class="button button-outline-secondary fas fa-trash"></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Products-List-Wrapper /- -->
                    <!-- Coupon -->
                    <div class="coupon-continue-checkout u-s-m-b-60">
                        <div class="coupon-area">
                            <h6>Enter your coupon code if you have one.</h6>
                            <div class="coupon-field">
                                <label class="sr-only" for="coupon-code">Apply Coupon</label>
                                <input id="coupon-code" type="text" class="text-field" placeholder="Coupon Code">
                                <button type="submit" class="button">Apply Coupon</button>
                            </div>
                        </div>
                        <div class="button-area">
                            <a href="shop-v1-root-category.html" class="continue">Continue Shopping</a>
                            <a href="checkout.html" class="checkout">Proceed to Checkout</a>
                        </div>
                    </div>
                    <!-- Coupon /- -->
                </form>
                <!-- Billing -->
                <div class="calculation u-s-m-b-60">
                    <div class="table-wrapper-2">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Cart Totals</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h3 class="calc-h3 u-s-m-b-0">Subtotal</h3>
                                    </td>
                                    <td>
                                        <span class="calc-text">$222.00</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3 class="calc-h3 u-s-m-b-8">Shipping</h3>
                                        <div class="calc-choice-text u-s-m-b-4">Flat Rate: Not Available</div>
                                        <div class="calc-choice-text u-s-m-b-4">Free Shipping: Not Available</div>
                                        <a data-toggle="collapse" href="#shipping-calculation" class="calc-anchor u-s-m-b-4">Calculate Shipping
                                        </a>
                                        <div class="collapse" id="shipping-calculation">
                                            <form>
                                                <div class="select-country-wrapper u-s-m-b-8">
                                                    <div class="select-box-wrapper">
                                                        <label class="sr-only" for="select-country">Choose your country
                                                        </label>
                                                        <select class="select-box" id="select-country">
                                                            <option selected="selected" value="">Choose your country...
                                                            </option>
                                                            <option value="">United Kingdom (UK)</option>
                                                            <option value="">United States (US)</option>
                                                            <option value="">United Arab Emirates (UAE)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="select-state-wrapper u-s-m-b-8">
                                                    <div class="select-box-wrapper">
                                                        <label class="sr-only" for="select-state">Choose your state
                                                        </label>
                                                        <select class="select-box" id="select-state">
                                                            <option selected="selected" value="">Choose your state...
                                                            </option>
                                                            <option value="">Alabama</option>
                                                            <option value="">Alaska</option>
                                                            <option value="">Arizona</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="town-city-div u-s-m-b-8">
                                                    <label class="sr-only" for="town-city"></label>
                                                    <input type="text" id="town-city" class="text-field" placeholder="Town / City">
                                                </div>
                                                <div class="postal-code-div u-s-m-b-8">
                                                    <label class="sr-only" for="postal-code"></label>
                                                    <input type="text" id="postal-code" class="text-field" placeholder="Postcode / Zip">
                                                </div>
                                                <div class="update-totals-div u-s-m-b-8">
                                                    <button class="button button-outline-platinum">Update Totals</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3 class="calc-h3 u-s-m-b-0" id="tax-heading">Tax</h3>
                                        <span> (estimated for your country)</span>
                                    </td>
                                    <td>
                                        <span class="calc-text">$0.00</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3 class="calc-h3 u-s-m-b-0">Total</h3>
                                    </td>
                                    <td>
                                        <span class="calc-text">$220.00</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Billing /- -->
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection