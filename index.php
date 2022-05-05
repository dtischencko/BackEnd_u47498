<?php
// Сессии являются простым способом хранения информации для отдельных пользователей с уникальным идентификатором сессии.
// Это может использоваться для сохранения состояния между запросами страниц.
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Массив для временного хранения сообщений пользователю.
$messages = [];
//Массив для ошибок
$errors = [];
$trimed = [];

$user = 'u47498';
$pass_db = '7927782';
$db = new PDO('mysql:host=localhost; dbname=u47498', $user, $pass_db, array(PDO::ATTR_PERSISTENT => true));
//$db->beginTransaction();
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
        // Выдаем сообщение об успешном сохранении.
        if (!empty($_COOKIE['save'])) {
            // Удаляем куки, указывая время устаревания в прошлом.
            setcookie('save', '', 100000);
            setcookie('login', '', 100000);
            setcookie('pass', '', 100000);
            // Выводим сообщение пользователю.
            $messages[] = 'Спасибо, результаты сохранены. ';
            // Если в куках есть пароль, то выводим сообщение.
            if (!empty($_COOKIE['pass'])) {
                $messages[] = sprintf(
                    'Зайдите <a href="login.php">сюда</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
                    strip_tags($_COOKIE['login']),
                    strip_tags($_COOKIE['pass'])
                );
            }
        }
        //Проверяем на не пустоту
        $errors['name'] = !empty($_COOKIE['error_name']);
        $errors['email'] = !empty($_COOKIE['error_email']);
        $errors['date'] = !empty($_COOKIE['error_date']);
        $errors['gender'] = !empty($_COOKIE['error_gender']);
        $errors['limb'] = !empty($_COOKIE['error_limb']);
        $errors['check'] = !empty($_COOKIE['error_check']);


        //Удаление cookies(через установление даты устаревания в прошедшем времени) и вывод сообщений об ошибках заполнения полей
        if ($errors['name']) {
            // Удаляем куку, указывая время устаревания в прошлом.
            setcookie('error_name', '', 100000);
            // Выводим сообщение.
            $messages[] = '<div>Заполните имя.</div>';
        }
        if ($errors['email']) {
            setcookie('error_email', '', 100000);
            $messages[] = '<div >Заполните почту.</div>';
        }
        if ($errors['date']) {
            setcookie('error_date', '', 100000);
            $messages[] = '<div >Заполните др.</div>';
        }
        if ($errors['gender']) {
            setcookie('error_gender', '', 100000);
            $messages[] = '<div >Заполните пол.</div>';
        }
        if ($errors['limb']) {
            setcookie('error_limb', '', 100000);
            $messages[] = '<div >Заполните конечности.</div>';
        }
        if ($errors['check']) {
            setcookie('error_check', '', 100000);
            $messages[] = '<div >Заполните контракт.</div>';
        }

        // Складываем предыдущие значения полей в массив, если есть.
        // При этом санитизуем все данные для безопасного отображения в браузере.
        $values = array();
        $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
        $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
        $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_COOKIE['date_value']);
        $values['gender'] = empty($_COOKIE['gender_value']) ? '' : strip_tags($_COOKIE['gender_value']);
        $values['limb'] = empty($_COOKIE['limb_value']) ? '' : strip_tags($_COOKIE['limb_value']);
        $values['check'] = empty($_COOKIE['check_value']) ? '' : strip_tags($_COOKIE['check_value']);

        $values['superpower'] = array();
        $values['superpower'][0] = empty($_COOKIE['superpower_value_0']) ? '' : $_COOKIE['superpower_value_0'];
        $values['superpower'][1] = empty($_COOKIE['superpower_value_1']) ? '' : $_COOKIE['superpower_value_1'];
        $values['superpower'][2] = empty($_COOKIE['superpower_value_2']) ? '' : $_COOKIE['superpower_value_2'];

        // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
        // ранее в сессию записан факт успешного логина.
        session_start();
        if (empty($errors) && !empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
            // загружаем данные пользователя из БД
            // и заполнить переменную $values,
            // предварительно санитизовав.
            try {

                $stmt1 = $db->prepare('SELECT name, email, date, sex, limbs, bio FROM f WHERE id = ?');
                $stmt1->execute([$_SESSION['uid']]);
                $row = $stmt1->fetch(PDO::FETCH_ASSOC);

                echo $row;

                $values['name'] = strip_tags($row['name']);
                $values['email'] = strip_tags($row['email']);
                $values['date'] = strip_tags($row['date']);
                $values['gender'] = strip_tags($row['sex']);
                $values['limb'] = strip_tags($row['limbs']);
                $values['bio'] = strip_tags($row['bio']);

                $stmt2 = $db->prepare('SELECT id FROM s WHERE id = ?');
                $stmt2->execute([$_SESSION['uid']]);
                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $values['superpower'][$row['id']] = TRUE;
                }

                printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
            } catch (PDOException $exception) {
                print('Error : ' . $exception->getMessage());
            }
        }

        // Включаем содержимое файла form.php.
        // В нем будут доступны переменные $messages, $errors и $values для вывода
        // сообщений, полей с ранее заполненными данными и признаками ошибок.

        include('form.php');
    } // Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
    else {
        // Проверяем ошибки.
        $errors = FALSE;

        //проверка корректности заполненных полей
        if ((empty($_POST['name']))) {
            setcookie('error_name', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            // Сохраняем ранее введенное в форму значение на месяц.
            setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
        }


        if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $_POST['email'])) {
            setcookie('error_email', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
        }


        if (empty($_POST['date'])) {
            setcookie('error_date', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
        }


        if (empty($_POST['gender'])) {
            setcookie('error_gender', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
        }


        if (empty($_POST['limb'])) {
            setcookie('error_limb', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            setcookie('limb_value', $_POST['limb'], time() + 30 * 24 * 60 * 60);
        }


        if (!isset($_POST['check'])) {
            setcookie('error_check', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            setcookie('check_value', $_POST['check'], time() + 30 * 24 * 60 * 60);
        }


        foreach ($_POST['superpower'] as $super) {
            setcookie('superpower_value_' . $super, 'true', time() + 30 * 24 * 60 * 60);
        }

        if ($errors) {
            // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
            header('Location: index.php');
            exit();
        } else {
            // Удаляем Cookies с признаками ошибок.
            setcookie('error_name', '', 100000);
            setcookie('error_email', '', 100000);
            setcookie('error_gender', '', 100000);
            setcookie('error_limb', '', 100000);
            setcookie('error_date', '', 100000);
            setcookie('error_check', '', 100000);
        }

        // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
        if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
            // Перезаписываю данные в БД новыми данными,
            // кроме логина и пароля.
            try {

                $stmt1 = $db->prepare("UPDATE f SET name = ?, email = ?, date = ?, sex = ?, limbs = ?, bio = ? WHERE id = ?");
                $stmt1->execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['gender'], $_POST['limb'], $_POST['bio'], $_SESSION['uid']]);

                $stmt2 = $db->prepare('DELETE FROM s WHERE id = ?');
                $stmt2->execute([$_SESSION['uid']]);

                $lastId = $_SESSION['uid'];
                $stmt3 = $db->prepare("INSERT INTO s SET id = ?, sp = ?");
                foreach ($_POST['superpower'] as $super) $stmt3->execute([$lastId, $super]);
            } catch (PDOException $exception) {
                print('Error : ' . $exception->getMessage());
            }
        } else {
            // Генерируем уникальный логин и пароль.
            //  сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
            //Сделал через uniqid()
            $id = uniqid();
            $hash = md5($id);
            $login = substr($hash, 0, 10);
            $pass = substr($hash, 10, 15);
            /*SHA-2 (Secure Hash Algorithm Version 2 — безопасный алгоритм хеширования, версия 2) —
              это название однонаправленных хеш-функций SHA-224, SHA-256, SHA-384 и SHA-512.
              Хеш-функции предназначены для создания «отпечатков» или «дайджестов» сообщений произвольной битовой длины.
              Применяются в различных приложениях или компонентах, связанных с защитой информации.*/
            $hash_pass = substr(hash("sha256", $pass), 0, 20);
            // Сохраняем в Cookies.
            setcookie('login', $login);
            setcookie('pass', $pass);

            try {

                $stmt1 = $db->prepare("INSERT INTO f SET name = ?, email = ?, date = ?, sex = ?, limbs = ?, bio = ?, login = ?, hash_pass = ?"); //
                $stmt1->execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['gender'], $_POST['limb'], $_POST['bio'], $login, $hash_pass]);
                //$db->beginTransaction();
                $stmt = $db->prepare("INSERT INTO f SET name = ?, email = ?, date = ?, sex = ?, limbs = ?, bio = ?");
                //$stmt->execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['gender'], $_POST['limb'], $_POST['bio']]);
//                $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['date'],
//                    $_POST['gender'], $_POST['limb'], $_POST['bio']]);
                echo "<script>console.log('Debug Objects: " . $_POST['name'] . $_POST['email'] . $_POST['date'] . $_POST['gender'] . $_POST['limb'] . $_POST['bio'] . $login . $hash_pass . "');</script>";

                $stmt2 = $db->prepare("INSERT INTO s SET id = ?, sp = ?");
                $id = $db->lastInsertId();
                foreach ($_POST['superpower'] as $super) $stmt2->execute([$id, $super]);
            } catch (PDOException $exception) {
                print('Error : ' . $exception->getMessage());
            }
        }
        // Сохраняем куку с признаком успешного сохранения.
        setcookie('save', '1');
        // Делаем перенаправление.
        header('Location: ./');
    }////////////////////////////////////////////////////////////////////////////////////////////