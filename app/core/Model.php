<?php

namespace app\core;

abstract class Model
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db();
        return $this->db->queryALL('comments');
        // debug($data);
    }
}
