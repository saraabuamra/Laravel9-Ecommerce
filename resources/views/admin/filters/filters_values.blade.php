<?php
use App\Models\ProductsFilter;
?>
@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Filters Values</h4>
              <a style="background-color: #4B49AC;border-color: #4B49AC; float: right; width:150px" 
              class="btn btn-primary" href="{{url('admin/filters')}}">View Filters</a>
              <a style="background-color: #4B49AC;border-color: #4B49AC; float: left; width:150px" 
              class="btn btn-primary" href="{{url('admin/add-edit-filter-value')}}">Add Filter Values</a>
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
                         Filter ID
                      </th>
                      <th>
                        Filter Name
                     </th>
                      <th>
                        Filter Value
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
                    @foreach ($filters_values as $filter )
                    <tr>
                      <td>
                        {{$filter['id']}}
                      </td>
                      <td>
                        {{$filter['filter_id']}}
                      </td>
                      <td>
                        <?php
                          echo $getFilterName = ProductsFilter::getFilterName($filter['filter_id']);
                          ?>
                      </td>
                      <td>
                        {{$filter['filter_value']}}
                      </td>
                      <td>
                        @if ($filter['status']==1)
                        <a class="updateFilterValueStatus" id="filter-{{$filter['id']}}" filter_id="{{$filter['id']}}"
                         href="javascript:void(0)"> 
                          <i style="font-size: 25px; color:#4B49AC;" class="mdi mdi-lock-open-outline" status="Active"></i> 
                        </a>
                       
                        @else
                        <a class="updateFilterValueStatus" id="filter-{{$filter['id']}}" filter_id="{{$filter['id']}}"
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
