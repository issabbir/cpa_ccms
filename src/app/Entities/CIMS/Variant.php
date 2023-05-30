<?php

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $table = 'cims.variants';
    protected $primaryKey = 'variant_id';

    protected $with = ['variant_options'];
    protected $appends = ['option_name'];

    public function variant_options()
    {
        return $this->hasMany(VariantOptions::class, 'variant_id','variant_id');
    }
    public function getOptionNameAttribute()
    {
        $data = [];
        foreach ($this->variant_options as $variant_option){
            $data[] = $variant_option->variant_option_name;
        }
        return implode(",",$data);
    }
}
