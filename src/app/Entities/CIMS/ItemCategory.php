<?php

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ItemCategory extends Model
{
    protected $table = 'CIMS.item_categories';
    protected $primaryKey = 'item_id';

    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(LCategory::class, 'category_id','category_id');
    }
}
