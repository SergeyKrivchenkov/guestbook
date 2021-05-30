<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $datames = $this->getMes();
        // if (isset($_POST['send']) && ($_POST['send'] == 'send') && $this->checkValidation()){
        //     // 
        // }
        $this->checkValidation();
        if (isset($_POST['send']) && ($_POST['send'] == 'send')) {
            $params = [
                'user_name' => strip_tags($_POST['user_name']),
                'user_email' => strip_tags($_POST['email']),
                'user_url' => strip_tags($_POST['user_url']),
                'user_text_masage' => strip_tags($_POST['text_massage']),
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'user_http' => $_SERVER['HTTP_USER_AGENT'],
                'user_time' => date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']),
            ];
            $this->model->addComment($params);
            header('location: ' . $_SERVER['REQUEST_URI']);
        }


        $this->view->render(
            // 'index'
            $datames
        );
    }

    public function checkValidation()
    {
        $nameErr = $emailErr = $websiteErr = "";
        $name = $email = $comment = $website = "";

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["user_name"])) {
                $nameErr = "Введите имя";
            } else {
                $name = test_input($_POST["user_name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
                    $nameErr = "Используйте только цифры, пробелы и буквы латинского алфавита.";
                }
            }

            if (empty($_POST["email"])) {
                $emailErr = "Введите почту";
            } else {
                $email = test_input($_POST["email"]);
                // проверка формата почты
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Не верный формат email.";
                }
            }

            if (empty($_POST["user_url"])) {
                $website = "";
            } else {
                $website = test_input($_POST["user_url"]);
                // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
                    $websiteErr = "Не верный URL.";
                }
            }

            if (empty($_POST["comment"])) {
                $commentErr = "Введите сообщение.";
                $comment = "";
            } else {
                $comment = test_input($_POST["comment"]);
            }

            if (empty($_POST["user_name"]) || empty($_POST["email"]) || empty($_POST["user_url"]) || empty($_POST["comment"])) {
            }
        }
        return true;
    }

    public function addCommentAction()
    {
        // echo 43434343;
        $this->view->render('index', [
            'data' => []
        ]);
    }



    public function getMes()
    {
        if (isset($_GET['page'])) {
            $cur_page = $_GET['page'];
        } else {
            $cur_page = 1;
        }
        // $param_value = $_SESSION['user_ip'];
        // $param_name = 'user_ip';

        if (isset($_POST['sort_by'])) {
            $sort_by = $_POST['sort_by'];
        } else {
            $sort_by = 'time';
        }

        if (isset($_POST['sort_order'])) {
            $sort_order = $_POST['sort_order'];
        } else {
            $sort_order = 'DESC';
        }

        $count_on_page = 5;
        // $datas = $this->model->getRecords();

        $comments = $this->model->getLimit($cur_page, $count_on_page, $sort_by, $sort_order);
        $arr['comments'] = $comments;
        $arr['cur_page'] = $cur_page;
        $arr['count_on_page'] = $count_on_page;
        $arr['sort_by'] = $sort_by;
        $arr['sort_order'] = $sort_order;
        return $arr;
    }
}
