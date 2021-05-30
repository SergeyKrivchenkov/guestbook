<div class="wrapper">
    <form action="" class="form" method="POST">
        <p><span class="error">* обязательно для заполнения</span></p>
        <br>
        <label for="">Имя<span class="error">* <?php echo $nameErr; ?></span></label>
        <input type="text" class="input" name="user_name" placeholder="Введите ваше имя">

        <label for="">E-mail<span class="error">* <?php echo $emailErr; ?></span></label>
        <input type="email" class="input" name="email" placeholder="Введите адресс электронной почты" required>

        <label for="">Home page</label>
        <input type="url" class="input" name="user_url" placeholder="Ваша домошняя страница">

        <label for="">Текст сообщения<span class="error">* <?php echo $websiteErr; ?></span></label>
        <textarea type="text" class="input__text" name="text_massage" cols="40" rows="10" placeholder="Введите текст сообщения" required></textarea>

        <!-- <button type="reset" class="form__button" value="reset">Очистить сообщение</button> -->
        <button type="submit" name="send" class="form__button" value="send">Отправить сообщение</button>


    </form>
</div>