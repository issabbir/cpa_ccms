<input type="hidden" value="{{isset($stockView->stock_quantity) ? $stockView->stock_quantity : ''}}" name="stock_quantity">
<input type="hidden" value="{{isset($stock->warranty_yn) ? $stock->warranty_yn : ''}}" id="stock_warranty_yn" name="stock_warranty_yn">
<input type="hidden" value="{{isset($stockView->store_id) ? $stockView->store_id : ''}}" name="store_id">
<input type="hidden" value="{{isset($stockView->department_id) ? $stockView->department_id : ''}}" name="department_id">
<input type="hidden" value="{{isset($stockView->variants_string) ? $stockView->variants_string : ''}}" name="variants">
<input type="hidden" value="{{isset($stockView->brand_id) ? $stockView->brand_id : ''}}" name="brand_ids" id="brand_ids">
<input type="hidden" value="{{isset($stockView->item_id) ? $stockView->item_id : ''}}" name="item_ids" id="item_id">

<div class="row mt-2">
    <div class="col-sm-3">
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" id="tab_item_name" name="tab_item_name" autocomplete="off"
                   value="{{ old('tab_item_name', isset($stockView->item_name) ? $stockView->item_name : '' ) }}"
                   class="form-control" readonly>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Brand Name</label>
            <input type="text" id="brand_name" name="brand_names" autocomplete="off"
                   value="{{ old('brand_name', isset($stockView->brand_name) ? $stockView->brand_name : '' ) }}"
                   class="form-control" readonly>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Variants Name</label>
            <input type="text" id="variants_string" name="variants_string" autocomplete="off"
                   value="{{ old('variants_string', isset($stockView->variants_string) ? $stockView->variants_string : '' ) }}"
                   class="form-control" readonly>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="required">QUANTITY</label>
            <input type="number" id="tab_quantity" name="tab_quantity" autocomplete="off"
                   class="form-control">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Remarks</label>
            <input type="text" id="tab_remarks" name="tab_remarks" autocomplete="off"
                   class="form-control">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Description</label>
            <textarea id="tab_description" style="height: 37px" name="tab_description" autocomplete="off"
                      class="form-control" cols="30" rows="10"></textarea>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="mb-1">REPLACEMENT STATUS</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input status" type="radio"
                           name="replacement_yn" id="replacement_yes"
                           checked
                           value="{{ \App\Enums\YesNoFlag::YES }}"/>
                    <label class="form-check-label">YES</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input status" type="radio"
                           name="replacement_yn"
                           id="replacement_no" value="{{ \App\Enums\YesNoFlag::NO }}"/>
                    <label class="form-check-label">NO</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
