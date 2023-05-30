<tr class="{{$category['active_yn'] != 'Y' ? 'table-danger' : '' }} {{$data->catagory_id==$category['catagory_id'] ? 'table-success' : ''}}">
    <td>{!! $space !!} {{$category['catagory_name']}} ({{$category['catagory_name_bn']}})</td>
    <td>{!! $space !!} {{$category['sort_order']}}</td>
    <td>{!! $space !!} {!! $category['active_yn'] == 'Y' ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
    {{--                                <td>{{$category->created_at}}</td>--}}
        <td class="text-center">
            <a href="{{  route('category-edit',$category['catagory_id']) }}" ><span class="bx bx-edit cursor-pointer"></span></a> ||
            <a href="{{ route('category-delete',$category['catagory_id']) }}" onclick="return confirm('Are you sure you want to delete this category?');"><span class="bx bx-trash cursor-pointer text-danger"></span></a>
        </td>
</tr>
@if ($category['child'])
    @foreach($category['child'] as $category)
        @include('ccms.setup.category.item', ['category' => $category,"space" => $space ."&nbsp;&nbsp;&nbsp;"])
    @endforeach
@endif
