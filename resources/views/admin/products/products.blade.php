@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Products</h4>
              <a style="background-color: #4B49AC;border-color: #4B49AC; float: right; width:150px" class="btn btn-primary" href="{{url('admin/add-edit-product')}}">Add Product</a>
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Success: </strong>{{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif
              <div class="table-responsive pt-3">
                <table id="products" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                         ID
                      </th>
                      <th>
                        Product Name
                      </th>
                      <th>
                        Product Code
                      </th>
                      <th>
                        Product Color
                      </th>
                      <th>
                        Product Image
                      </th>
                      <th>
                        Category
                      </th>
                      <th>
                        Section
                      </th>
                      <th>
                        Added by
                      </th>
                      <th>
                        Status
                      </th>
                      <th>
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product )
                    <tr>
                      <td>
                        {{$product['id']}}
                      </td>
                      <td>
                        {{$product['product_name']}}
                      </td>
                      <td>
                        {{$product['product_code']}}
                      </td>
                      <td>
                        {{$product['product_color']}}
                      </td>
                      <td>
                        @if(!empty($product['product_image']))
                        <img style="height: 120px;width:120px" src="{{asset('front/images/product_images/small/'.$product['product_image'])}}">
                        @else
                        <img style="height: 120px;width:120px" src="{{asset('front/images/product_images/small/no-image.png')}}">
                      @endif
                      </td>
                      <td>
                        {{$product['category']['category_name']}}
                      </td>
                      <td>
                        {{$product['section']['name']}}
                      </td>
                      <td>
                        @if ($product['admin_type']=="vendor")
                          <a target="_blank" href="{{url('admin/view-vendor-details/'.
                          $product['admin_id'])}}">
                          {{ucfirst($product['admin_type'])}}</a>
                       @else
                        {{ucfirst($product['admin_type'])}}
                        @endif
                      </td>
                      <td>
                        @if ($product['status']==1)
                        <a class="updateProductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}"
                         href="javascript:void(0)"> 
                          <i style="font-size: 25px; color:#4B49AC;" class="mdi mdi-lock-open-outline" status="Active"></i> 
                        </a>
                       
                        @else
                        <a class="updateProductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}"
                         href="javascript:void(0)"> 
                        <i style="font-size: 25px;color:#4B49AC;" class="mdi mdi-lock" status="Inactive"></i></a>
                            @endif
                      </td>
                      <td>
                       <a title="Add/Edit Product" href="{{url('admin/add-edit-product/'.$product['id'])}}">
                        <i style="font-size: 25px ;color:#4B49AC;" 
                        class="mdi mdi-pencil-box"></i> </a>
                        <a title="Add Attributes" href="{{url('admin/add-edit-attributes/'.$product['id'])}}">
                          <i style="font-size: 25px ;color:#4B49AC;" 
                          class="mdi mdi-plus-box"></i> </a>
                          <a title="Add Images" href="{{url('admin/add-images/'.$product['id'])}}">
                            <i style="font-size: 25px ;color:#4B49AC;" 
                            class="mdi mdi-library-plus"></i> </a>
                            <a href="javascript:void(0)" module="product" class="confirmDelete" moduleid="{{$product['id']}}">
                                <i style="font-size: 25px ;color:#4B49AC;" 
                                class="mdi mdi-file-excel-box"></i> </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
@endsection
