
<option @if( isset($data->catagory_id) ? ($category['catagory_id']==$data->parent_id) : '' || $category['catagory_id'] == old('parent_id')) selected @endif value="{{$category['catagory_id']}}">{!! $space !!} {{$category['catagory_name']}}</option>
@if ($category['child'])
    @foreach($category['child'] as $category)
        @include('ccms.setup.category.option', ['category' => $category,"space" => $space ."&nbsp;&nbsp;&nbsp;"])
    @endforeach
@endif
