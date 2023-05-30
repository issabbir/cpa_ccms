<?php

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class VariantOptions extends Model
{
    protected $table = 'cims.variant_options';
    protected $primaryKey = 'variant_option_id';

    protected $with = ['variants'];

    public function variants()
    {
        return $this->hasOne(Variant::class, 'variant_id','variant_option_id');
    }
}
