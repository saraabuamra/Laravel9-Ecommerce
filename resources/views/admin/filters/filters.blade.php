<?php
 use App\Models\Category;
?>
@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Filters</h4>
              <a style="background-color: #4B49AC;border-color: #4B49AC; float: right; width:150px" 
              class="btn btn-primary" href="{{url('admin/filters-values')}}">View Filter Values</a>
              <a style="background-color: #4B49AC;border-color: #4B49AC; float: left; width:163px"
               class="btn btn-primary" href="{{url('admin/add-edit-filters')}}">Add Filter Columns</a>
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Success: </strong>{{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif
              <div class="table-responsive pt-3">
                <table id="filters" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                         ID
                      </th>
                      <th>
                         Filter Name
                      </th>
                      <th>
                        Filter Column
                     </th>
                     <th>
                        Categories
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
                    @foreach ($filters as $filter )
                    <tr>
                      <td>
                        {{$filter['id']}}
                      </td>
                      <td>
                        {{$filter['filter_name']}}
                      </td>
                      <td>
                        {{$filter['filter_column']}}
                      </td>
                      <td>
                        <?php 
                        $catIds = explode(",",$filter['cat_ids']) ;
                        foreach ($catIds as $key => $catId) {
                         $category_name = Category::getCategoryName($catId);
                         echo $category_name. " ";
                        }
                        ?>
                      </td>
                      <td>
                        @if ($filter['status']==1)
                        <a class="updateFilterStatus" id="filter-{{$filter['id']}}" filter_id="{{$filter['id']}}"
                         href="javascript:void(0)"> 
                          <i style="font-size: 25px; color:#4B49AC;" class="mdi mdi-lock-open-outline" status="Active"></i> 
                        </a>
                       
                        @else
                        <a class="updateFilterStatus" id="filter-{{$filter['id']}}" filter_id="{{$filter['id']}}"
                         href="javascript:void(0)"> 
                        <i style="font-size: 25px;color:#4B49AC;" class="mdi mdi-lock" status="Inactive"></i></a>
                            @endif
                      </td>
                      <td>
                       <a href="{{url('admin/add-edit-filter/'.$filter['id'])}}">
                        <i style="font-size: 25px ;color:#4B49AC;" 
                        class="mdi mdi-pencil-box"></i> </a>
                            <a href="javascript:void(0)" module="filter" class="confirmDelete" moduleid="{{$filter['id']}}">
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
