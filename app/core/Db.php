<?php

namespace app\core;

class Db
{
    protected $db;

    public function __construct()
    {
        $db_name = 'app/config/db_config.php';
        if (file_exists($db_name)) {
            $db_config = require_once $db_name;
        }
        try {
            $this->db = new \PDO("mysql:host={$db_config['host']};dbname={$db_config['db_name']}", $db_config['user'], $db_config['password']);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Db connect error!!!');
        }
    }

    public function queryALL($table_name, $param = null)
    {

        if ($param != null) {
            $keys = array_keys($param);
            $param_name = $keys[0];
            $param_value = $param[$param_name];
            $stmt = $this->db->prepare("SELECT * FROM {$table_name} WHERE {$param_name} = ?");
        } else {
            $stmt = $this->db->prepare("SELECT * FROM {$table_name}");
        }
        $stmt->execute([$param_value]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($table_name, $params)
    {
        $stmt = $this->db->prepare("INSERT INTO {$table_name} SET `user_name` = ?, `e_mail` = ?, `homepage` = ?, `text_masage` = ?,`user_ip` = ?, `user_http` = ?, `time` = ?");
        $res = $stmt->execute([$params['user_name'], $params['user_email'], $params['user_url'], $params['user_text_masage'], $params['user_ip'], $params['user_http'], $params['user_time']]);
        return $res;
    }


    public function queryCountMes($data)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM `comments` WHERE user_ip = ?");
        // debug($stmt);
        $stmt->execute([$data]);
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    public function getLimitMes($table, $from, $count_on_page, $sort_by, $sort_order)
    {
        //debug($time_sort);
        // $keys = array_keys($param);
        // $param_name = $keys[0]; // здесь в $param_name будет записано cat_id
        // $param_value = $param[$param_name];

        $stmt = $this->db->prepare("SELECT * FROM $table ORDER BY {$sort_by} {$sort_order} LIMIT {$from}, {$count_on_page}");
        $stmt->execute(); // здесь в execute() ничего нет так как нет знаков ?
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
