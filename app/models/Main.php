<?php

namespace app\models;

use app\core\Model;

class Main extends Model
{
    public function getCountMes($messages)
    {
        foreach ($messages as $key => $value) {
            $count = $this->db->queryCountMes($value['user_ip']);
            $messages[$key]['count'] = $count;
        }
        return  $messages;
    }

    public function addComment($data)
    {
        return $this->db->insert('comments', $data);
    }

    public function getLimit($cur_page, $count_on_page = 25, $sort_by, $sort_order)
    {
        $from = ($cur_page - 1) * $count_on_page;
        $messages = $this->db->getLimitMes('comments', $from, $count_on_page, $sort_by, $sort_order);
        $count = $this->getCountMes($messages);
        return $count;
    }
}
