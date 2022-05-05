<!DOCTYPE html>
<html lang="ru">


<head>
    <meta charset="utf-8"/>
    <title>Задание 5</title>
</head>
<body>
    <h2>Авторизация</h2>
            <?php

            /**
             * Файл login.php для не авторизованного пользователя выводит форму логина.
             * При отправке формы проверяет логин/пароль и создает сессию,
             * записывает в нее логин и id пользователя.
             * После авторизации пользователь перенаправляется на главную страницу
             * для изменения ранее введенных данных.
             **/

            // Отправляем браузеру правильную кодировку,
            // файл login.php должен быть в кодировке UTF-8 без BOM.
            header('Content-Type: text/html; charset=UTF-8');

            // Начинаем сессию.
            session_start();

            // В суперглобальном массиве $_SESSION хранятся переменные сессии.
            // Будем сохранять туда логин после успешной авторизации.
            if (!empty($_SESSION['login'])) {
                // Если есть логин в сессии, то пользователь уже авторизован.
                session_destroy();
                // Делаем перенаправление на форму.
                header('Location: ./');
            }

            // В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
            // и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                if (!empty($_GET['nologin']))
                    print("<div>Пользователя с таким логином не существует</div>");
                if (!empty($_GET['wrongpass']))
                    print("<div>Неверный пароль!</div>");

                ?>

                <div class="login-page">
                    <div class="form">
                        <form class="login-form" action="" method="post">
                            <label>
                                <input class="input-field" name="login"  placeholder="логин"/>
                            </label>
                            <label>
                                <input class="input-field" name="pass" placeholder="пароль"/>
                            </label>
                            <input class="gradient-button" type="submit" value="войти">
                        </form>
                    </div>
                </div>


                <?php
            }
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
            else {
                try {

                    $user = 'u47498';
                    $pass = '7927782';
                    $db = new PDO('mysql:host=localhost; dbname=u47498', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

                    $stmt1 = $db->prepare('SELECT id, hash_pass FROM f WHERE login = ?');
                    $stmt1->execute([$_POST['login']]);

                    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
                    if (!$row) {
                        header('Location: ?nologin=1');
                        exit();
                    }
                } catch (PDOException $exception) {
                    print('Error : ' . $exception->getMessage());
                }

                $pass_hash = substr(hash("sha256", $_POST['pass']), 0, 20);
                if ($row['hash_pass'] != $pass_hash) {
                    header('Location: ?wrongpass=1');
                    exit();
                }
                // Если все ок, то авторизуем пользователя.
                $_SESSION['login'] = $_POST['login'];
                // Записываем ID пользователя.
                $_SESSION['uid'] = $row['id'];

                // Делаем перенаправление.
                header('Location: ./');
            }
            ?>
</body>
</html>