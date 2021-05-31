<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $datames = $this->getMes();
        if (isset($_POST['send']) && ($_POST['send'] == 'send')) {

            $validation = $this->checkValidation();
            $datames['validation'] = $validation;

            if ($validation['status'] === 'success') {
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
            }
        }

        $this->view->render(
            $datames
        );
    }

    public function checkValidation()
    {
        $name = $email = $text_massage = $website = "";

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $errors = [];

            if (empty($_POST["user_name"])) {
                $errors['Имя:'] = "Введите имя";
            } else {
                $name = test_input($_POST["user_name"]);
                if (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
                    $errors['Имя:'] = "Используйте только цифры, пробелы и буквы латинского алфавита.";
                }
            }

            if (empty($_POST["email"])) {
                $errors['E-Mail:'] = "Введите почту";
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['E-Mail:'] = "Не верный формат email.";
                }
            }

            if (empty($_POST["user_url"])) {
                $website = "";
            } else {
                $website = test_input($_POST["user_url"]);
                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
                    $errors['Веб-Сайт:'] = "Не верный URL.";
                }
            }

            if (empty($_POST["text_massage"])) {
                $errors['Сообщение:'] = "Введите сообщение.";
            }

            if (empty($_POST["g-recaptcha-response"])) {
                $errors['reCaptcha:'] = "Captcha не заполнена.";
            } else {
                $reCaptcha = $_POST["g-recaptcha-response"];

                $url = "https://www.google.com/recaptcha/api/siteverify";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, [
                    'secret' => '6Ldc6SUUAAAAAAm7pBO16ciZs4OQYIVzvfk5QAPZ',
                    'response' => $reCaptcha
                ]);

                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response);

                if (!$data->success) {
                    $errors['reCaptcha:'] = "Неверный ответ.";
                }
            }

            if ($errors) {
                return [
                    'status' => 'error',
                    'errors' => $errors,
                ];
            }
        }
        return [
            'status' => 'success',
        ];
    }

    public function getMes()
    {
        if (isset($_GET['page'])) {
            $cur_page = $_GET['page'];
        } else {
            $cur_page = 1;
        }

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

        $count_on_page = 25;

        $comments = $this->model->getLimit($cur_page, $count_on_page, $sort_by, $sort_order);
        $arr['comments'] = $comments;
        $arr['cur_page'] = $cur_page;
        $arr['count_on_page'] = $count_on_page;
        $arr['sort_by'] = $sort_by;
        $arr['sort_order'] = $sort_order;
        return $arr;
    }
}
