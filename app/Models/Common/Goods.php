<?php

namespace App\Models\Common;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Base
{

    use SoftDeletes;

    // 商品
    protected $table = 'goods';

    protected $fillable = ['id','business_id','name','category_id','image','old_price','price','describe','number','score','sort','status'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

}
