@if($branches)
    <option value="">--Please Select--</option>
    @foreach($branches as $branch)
        <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
    @endforeach
@endif