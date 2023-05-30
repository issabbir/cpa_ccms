<label class="input-required ($required) ?'required':''">{{$label_name}} </label>
<select name="{{$select_name}}" style="width: 100%"  id="emp_id" @if ($required) required @endif class="form-control">
    <option value="" >Select one </option>
    <option {{ ( old("emp_id", ($data)?$data->emp_id:'')) ? "selected" : ""  }} value="{{ ($data) ? $data->emp_id:'' }}">{{ ($data) ? $data->emp_id:'' }}</option>
</select>
@if($errors->has($select_name))
    <span class="help-block">{{$errors->first($select_name)}}</span>
@endif
@section('footer-script')
    @parent
        <!--Load custom script-->
    <script>

        $(document).ready(function () {
            $("#emp_id").select2({
                minimumInputLength: 1,
                dropdownPosition: 'below',
                allowClear: true,
                placeholder: 'tttttt',
                ajax: {
                    url: '{{route('employee-list-by-code')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {
                                    id: obj.emp_id,
                                    text: obj.emp_name,
                                };
                            })
                        };
                    },
                    cache: false
                },
            });
        });
    </script>
@endsection

{{--@if ($required) <span class="required"></span> @endif--}}
{{--($required) ?'required':''--}}
