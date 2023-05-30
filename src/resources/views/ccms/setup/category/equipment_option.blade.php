<option @if( isset($data->catagory_no) ? ($category['catagory_no']==$data->catagory_no) : '' || $category['catagory_no'] == old('catagory_no')) selected @endif value="{{$category['catagory_no']}}">{!! $space !!} {{$category['catagory_name']}}</option>
@if ($category['child'])
    @foreach($category['child'] as $category)
        @include('ccms.setup.category.equipment_option', ['category' => $category,"space" => $space ."&nbsp;&nbsp;&nbsp;"])
    @endforeach
@endif
