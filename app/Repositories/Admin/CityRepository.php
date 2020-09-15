<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\City';
    }

    public function updatePath($parent,$id){
        if($parent==0){
            $path=[
                'path' => ',0,'.$id.',',
                'grade' => 1,
            ];
        }else{
            $higher=$this->model->where('id', $parent)->first();
            $path=[
                'path' => $higher['path'].$id.',',
                'grade' => $higher['grade']+1,
            ];
        }
        return $this->model->where('id', $id)->update($path);
    }

    public function get_city_path($area){
        $distinct = $this->model->where('id',$area)->first()->toArray();
        $city = !empty($distinct['parent']) ? $this->model->where('id',$distinct['parent'])->first()->toArray() : '';
        $province = !empty($city['parent']) ? $this->model->where('id',$city['parent'])->first()->toArray() : '';

        $data=['province'=>$province,
            'city'=>$city,
            'distinct'=>$distinct
        ];

        return $data;
    }
    public function getCityList($params){
        return $this->model->where($params)->orderBy('sort','DESC')->orderBy('id','ASC')->get()->toArray();
    }
    public static function getCityName($id){
        return City::where('id',$id)->pluck('title');
    }
}
