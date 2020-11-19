<?php

namespace App\Models\Common;

use App\Models\Admin\Menu;
use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Base
{

    use SoftDeletes;

    // 商家
    protected $table = 'business';

    protected $fillable = ['id','admin_id','name','mobile','image','province','city','area','school','address','time_limit','status',
        'notice','number','score','salesman_id'];


    public function salesman(){
        return $this->belongsTo(Salesman::class, 'salesman_id');
    }
}
