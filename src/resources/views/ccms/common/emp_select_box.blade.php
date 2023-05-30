<div class="col-md-3 mb-1">
    <div class="row">
        <div class="col-md-12">
            <label class="input-required">{{$label_name}} @if ($required) <span class="required"></span> @endif </label>
            @php
                $employee = [];

                if (old('emp_id') || ($data && $data->emp_id)) {

                    if (old('emp_id'))
                        $employee = DB::selectOne('select emp_id, emp_name from pmis.employee where emp_id = :emp_id', ['emp_id' => old('emp_id')]);
                    else
                        $employee = DB::selectOne('select emp_id, emp_name from pmis.employee where emp_id = :emp_id', ['emp_id' => $data->emp_id]);
                }
            @endphp
            <select name="{{$select_name}}" @if ($required) required @endif class="form-control emp_id" style="width: 100%">

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


