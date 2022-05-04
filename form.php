<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задние 4</title>
    <style>
        .error {
            border: 2px solid red;
        }
    </style>
</head>
<body>
    <h1>Задание 4</h1>
    <div class="main">
        <?php
        if ($errorOutput) {
            print('<section id="messages">');
            if ($hasErrors)
                print('<h2>Ошибка</h2>');
            else
                print('<h2>Сообщения</h2>');
            print($errorOutput);
//            print('</section>');
        }
        ?>
        <br />
    <form method="POST" id="form">
        <label>
            Введите Ваше имя:<br />
            <input name="name"
                <?php if (!empty($errors['name'])) {print 'class="error"';} ?>
                   value="<?php print $values['name']; ?>"
            />
        </label><br />
        <label>
            Введите Ваш email:<br />
            <input name="email"
            <?php if (!empty($errors['email'])) {print 'class="error"';} ?>
            value="<?php print $values['email']; ?>"
            type="email"
            />
        </label><br />

        <label>
            Введите Вашу дату рождения:<br />
            <input name="date"
                <?php if (!empty($errors['date'])) {print 'class="error"';} ?>
                   value="<?php print $values['date']; ?>"
                   type="date"
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
            <textarea name="bio"><?php print $values['bio']; ?></textarea>
        </label><br />
        С контрактом ознакомлен(а):<br />
        <label <?php if (array_key_exists('check', $errors)) {print 'class="error"';} ?>>
            <input type="checkbox"
                   name="check"
                <?php if ($values['check']) {print 'checked';} ?>/>
        </label><br />
        <input type="submit" value="Отправить" />
    </form>

    <p>1) Создание таблиц MySQL</p>
    <img src="images/SQL.png" alt="1.0">
    <hr>

</body>
</html>
