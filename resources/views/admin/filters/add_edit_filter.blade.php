@extends('admin.layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Filters</h3>
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
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$title}}</h4>
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
                        <form class="forms-sample" @if (empty($filter['id'])) action="{{ url('admin/add-edit-filters') }}"
                            @else action="{{ url('admin/add-edit-filters/'.$filter['id']) }}" @endif  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="cat_ids">Select Category</label>
                                 <select name="cat_ids[]" id="cat_ids" class="form-control text-dark"
                                 multiple  style="height: 200px">
                                     @foreach ($categories as $section)
                                     <optgroup label="{{$section['name']}}"></optgroup>
                                     @foreach ($section['categories'] as $category)  
                                     <option @if (in_array($category['id'],$cat_ids)) selected                                          
                                     @endif value="{{$category['id']}}">&nbsp;&nbsp;&nbsp;
                                        ---&nbsp;{{$category['category_name']}} </option>
                                     @foreach ($category['subcategories'] as $subcategory)  
                                     <option @if (in_array($subcategory['id'],$cat_ids)) selected                                          
                                     @endif value="{{$subcategory['id']}}">&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;{{$subcategory['category_name']}}</option>
                                     @endforeach
                                     @endforeach
                                     @endforeach
                                 </select>
                            </div>
                            <div class="form-group">
                                <label for="filter_name">Filter Name</label>
                                <input type="text" class="form-control" id="filter_name"
                                     name="filter_name" placeholder="Enter Filter Name" @if (!empty($filter['filter_name']))
                                     value="{{ $filter['filter_name'] }}" @else value="{{old('filter_name')}}"
                                    @endif required>
                            </div>
                            <div class="form-group">
                                <label for="filter_column">Filter Column</label>
                                <input type="text" class="form-control" id="filter_column"
                                     name="filter_column" placeholder="Enter Filter Column" @if (!empty($filter['filter_column']))
                                     value="{{ $filter['filter_column'] }}" @else value="{{old('filter_column')}}"
                                    @endif required>
                            </div>
                            <button style="background-color: #4B49AC; border-color: #4B49AC;" type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
