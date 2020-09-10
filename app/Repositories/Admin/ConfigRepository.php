<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

class ConfigRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Config';
    }

    /**
     * 获取最新的一条网站配置数据
     */
    public function getConfig()
    {
        return $this->model->orderBy('id','DESC')->first();
    }
}