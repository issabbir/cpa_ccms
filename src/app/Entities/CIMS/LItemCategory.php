<?php

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class LItemCategory extends Model
{
    protected $table = 'CIMS.l_item_category';
    protected $primaryKey = 'category_id';
}
