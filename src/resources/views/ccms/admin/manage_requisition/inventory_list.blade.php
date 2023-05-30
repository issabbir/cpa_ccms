@php $stocks = \App\Helpers\HelperClass::stocks($item_id) @endphp
@if(filled($stocks))
<div class="row mt-2">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th>Item Name</th>
                <th>Variant</th>
                <th>Brand</th>
                <th>Qty</th>
                <th>Action</th>
            </tr>
            @foreach($stocks as $stock)
            <tr>
                <td>{{$stock->item_name}}</td>
                <td>{{$stock->variants_string}}</td>
                <td>{{$stock->brand_name}}</td>
                <td>{{$stock->stock_quantity}} {{$stock->unit_code}}</td>
                <td><a class="view-inventory" href="{{route('requisition-inventory-view')}}?item_id={{$stock->item_id}}&brand_id={{$stock->brand_id}}&department_id={{$stock->department_id}}&variants={{$stock->variants_string}}">
                        @if(old('item_id') == $stock->item_id && old('cctv_manufacturer_id') == $stock->brand_id && old('color_type_id') == $stock->variants_string)
                        <i class="bx bx-check font-icon"></i>
                        @else
                        <i class="bx bx-plus-circle font-icon"></i>
                        @endif
                    </a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
    @else
    <div class="row mt-2">
        <div class="col-md-12">
            <h5 class="text-warning">No Available Stock</h5>
        </div>
    </div>
@endif
