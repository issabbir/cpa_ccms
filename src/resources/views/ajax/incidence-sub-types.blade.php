<label class="required" for="incidence_subtype_id">Incidence</label>
<select class="custom-select" id="incidence_subtype_id" name="incidence_subtype_id" required>
    <option value="">--Please Select--</option>
    @if($incidenceSubTypes)
        @foreach($incidenceSubTypes as $incidenceSubType)
            <option value="{{$incidenceSubType->incidence_subtype_id}}">{{$incidenceSubType->incidence_subtype_name}}</option>>
        @endforeach
    @endif
</select>