<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
$user = 'u52997';
$pass = '4390881';
$db = new PDO('mysql:host=localhost;dbname=u52997', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$pass_hash=array();
try{
  $get=$db->prepare("select pass from admin where user=?");
  $get->execute(array('admin'));
  $pass_hash=$get->fetchAll()[0][0];
}
catch(PDOException $e){
  print('Error: '.$e->getMessage());
}
if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != 'admin' ||
      md5($_SERVER['PHP_AUTH_PW']) != $pass_hash) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Unauthorized (Требуется авторизация)</h1>');
    exit();
}
if(empty($_GET['edit_id'])){
  header('Location: admin.php');
}
header('Content-Type: text/html; charset=UTF-8');
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
   
    // Выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';

    setcookie('name_value', '', 100000);
    setcookie('email_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('sex_value', '', 100000);
    setcookie('limbs_value', '', 100000);
    setcookie('biography_value', '', 100000);
    setcookie('ab_in_value', '', 100000);
    setcookie('ab_t_value', '', 100000);
    setcookie('ab_l_value', '', 100000);
    setcookie('ab_v_value', '', 100000);
    setcookie('check_value', '', 100000);
  }
  

  // Складываем признак ошибок в массив.
  $errors = array();
  $error=FALSE;
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['abilities'] = !empty($_COOKIE['ability_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['check1'] = !empty($_COOKIE['check_error']);

  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
    $error=TRUE;
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните e-mail.</div>';
    $error=TRUE;
  }
  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Неправильный год.</div>';
    $error=TRUE;
  }
  if ($errors['sex']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('sex_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Неправильный sex.</div>';
    $error=TRUE;
  }
  if ($errors['limbs']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limbs_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Неправильные данные.</div>';
    $error=TRUE;
  }
  if ($errors['abilities']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ability_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите способность.</div>';
    $error=TRUE;
  }
  if ($errors['biography']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biography_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните биографию.</div>';
    $error=TRUE;
  }
  if ($errors['check1']) {
    setcookie('check_error', '', 100000);
    $messages[] = '<div class="error">Вы должны быть согласны дать свои данные.</div>';
    $error=TRUE;
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['ab_in'] = 0;
  $values['ab_t'] = 0;
  $values['ab_l'] = 0;
  $values['ab_v'] = 0;
  
  $user = 'u52997';
  $pass = '4390881';
  $db = new PDO('mysql:host=localhost;dbname=u52997', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

  try {
    $id=$_GET['edit_id'];
    $get=$db->prepare("SELECT * FROM app WHERE id=?");
    $get->bindParam(1, $id);
    $get->execute();
    $info=$get->fetchALL();
    $values['fio']=$inf[0]['fio'];
    $values['email']=$inf[0]['email'];
    $values['year']=$inf[0]['year'];
    $values['sex']=$inf[0]['sex'];
    $values['limbs']=$inf[0]['limbs'];
    $values['biography']=$inf[0]['biography'];

  $get2=$db->prepare("SELECT ability FROM app_abil WHERE application_id=?");
  $get2->bindParam(1, $id);
  $get2->execute();
  $inf2=$get2->fetchALL();
  for($i=0;$i<count($inf2);$i++){
    if($inf2[$i]['ability']=='ab_in'){
      $values['ab_in']=1;
    }
    if($inf2[$i]['ability']=='ab_t'){
      $values['ab_t']=1;
    }
    if($inf2[$i]['ability']=='ab_l'){
      $values['ab_l']=1;
    }
    if($inf2[$i]['ability']=='ab_v'){
      $values['ab_v']=1;
    }
  }
}
catch(PDOException $e){
  print('Error: '.$e->getMessage());
  exit();
}

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  if(!empty($_POST['save'])){
    $id=$_POST['nform'];
    $name = $_POST['fio'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $sex=$_POST['sex'];
    $limbs=$_POST['limbs'];
    $ability=$_POST['abilities'];
    $biography=$_POST['biography'];

  $bioregex = "/^\s*\w+[\w\s\.,-]*$/";
  $nameregex = "/^\w+[\w\s-]*$/";
  $mailregex = "/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";

  $errors = FALSE;
  if (empty($_POST['fio']) || (!preg_match($nameregex,$_POST['fio'])) ) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    setcookie('fio_value', '', 100000);
    $errors = TRUE;
  }
  
  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || !preg_match($mailregex,$_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    setcookie('email_value', '', 100000);
    $errors = TRUE;
  }

  if ($_POST['year']=='Не выбран') {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    setcookie('year_value', '', 100000);
    $errors = TRUE;
  }

  if (!isset($_POST['sex'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    setcookie('sex_value', '', 100000);
    $errors = TRUE;
  }

  if (!isset($_POST['limbs'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
    setcookie('limbs_value', '', 100000);
    $errors = TRUE;
  }

  if (!isset($_POST['abilities'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('ability_error', '1', time() + 24 * 60 * 60);
    
    $errors = TRUE;
  }

  if (empty($_POST['biography']) || !preg_match($bioregex,$_POST['biography'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    setcookie('biography_value', '', 100000);
    $errors = TRUE;
  }

  if ($errors) {
    setcookie('save','',100000);
    header('Location: ind.php?edit_id='.$id);
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('ability_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('check_error', '', 100000);
  }

  $user = 'u52997';
  $pass = '4390881';
  $db = new PDO('mysql:host=localhost;dbname=u52997', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  
  if (!$errors) {
        $upd=$db->prepare("UPDATE app SET name = ?, email = ?, year = ?, sex = ?, limbs = ?, biography = ? WHERE id =:id ");
        $stmt -> execute([$_POST['fio'], $_POST['email'], $_POST['year'], $_POST['sex'],$_POST['limbs'], $_POST['biography']]);

        foreach($cols as $k=>&$v){
          $upd->bindParam($k,$v);
        }
        $upd->bindParam(':id',$id);
        $upd->execute();
        $del=$db->prepare("DELETE FROM app_abil WHERE aplication_id=?");
        $del->execute(array($id));
        $upd1=$db->prepare("INSERT INTO app_abil SET ability=:ability, aplication_id=:id");
        $upd1->bindParam(':id',$id);
        foreach($ability as $abl){
          $upd1->bindParam(':ability',$abl);
          $upd1->execute();
        }
      }
    // TODO: перезаписать данные в БД новыми данными, update()
    // кроме логина и пароля.
    if(!$errors){
      setcookie('save', '1');
    }
    header('Location: ind.php?edit_id='.$id);
  }
  else {
     
        $id=$_POST['nform'];
        $user = 'u52997';
        $pass = '4390881';
        $db = new PDO('mysql:host=localhost;dbname=u52997', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try {
          $del=$db->prepare("DELETE FROM app_abil WHERE aplication_id=?");
          $del->execute(array($id));
          $stmt = $db->prepare("DELETE FROM app WHERE id=?");
          $stmt -> execute(array($id));
        }
       catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
  setcookie('del','1');
  setcookie('del_user',$id);
  // Делаем перенаправление.
  header('Location: admin.php');
  }
}

