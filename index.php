<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

$errorOutput = '';
// Складываем признак ошибок в массив.
$errors = array();
$hasErrors = FALSE;

$defaultValues = [
    'name' => '',
    'email' => '',
    'date' => '',
    'gender' => 'O',
    'limb' => '1',
    'bio' => '',
    'check' => ''
];
// Складываем предыдущие значения полей в массив, если есть.
$values = array();
foreach (['name', 'email', 'date', 'gender', 'limb', 'bio', 'check'] as $key) {
    $values[$key] = !array_key_exists($key . '_value', $_COOKIE) ? $defaultValues[$key] : $_COOKIE[$key . '_value'];
}
foreach (['name', 'email', 'date'] as $key) {
    $errors[$key] = empty($_COOKIE[$key . '_error']) ? '' : $_COOKIE[$key . '_error'];
    if ($errors[$key] != '')
        $hasErrors = TRUE;
}
//массив суперспособностей
$values['superpower'] = array();
$values['superpower']['0'] = empty($_COOKIE['superpower_0_value']) ? '' : $_COOKIE['superpower_0_value'];
$values['superpower']['1'] = empty($_COOKIE['superpower_1_value']) ? '' : $_COOKIE['superpower_1_value'];
$values['superpower']['2'] = empty($_COOKIE['superpower_2_value']) ? '' : $_COOKIE['superpower_2_value'];



// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
      $errorOutput = 'Спасибо, результаты сохранены.<br/>';
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

$trimmedPost = []; // Выгружаем сюда данные с запроса
foreach ($_POST as $key => $value)
    if (is_string($value))
        $trimmedPost[$key] = trim($value);
    else
        $trimmedPost[$key] = $value;

if (empty($trimmedPost['name'])) {
    $errorOutput .= 'Заполните имя.<br/>';
    $errors['name'] = TRUE;
    setcookie('name_error', 'true');
    $hasErrors = TRUE;
} else {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 10000);
    $errors['name'] = '';
}
// Выдаем куку на день с флажком об ошибке в поле.
setcookie('name_value', $trimmedPost['name'], time() + 30 * 24 * 60 * 60);
$values['name'] = $trimmedPost['name'];

if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $trimmedPost['email'])) {
    $errorOutput .= 'Заполните email.<br/>';
    $errors['email'] = TRUE;
    setcookie('email_error', 'true');
    $hasErrors = TRUE;
} else {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 10000);
    $errors['email'] = '';
}
// Выдаем куку на день с флажком об ошибке в поле.
setcookie('email_value', $trimmedPost['email'], time() + 30 * 24 * 60 * 60);
$values['email'] = $trimmedPost['email'];

if (empty($trimmedPost['date'])) {
    $errorOutput .= 'Заполните дату рождения.<br/>';
    $errors['date'] = TRUE;
    setcookie('date_error', 'true');
    $hasErrors = TRUE;
} else {
    setcookie('date_error', '', 10000);
    $errors['date'] = '';
}
setcookie('date_value', $trimmedPost['date'], time() + 30 * 24 * 60 * 60);
$values['date'] = $trimmedPost['date'];

if (empty($trimmedPost['gender'])) {
    $errorOutput .= 'Заполните пол.<br/>';
    $errors['gender'] = TRUE;
    $hasErrors = TRUE;
}
setcookie('gender_value', $trimmedPost['gender'], time() + 30 * 24 * 60 * 60);
$values['gender'] = $trimmedPost['gender'];

if (empty($trimmedPost['limb'])) {
    $errorOutput .= 'Заполните количество конечностей.<br/>';
    $errors['limb'] = TRUE;
    $hasErrors = TRUE;
}
setcookie('limb_value', $trimmedPost['limb'], time() + 30 * 24 * 60 * 60);
$values['limb'] = $trimmedPost['limb'];

foreach (['0', '1', '2'] as $value) {
    setcookie('superpower_' . $value . '_value', '', 10000);
    $values['superpower'][$value] = FALSE;
}
if (array_key_exists('superpower', $trimmedPost)) {
    foreach ($trimmedPost['superpower'] as $value) {
        if (!preg_match('/[0-2]/', $value)) {
            $errorOutput .= 'Неверные суперспособности.<br/>';
            $errors['superpower'] = TRUE;
            $hasErrors = TRUE;
        }
        setcookie('superpower_' . $value . '_value', 'true', time() + 30 * 24 * 60 * 60);
        $values['superpower'][$value] = TRUE;
    }
}
setcookie('bio_value', $trimmedPost['bio'], time() + 30 * 24 * 60 * 60);
$values['bio'] = $trimmedPost['bio'];
if (!isset($trimmedPost['check'])) {
    $errorOutput .= 'Вы не ознакомились с контрактом.<br/>';
    $errors['check'] = TRUE;
    $hasErrors = TRUE;
}
// При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
if ($hasErrors) {

    include('form.php');
    exit();
}

// Проверяем ошибки.
$test = false;
try {

//    $errors = FALSE;
//    if (empty($_POST['name'])) {
//        print('Укажите имя<br/>');
//        $errors = TRUE;
//    }
//
//    $val_em = $_POST['email'];
//    if (empty($_POST['email']) && !(preg_match("/[0-9a-z]+@[a-z]/", $val_em))) {
//        print('Правильно укажите почту<br/>');
//        $errors = TRUE;
//    }
//
//    if (empty($_POST['date'])) {
//        print('Укажите дату<br/>');
//        $errors = TRUE;
//    }
//
//    if (empty($_POST['bio'])) {
//        print('Заполните биографию<br/>');
//        $errors = TRUE;
//    }
//    if (empty($_POST['check'])) {
//        print('Согласитесь с условиями<br/>');
//        $errors = TRUE;
//    }
//
//
//    if ($errors) {
//        // При наличии ошибок завершаем работу скрипта.
//        exit();
//    }

    //    $name = $_POST['name'];
    //    $email = $_POST['email'];
    //    $date = $_POST['date'];
    //    $gender = $_POST['gender'];
    //    $limbs = $_POST['limb'];
    //    $bio = $_POST['bio'];
    //    $check = $_POST['check'];
    //    $sup = implode(",", $_POST['superpower']);

////Представляет собой соединение между PHP и сервером базы данных.
//$conn = new PDO("mysql:host=localhost;dbname=u47498", 'u47498', '7927782', array(PDO::ATTR_PERSISTENT => true));
//
////Подготавливает инструкцию к выполнению и возвращает объект инструкции
//$user = $conn->prepare("INSERT INTO f SET name = ?, email = ?, date = ?, gender = ?, limb = ?, bio = ?, check = ?");
//
////Запускает подготовленный запрос на выполнение
//$user -> execute([$_POST['name'], $_POST['email'], date('Y-m-d', strtotime($_POST['date'])), $_POST['gender'], $_POST['limb'], $_POST['bio'], $_POST['check']]);
//$id_user = $conn->lastInsertId();
//
//$user1 = $conn->prepare("INSERT INTO s SET id = ?, super_name = ?");
//$user1 -> execute([$id_user, $sup]);
//$result = true;
//  user и user1 - это "дескриптор состояния".

// $power1=in_array('1',$_POST['force']) ? '1' : '0';//Проверяет, присутствует ли в массиве значение (что в чем)
// $power2=in_array('2',$_POST['force']) ? '1' : '0';
// $power3=in_array('3',$_POST['force']) ? '1' : '0';


// Сохранение в базу данных.

    $user = 'u47498';
    $pass = '7927782';
    $db = new PDO('mysql:host=localhost;dbname=u47498', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $db->beginTransaction();
    $stmt = $db->prepare("INSERT INTO f SET name = ?, email = ?, date = ?, sex = ?, limbs = ?, bio = ?");
//    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['gender'], $_POST['limb'], $_POST['bio']]);
    $stmt -> execute([$trimmedPost['name'], $trimmedPost['email'], $trimmedPost['date'],
        $trimmedPost['gender'], $trimmedPost['limb'], $trimmedPost['bio']]);
// Подготовленный запрос. Не именованные метки.
// try {
//   $stmt = $db->prepare("INSERT INTO application (name) SET name = ?");
//   $stmt -> execute(array('fio'));
// }
// catch(PDOException $e){
//   print('Error : ' . $e->getMessage());
//   exit();
// }

//  stmt - это "дескриптор состояния".

//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(array('label'=>'perfect', 'color'=>'green'));

//Еще вариант
//$stmt = $db->prepare("INSERT INTO f VALUES (:name, :email, :date, :sex, :limbs, :bio)");
//$stmt->bindParam(':name', $name);
//$stmt->bindParam(':email', $email);
//$stmt->bindParam(':date', $date);
//$stmt->bindParam(':sex', $gender);
//$stmt->bindParam(':limbs', $limbs);
//$stmt->bindParam(':bio', $bio);
//
//$stmt->execute();

    $id_u = $db->lastInsertId();
    $stmts = $db->prepare("INSERT INTO s SET id = ?, sp = ?");
//    $stmts->execute([$id_u, $sup]);
    foreach ($trimmedPost['superpower'] as $s)
        $stmts -> execute([$id_u, $s]);
    $db->commit();
    $test = true;
} catch (PDOException $ex) {
    $db->rollBack();
    print('Error : ' . $ex->getMessage());
    exit();
}

if ($test) {
    echo "Success!";
}
//$stmts = $db->prepare("INSERT INTO s VALUES (:id, :sp)");
//$stmts->bindParam(':id', $id_uu);
//$stmts->bindParam(':sp', $sup);
////Объединяет элементы массива в строку
//$stmts->execute();

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
