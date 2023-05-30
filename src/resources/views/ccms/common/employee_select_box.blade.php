<div class="col-md-3 mb-1" style="@if(!empty($data->emp_id)) display: block @else display: none @endif" id="employee_div">
    <div class="row">
        <div class="col-md-12">
            <label>{{$label_name}}</label>
            @php
                $employee = [];

                if (old('emp_id') || ($data && $data->emp_id)) {

                    if (old('emp_id'))
                        $employee = DB::selectOne('select emp_id, emp_name from pmis.employee where emp_id = :emp_id', ['emp_id' => old('emp_id')]);
                    else
                        $employee = DB::selectOne('select emp_id, emp_name from pmis.employee where emp_id = :emp_id', ['emp_id' => $data->emp_id]);
                }
            @endphp
            <select name="{{$select_name}}" class="form-control emp_id" id="st_emp_id" style="width: 100%">

                @if ($employee)
                    <option selected="selected"
                            value="{{$employee->emp_id}}">
                        {{ $employee->emp_name}}
                    </option>
                @else
                    <option value="">Select one</option>
                @endif
            </select>
            @if($errors->has($select_name))
                <span class="help-block">{{$errors->first($select_name)}}</span>
            @endif
        </div>
    </div>
</div>


