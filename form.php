<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задние 5</title>
    <style>
        .error {
            border: 2px solid red;
        }
    </style>
</head>
<body>
    <h1>Задание 5</h1>
    <div class="main">
    <?php
        if (!empty($messages)) {
        print('<div id="messages">');
            // Выводим все сообщения.
            foreach ($messages as $message) {
            print($message);
            }
            print('</div>');
        }
        // Далее выводим форму отмечая элементы с ошибками классом error
        // и задавая начальные значения элементов ранее сохраненными.
        ?>
        <br />

        <div id="user_form">
            <?php
            if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']))
                print('<h3 id="form"> FORM<br/>(режим редактирования) </h3>');
            else
                print('<h3 id="form"> FORM </h3>');
            ?>
        <form method="POST">
        <label>
            Введите Ваше имя:<br />
            <input name="name"
                <?php if (!empty($errors['name'])) {print 'class="error"';} ?>
                   value="<?php print $values['name']; ?>"
                   required
            />
        </label><br />
        <label>
            Введите Ваш email:<br />
            <input name="email"
            <?php if (!empty($errors['email'])) {print 'class="error"';} ?>
            value="<?php print $values['email']; ?>"
            type="email"
                   required
            />
        </label><br />

        <label>
            Введите Вашу дату рождения:<br />
            <input name="date"
                <?php if (!empty($errors['date'])) {print 'class="error"';} ?>
                   value="<?php print $values['date']; ?>"
                   type="date"
                   required
            />
        </label><br />
        Укажите Ваш пол:<br />
        <label>
            <input type="radio"
                   name="gender"
                   value="M" <?php if ($values['gender'] == 'M') {print 'checked';} ?>
                   checked
            />
            Муж
        </label>
        <label>
            <input type="radio"
                   name="gender"
                   value="F" <?php if ($values['gender'] == 'F') {print 'checked';} ?>
            />
            Жен
        </label><br />
        <label>
            Укажите Вашу сверх способность из списка:
            <br />
            <select name="superpower[]"
                    multiple="multiple">
                <option value="0" <?php if ($values['superpower']['0']) {print 'selected';} ?>>Бессмертие</option>
                <option value="1" <?php if ($values['superpower']['1']) {print 'selected';} ?>>Левитация</option>
                <option value="2" <?php if ($values['superpower']['2']) {print 'selected';} ?>>Прохождение сквозь стены</option>
            </select>
        </label><br />
        Укажите количество Ваших конечностей:<br />
        <label>
            <input type="radio"
                   name="limb"
                <?php if ($values['limb'] == '12') {print 'checked';} ?>
                   checked
            />
            1-2
        </label>
        <label>
            <input type="radio"
                   name="limb"
                <?php if ($values['limb'] == '34') {print 'checked';} ?>
            />
            3-4
        </label>
        <label>
            <input type="radio"
                   name="limb"
                <?php if ($values['limb'] == '4') {print 'checked';} ?>
            />
            Более 4
        </label><br />
        <label>
            Напишите Вашу биографию:<br />
            <textarea name="bio">.....</textarea>
        </label><br />
        С контрактом ознакомлен(а):<br />
        <label <?php if (array_key_exists('check', $errors)) {print 'class="error"';} ?>>
            <input type="checkbox"
                   name="check"
                <?php if ($values['check']) {print 'checked';} ?>/>
        </label><br />
        <input type="submit" value="Отправить" />
    </form>
        </div>
        <nav id="navi">
            <ul>
                <li>
                    <?php
                    if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']))
                        print('<a href="./?quit=1" title = "Log out">Выйти</a>');
                    else
                        print('<a href="login.php" title = "Log in">Войти</a>');
                    ?>
                </li>
            </ul>
        </nav>

</body>
</html>
