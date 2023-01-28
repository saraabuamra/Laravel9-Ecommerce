@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Categories</h4>
              <a style="background-color: #4B49AC;border-color: #4B49AC; float: right; width:150px" class="btn btn-primary" href="{{url('admin/add-edit-category')}}">Add Category</a>
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Success: </strong>{{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif
              <div class="table-responsive pt-3">
                <table id="categories" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                         ID
                      </th>
                      <th>
                        Category
                      </th>
                      <th>
                        Parent Category
                      </th>
                      <th>
                        Section
                      </th>
                      <th>
                        URL
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
                    @foreach ($categories as $category )
                    @if (isset($category['parentcategory']['category_name'])&& !empty(
                     $category['parentcategory']['category_name']))
                     @php $parent_category =  $category['parentcategory']['category_name']; @endphp
                    @else 
                    @php $parent_category = "Root";   @endphp 
                    @endif
                    <tr>
                      <td>
                        {{$category['id']}}
                      </td>
                      <td>
                        {{$category['category_name']}}
                      </td>
                      <td>
                        {{$parent_category}}
                      </td>
                      <td>
                        {{$category['section']['name']}}
                      </td>
                      <td>
                        {{$category['url']}}
                      </td>
                      <td>
                        @if ($category['status']==1)
                        <a class="updateCategoryStatus" id="category-{{$category['id']}}" category_id="{{$category['id']}}"
                         href="javascript:void(0)"> 
                          <i style="font-size: 25px; color:#4B49AC;" class="mdi mdi-lock-open-outline" status="Active"></i> 
                        </a>
                       
                        @else
                        <a class="updateCategoryStatus" id="category-{{$category['id']}}" category_id="{{$category['id']}}"
                         href="javascript:void(0)"> 
                        <i style="font-size: 25px;color:#4B49AC;" class="mdi mdi-lock" status="Inactive"></i></a>
                            @endif
                      </td>
                      <td>
                       <a href="{{url('admin/add-edit-category/'.$category['id'])}}">
                        <i style="font-size: 25px ;color:#4B49AC;" 
                        class="mdi mdi-pencil-box"></i> </a>
                            <a href="javascript:void(0)" module="category" class="confirmDelete" moduleid="{{$category['id']}}">
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
