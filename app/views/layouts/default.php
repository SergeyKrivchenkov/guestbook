<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <title>GuestBook</title>
</head>

<body>

    <?php
    // debug($data);
    ?>

    <div class="wrapper__content">
        <div class="wrapper__maincontent">
            <div class="wrapper__table">
                <h1>Отзывы наших пользователей</h1>
                <table class="table__masage">
                    <tr>
                        <th>User Name</th>
                        <th>e-mail</th>
                        <th>сообщение</th>
                    </tr>
                    <?php foreach ($data['comments'] as $item) : ?>
                        <tr>
                            <td><?= $item['time'] ?></td>
                            <td><?= $item['user_name'] ?></td>
                            <td><?= $item['e_mail'] ?></td>
                            <td><i>&#10077;</i><?= $item['text_masage'] ?><i>&#10078;</i></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="wrapper__sendform">
            <main>
                <?php
                echo $content;
                ?>
            </main>


            <!------------ pagination П А Г И Н А Т О Р----------->

            <?php

            // $products = $data['products']; // как бы распарсили массив
            $count_products = $data['comments'][0]['count']; // сюда запишется кол-во сообщений в БД
            // echo $count_products;

            $count_on_page = $data['count_on_page'];
            $cour_page = $data['cur_page'];

            $count_pages = ceil($count_products / $count_on_page); // узнаем кол-во товаров т.е. кол-во товаров делим на кол-во товара на стр.

            ?>

            <ul class="pagination ">
                <li class="disabled "><a href="#!">&#9668;</a></li>

                <?php for ($i = 1; $i <= $count_pages; $i++) : // здесь не забываем о знаке : после оператора вместо скобки
                ?>
                    <?php $class = ($cour_page == $i) ? ' active' : ''; // здесь если $cur_page (т.е. текущая стр.) совпала с $i (счетчиком) это означаем что данной li которая совподаем с тек стр. добовляем класс active с пробелом, а иначе в переменную класс запишется ничего т.е ''. Пишем это в теле оператора для того чтобы автоматизировать присвоение класса active в имеющееся li
                    ?>
                    <!-- здесь вставляем $i из оператора for для автоматизации нумерации пагинатора-->
                    <li class="waves-effect <?= $class ?>"><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>
                <li class="waves-effect"><a href="#!">&#9658;</a></li>
            </ul>

            <div class="select">
                <form class="form__select_" action="" method="POST">

                    <h2>Сортирвать по:</h2>
                    <select name="sort_by" id="sort_by" size="">
                        <!-- <option disabled>сортировать по:</option> -->
                        <option value="user_name" <?php echo $_POST['sort_by'] === 'user_name' ? "selected" : "" ?>> Имени пользователя </option>
                        <option value="e_mail" <?php echo $_POST['sort_by'] === 'e_mail' ? "selected" : "" ?>> Е-мейл </option>
                        <option value="time" <?php echo $_POST['sort_by'] === 'time' ? "selected" : "" ?>> Дате </option>
                    </select>

                    <h2>Порядок сортировки:</h2>
                    <select name="sort_order" id="sort_order" size="">
                        <!-- <option disabled>сортировать по:</option> -->
                        <option value="asc" <?php echo $_POST['sort_order'] === 'asc' ? "selected" : "" ?>> По возрастанию </option>
                        <option value="desc" <?php echo $_POST['sort_order'] === 'desc' ? "selected" : "" ?>> По убыванию </option>
                    </select>

                    <!-- <br>
                    <h2>Сортирвать по имени пользователя</h2>
                    <select name="nameadd" id="username" size="">
                        <option value="adc_a-z"> adc a-z </option>
                        <option value="adc_z-a"> adc z-a </option>
                    </select>

                    <br>
                    <h2>Сортирвать по E-mail</h2>

                    <select name="emailadd" id="emailadd" size="">
                        <option value="gmail">Gmail</option>
                        <option value="outlook">Outlook</option>
                        <option value="mail">Mail</option>
                    </select>
                    <br>

                    <h2>Сортирвать по дате добовления</h2>

                    <select name="timeadd" id="timeadd" size="">
                        <option value="new" <?php //echo $_POST['timeadd'] === 'new' ? "selected" : "" 
                                            ?>>новые</option>
                        <option value="old" <?php //echo $_POST['timeadd'] === 'old' ? "selected" : "" 
                                            ?>>старые</option>
                    </select>

                    <br>
                    <h2>Количество сообщений на странице</h2>
                    <select name="msgcount" id="msgcount" size="">
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> -->

                    <button type="submit" name="sort" class="form__button" value="sort">Сортировать</button>
                </form>
            </div>

        </div>
        <!-- ------------------------------------------------- -->
    </div>

</body>

</html>