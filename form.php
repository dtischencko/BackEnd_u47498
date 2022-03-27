<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задние 2</title>
</head>
<body>
    <h1>Задание 2</h1>

    <form action="/" method="post">
        <label>
            Введите Ваше имя:<br />
            <input name="field-name-1"
                   value="ФИО" />
        </label><br />
        <label>
            Введите Ваш email:<br />
            <input name="field-email"
                   value="example@example.com"
                   type="email" />
        </label><br />

        <label>
            Введите Вашу дату рождения:<br />
            <input name="field-date"
                   value="2021-09-12"
                   type="date" />
        </label><br />
        Укажите Ваш пол:<br />
        <label>
            <input type="radio" checked="checked"
                   name="radio-group-1" value="Значение1" />
            Муж
        </label>
        <label>
            <input type="radio"
                   name="radio-group-1" value="Значение2" />
            Жен
        </label><br />
        <label>
            Укажите Вашу сверх способность из списка:
            <br />
            <select name="field-name-4[]"
                    multiple="multiple">
                <option value="Значение1">Бессмертие</option>
                <option value="Значение2">Левитация</option>
                <option value="Значение3">Прохождение сквозь стены</option>
            </select>
        </label><br />
        Укажите количество Ваших конечностей:<br />
        <label>
            <input type="radio" checked="checked"
                   name="radio-group-2" value="Значение1" />
            1-2
        </label>
        <label>
            <input type="radio"
                   name="radio-group-2" value="Значение2" />
            3-4
        </label>
        <label>
            <input type="radio"
                   name="radio-group-2" value="Значение3" />
            Более 4
        </label><br />
        <label>
            Напишите Вашу биографию:<br />
            <textarea name="field-name-2">....</textarea>
        </label><br />
        С контрактом ознакомлен(а):<br />
        <label>
            <input type="checkbox"
                   name="check-1" />
        </label><br />
        <input type="submit" value="Отправить" />
    </form>

    <p>1) Отправляем запрос 1.0</p>
    <img src="images/http1_0.png" alt="1.0">
    <hr>
    <p>2) Отправляем запрос 1.1</p>
    <img src="images/http1_1.png" alt="1.1">
    <hr>
    <p>3) Определить размер файла file.tar.gz, не скачивая его</p>
    <img src="images/httpHEAD.png" alt="head">
    <hr>
    <p>4) Определить медиатип ресурса /image.png</p>
    <img src="images/httpMedia.png" alt="media">
    <p>5) Отправить комментарий на сервер по адресу /index.php</p>
    <img src="images/httpPHP.png" alt="php">
    <hr>
    <p>6) Получить первые 100 байт файла /file.tar.gz</p>
    <img src="images/httpRange.png" alt="range">
    <hr>
    <p>7) Определить кодировку ресурса /index.php</p>
    <img src="images/httpCoding.png" alt="coding">
    <hr>
</body>
</html>
