@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Sections</h4>
              <a style="background-color: #4B49AC;border-color: #4B49AC; float: right; width:150px" class="btn btn-primary" href="{{url('admin/add-edit-section')}}">Add Section</a>
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Success: </strong>{{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif
              <div class="table-responsive pt-3">
                <table id="sections" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                         ID
                      </th>
                      <th>
                         Name
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
                    @foreach ($sections as $section )
                    <tr>
                      <td>
                        {{$section['id']}}
                      </td>
                      <td>
                        {{$section['name']}}
                      </td>
                      <td>
                        @if ($section['status']==1)
                        <a class="updateSectionStatus" id="section-{{$section['id']}}" section_id="{{$section['id']}}"
                         href="javascript:void(0)"> 
                          <i style="font-size: 25px; color:#4B49AC;" class="mdi mdi-lock-open-outline" status="Active"></i> 
                        </a>
                       
                        @else
                        <a class="updateSectionStatus" id="section-{{$section['id']}}" section_id="{{$section['id']}}"
                         href="javascript:void(0)"> 
                        <i style="font-size: 25px;color:#4B49AC;" class="mdi mdi-lock" status="Inactive"></i></a>
                            @endif
                      </td>
                      <td>
                       <a href="{{url('admin/add-edit-section/'.$section['id'])}}">
                        <i style="font-size: 25px ;color:#4B49AC;" 
                        class="mdi mdi-pencil-box"></i> </a>
                            <a href="javascript:void(0)" module="section" class="confirmDelete" moduleid="{{$section['id']}}">
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
