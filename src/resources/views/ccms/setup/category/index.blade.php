@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
        @if(Session::has('message'))
            <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                 role="alert" style="margin-bottom:0.67rem !important;">
                {{ Session::get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        </div>
        <div class="col-4 col-md-4">
            <div class="card">
                <div class="card-title">Add Category</div>
                <div class="card-body">
                    <form action="{{route('category-index')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$data->catagory_id}}" name="catagory_id">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="required">Category Name</label>
                                <input type="text" placeholder="Category name"
                                        name="catagory_name" class="form-control" required  value="{{old('catagory_name',$data->catagory_name)}}"
                                        id="catagory_name" autocomplete="off" maxlength="500">
                                <span class="text-danger">{{ $errors->first('catagory_name') }}</span>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="">Category Name Bangla</label>
                                <input type="text" placeholder="Category Name Bangla"
                                        name="catagory_name_bn" class="form-control"   value="{{old('catagory_name_bn',$data->catagory_name_bn)}}"
                                        id="catagory_name_bn" autocomplete="off" maxlength="2000">
                                <span class="text-danger">{{ $errors->first('catagory_name_bn') }}</span>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="">Parent Category</label>
                                <select name="parent_id" id="parent_id" class="form-control select2">
                                        <option value="0">Select One</option>
                                    @foreach ($categories as $category)
                                        @include('ccms.setup.category.option', ['category' => $category,"space" => ''])
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-12 mt-2">
                                <label class="control-label" for="meta_tags">Order no </label>
                                <div class="">
                                    <input type="text" class="form-control" name="sort_order" id="sort_order" value="{{old('sort_order', $data->sort_order) }}" />
                                </div>
                            </div>

                            <div class="col-md-12 mt-2"  style="margin-top: 27px">
                                <label class="">Active</label>
                                <div class="ml-2 custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="active_yes" name="active_yn" value="Y" {{old('active_yn',$data->active_yn) != 'N' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="active_yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="active_no" name="active_yn" value="N" {{old('active_yn',$data->active_yn) == 'N' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="active_no">No</label>
                                </div>
                                <span class="text-danger">{{ $errors->first('active_yn') }}</span>
                            </div>

                        </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-right" id="add">
                                    @if($data->catagory_id)
                                        <button type="submit" id="add"
                                                class="btn btn btn-dark shadow mr-1 mb-1 btn-info"><i class="bx bx-save"></i> Update
                                        </button>
                                        <a href="{{ url()->previous() }}">
                                            <button type="button" id="add" class="btn btn btn-dark shadow mr-1 mb-1 btn-danger"><i class="bx bx-sync"></i>Previous
                                            </button>
                                        </a>
                                        <a type="reset" id="reset" href="{{route('category-index')}}"
                                                class="btn btn btn-outline shadow mb-1 btn-outline-primary"><i class="bx bx-exit"></i> Reset
                                        </a>
                                    @else
                                    <button type="submit" id="add"
                                            class="btn btn btn-dark shadow mr-1 mb-1 btn-info"><i class="bx bx-save"></i> Save
                                    </button>
                                        <a href="{{ url()->previous() }}">
                                            <button type="button" id="add" class="btn btn btn-dark shadow mr-1 mb-1 btn-danger"><i class="bx bx-sync"></i>Previous
                                            </button>
                                        </a>
                                    <a type="reset" id="reset" href="{{route('category-index')}}"
                                            class="btn btn btn-outline shadow mb-1 btn-outline-primary"><i class="bx bx-exit"></i> Reset
                                    </a>
                                    @endif
                                </div>
                            </div>

                    </form>
                </div>

            </div>

        </div>
        <div class="col-8 col-md-8">
        @include('ccms.setup.category.list')
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">


        function requisitionList() {

            $('.dataTable').DataTable({
                processing: false,
                serverSide: false,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Show All"]],
                pageLength: 25,
                ordering: false,
                bSort : false
                {{--ajax: {--}}
                {{--    "type": "POST",--}}
                {{--    "url": "{{route('setup.category-datatable-list')}}",--}}
                {{--    "dataType": "json",--}}
                {{--    "data" : {--}}
                {{--        _token: "{{ csrf_token() }}"--}}
                {{--    }--}}
                {{--},--}}
                {{--columns: [--}}
                {{--    {"data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: true},--}}
                {{--    {data: 'category_name', name: 'category_name', searchable: true},--}}
                {{--    {data: 'category_name_bn', name: 'category_name_bn', searchable: true},--}}
                {{--    {data: 'parent_name', name: 'parent_name', searchable: true},--}}
                {{--    {data: 'status', name: 'status', searchable: true, class:"text-center"},--}}
                {{--    {data: 'action', name: 'action', searchable: false,class:"text-center"},--}}
                {{--]--}}
            });
        };

        $(document).ready(function() {
            requisitionList();
        });
        function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
                    return false;

                return true;
            }
    </script>

@endsection
