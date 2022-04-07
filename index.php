<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$test = false;
try {

    $errors = FALSE;
    if (empty($_POST['name'])) {
        print('Укажите имя<br/>');
        $errors = TRUE;
    }

    $val_em = $_POST['email'];
    if (empty($_POST['email']) && !(preg_match("/[0-9a-z]+@[a-z]/", $val_em))) {
        print('Правильно укажите почту<br/>');
        $errors = TRUE;
    }

    if (empty($_POST['date'])) {
        print('Укажите дату<br/>');
        $errors = TRUE;
    }

    if (empty($_POST['bio'])) {
        print('Заполните биографию<br/>');
        $errors = TRUE;
    }
    if (empty($_POST['check'])) {
        print('Согласитесь с условиями<br/>');
        $errors = TRUE;
    }


    if ($errors) {
        // При наличии ошибок завершаем работу скрипта.
        exit();
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $gender = $_POST['gender'];
    $limbs = $_POST['limb'];
    $bio = $_POST['bio'];
    $check = $_POST['check'];
    $sup = implode(",", $_POST['superpower']);

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
    $stmt = $db->prepare("INSERT INTO f SET name = ?, email = ?, date = ?, sex = ?, limbs = ?, bio = ?");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['gender'], $_POST['limb'], $_POST['bio']]);
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
    $stmts->execute([$id_u, $sup]);
    $test = true;
} catch (PDOException $ex) {
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
