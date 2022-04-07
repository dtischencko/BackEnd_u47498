<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задние 3</title>
</head>
<body>
    <h1>Задание 3</h1>

    <form method="POST" id="form">
        <label>
            Введите Ваше имя:<br />
            <input name="name"
                   value="ФИО" />
        </label><br />
        <label>
            Введите Ваш email:<br />
            <input name="email"
                   value="example@example.com"
                   type="email" />
        </label><br />

        <label>
            Введите Вашу дату рождения:<br />
            <input name="date"
                   value="2021-09-12"
                   type="date" />
        </label><br />
        Укажите Ваш пол:<br />
        <label>
            <input type="radio" checked="checked"
                   name="gender" value="Значение1" />
            Муж
        </label>
        <label>
            <input type="radio"
                   name="gender" value="Значение2" />
            Жен
        </label><br />
        <label>
            Укажите Вашу сверх способность из списка:
            <br />
            <select name="superpower[]"
                    multiple="multiple">
                <option value="Значение1">Бессмертие</option>
                <option value="Значение2">Левитация</option>
                <option value="Значение3">Прохождение сквозь стены</option>
            </select>
        </label><br />
        Укажите количество Ваших конечностей:<br />
        <label>
            <input type="radio" checked="checked"
                   name="limb" value="Значение1" />
            1-2
        </label>
        <label>
            <input type="radio"
                   name="limb" value="Значение2" />
            3-4
        </label>
        <label>
            <input type="radio"
                   name="limb" value="Значение3" />
            Более 4
        </label><br />
        <label>
            Напишите Вашу биографию:<br />
            <textarea name="bio">....</textarea>
        </label><br />
        С контрактом ознакомлен(а):<br />
        <label>
            <input type="checkbox"
                   name="check" />
        </label><br />
        <input type="submit" value="Отправить" />
    </form>

    <p>1) Создание таблиц MySQL</p>
    <img src="images/SQL.png" alt="1.0">
    <hr>

</body>
</html>
