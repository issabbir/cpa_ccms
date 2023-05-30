<fieldset class="border p-2">
    <legend class="w-auto" style="font-size: 18px;">Add Watchman</legend>
    <table role="table" aria-busy="false" aria-colcount="4" class="table b-table table-hover table-bordered">
        <thead role="rowgroup" class="">
        <tr role="row">
            {{--<th role="columnheader" scope="col" aria-colindex="1" class="">Sl</th>--}}
            <th role="columnheader" scope="col" aria-colindex="2" class="">Watchman</th>
            {{-- <th role="columnheader" scope="col" aria-colindex="3" class="">Chief</th> --}}
            <th role="columnheader" scope="col" aria-colindex="4" class="">Action</th>
        </tr>
        </thead>
        <tbody role="rowgroup" id="watchmanMemberForm">
        </tbody>
    </table>
    <button type="button" class="btn mr-2 btn-secondary btn-sm" id="addwatchmanMemberForm">Add</button>
</fieldset>


<div class="d-none">
    <select class="custom-select select2" name="memberid-template" id="memberid-template">
           @if($data['loadWatchman'])
                @foreach($data['loadWatchman'] as $option)
                    {!!$option!!}
                @endforeach
            @endif
    </select>
</div>

