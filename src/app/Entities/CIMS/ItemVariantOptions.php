<?php

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ItemVariantOptions extends Model
{
    protected $table = 'cims.item_variant_options';
    protected $primaryKey = 'item_id';

    protected $with = ['variant_name','variant_options'];
    protected $appends = ['option_name'];

    public function variant_name()
    {
        return $this->belongsTo(Variant::class, 'variant_id','variant_id');
    }
    public function variant_options()
    {
        return $this->belongsTo(VariantOptions::class, 'variant_option_id','variant_option_id');
    }

    public function getOptionNameAttribute()
    {
        $data = [];
        if (isset($this->variant_options) && filled($this->variant_options)){
            foreach ($this->variant_options as $variant_option){
                $data[] = isset($variant_option->variant_option_name) ? $variant_option->variant_option_name : '';
            }
            return implode(",",$data);
        }
        return $data;
    }

}
