<?php

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class LItem extends Model
{
    protected $table = 'CIMS.l_item';
    protected $primaryKey = 'item_id';

//    protected $with = [];
    public $appends = ['category_id','category_name','department_id','department_name','brand_id','brand_name'];

    public function category()
    {
        return $this->hasMany(ItemCategory::class, 'item_id','item_id');
    }
    public function department()
    {
        return $this->hasMany(ItemDepartment::class, 'item_id','item_id');
    }
    public function brand()
    {
        return $this->hasMany(ItemBrands::class, 'item_id','item_id');
    }
    public function variants()
    {
        return $this->hasMany(ItemVariantOptions::class, 'item_id','item_id');
    }
    public function unit()
    {
        return $this->belongsTo(LUnit::class, 'unit_id');
    }

    public function getCategoryNameAttribute()
    {
        $category_name = [];
         foreach ($this->category as $category){
             $category_name[] = isset($category->category->category_name) ? $category->category->category_name : '';
         }
         return $category_name;
    }
    public function getDepartmentNameAttribute()
    {
        //dd($this->department);
        $department_name = [];
         foreach ($this->department as $department){
             $department_name[] = isset($department->department->department_name) ? $department->department->department_name : '';
         }
         return $department_name;
    }

    public function getCategoryIdAttribute()
    {
        $category_id = [];
         foreach ($this->category as $category){
             $category_id[] = $category->category_id;
         }
         return $category_id;
    }
    public function getDepartmentIdAttribute()
    {
        $department_id = [];
        foreach ($this->department as $department){
            $department_id[] = $department->department_id;
        }

        return $department_id;
    }
    public function getBrandIdAttribute()
    {
        $brand_id = [];
        foreach ($this->brand as $brand){
            $brand_id[] = $brand->brand_id;
        }

        return $brand_id;
    }
    public function getBrandNameAttribute()
    {
        //dd($this->department);
        $brand_name = [];
        foreach ($this->brand as $brand){
            $brand_name[] = isset($brand->brand->brand_name) ? $brand->brand->brand_name : '';
        }
        return $brand_name;
    }

}
