<div class="row requisition-item">
    <input type="hidden" name="variants" id="variants">
    <div class="col">
        <div class="loading_item" style="display: none">
            <div class="spinner-border text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">Item Name</label>
                        <input type="hidden" id="data_item_id" />
                        <input type="hidden" id="unit_code_val" />
                        <input type="text" placeholder="Item Name"
                               name="item_name" class="form-control"
                               value=""
                               data-url="{{route('item-search-ajax')}}"
                               id="item_name_search" maxlength="500" autocomplete="off">
                        <div id="suggesstion-box"></div>
                        <span class="text-danger">{{ $errors->first('item_name') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">Brand</label>
                        <select class="form-control select2" name="brand_id" id="brand_id" data-url="{{route('item-variant-option')}}">
                            <option value="">Select One</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('brand_id') }}</span>
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
        <div class="variants">
            <div class="row">
                <div class="col-md-12">
                <table class="table table-sm pb-2" id="variant_table">
                    <thead class="thead-dark ">
                        <tr>
                            <th>VARIANT NAME</th>
                            <th>VARIANT OPTION </th>
                            <th>ACTION </th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #f5f2d7" class="mt-2">
                    <tr class="variant-cloned-row">
                        <td>
                            <div class="form-group">
                                <select class="form-control select2 variant_select variant_id" style="width: 100%" name="variant_id" id="variant_id" data-url="{{route('item-variant-option')}}">
                                    <option value="">Select One</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <select class="form-control select2 variant_option" style="width: 100%" name="variant_option" id="variant_option">
                                    <option value="">Select One</option>
                                </select>
                            </div>
                        </td>
                        <td>
                          <div class="form-group">
                                <a class="addVariant"  href=""><i class="bx bx-plus-circle  bx-md"></i></a>
                           </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
              </div>
                </div>
        </div>

    </div>
</div>

