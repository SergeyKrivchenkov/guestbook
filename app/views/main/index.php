<div class="wrapper">
    <form action="" class="form" method="POST">
        <p><span class="error">* поле обязательно для заполнения</span></p>
        <br>
        <label for="">Имя<i class="error">*</i></label>
        <input type="text" class="input" name="user_name" placeholder="Введите ваше имя">

        <label for="">E-mail<i class="error">*</i></label>
        <input type="email" class="input" name="email" placeholder="Введите адресс электронной почты">

        <label for="">Home page</label>
        <input type="url" class="input" name="user_url" placeholder="Ваша домошняя страница">

        <label for="">Текст сообщения<i class="error">*</i></label>
        <textarea type="text" class="input__text" name="text_massage" cols="40" rows="10" placeholder="Введите текст сообщения"></textarea>

        <div class="g-recaptcha" data-sitekey="6Ldc6SUUAAAAAJiZ_y4Mdu9MC5gLEtyhscdEx2wr"></div>

        <button type="submit" name="send" class="form__button" value="send">Отправить сообщение</button>


    </form>
</div>

<?php
$validation = $data['validation'];
// debug($validation);
if ($validation['status'] === 'error') { ?>
    <div>Вами не заполнено:</div>
    <ul class="error" style="display: block">
        <?php foreach ($validation['errors'] as $field => $error) { ?>
            <li><?php echo $field . " - " . $error; ?></li>
        <?php } ?>
    </ul>
<?php } else if ($validation['status'] === 'success') { ?> <div class="sendmes">Сообщение отправлено успешно</div> <?php } ?>




<?php //$validation = $data['validation'];
// debug($validation['recaptcha']['success']);if ($validation['recaptcha']['success']) { 
?>
<!-- <div class="sendmes">Сообщение отправлено успешно</div> -->
<?php //} 
?>