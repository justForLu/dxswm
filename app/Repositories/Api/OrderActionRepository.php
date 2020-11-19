<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class OrderActionRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\OrderAction';
    }

    /**
     * 创建订单动态
     * @param array $params
     * @return mixed
     */
    public function createAction($params = [])
    {
        $data = [
            'order_id' => $params['order_id'] ?? 0,
            'user_id' => $params['user_id'] ?? 0,
            'order_status' => $params['order_status'] ?? 0,
            'action_place' => $params['action_place'] ?? 0,
            'action_type' => $params['action_type'] ?? 0,
            'action_note' => $params['action_note'] ?? '',
            'create_time' => time()
        ];

        $result = $this->model->insert($data);

        return $result;
    }
}
