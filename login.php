<?php

if($_SERVER['REQUEST_METHOD']=='GET'){
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
  //аутентификация
  if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != 'admin' ||
      md5($_SERVER['PHP_AUTH_PW']) != $pass_hash) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  if(!empty($_COOKIE['del'])){
    echo 'Пользователь '.$_COOKIE['del_user'].' был удалён <br>';
    setcookie('del','');
    setcookie('del_user','');
  }
  print('Вы успешно авторизовались и видите защищенные паролем данные');
  $users=array();
  $abil=array();
  $abl_def=array('ab_in','ab_t','ab_l','ab_v');
  $abil_count=array();
  try{
    $get=$db->prepare("select * from app");
    $get->execute();
    $inf=$get->fetchALL();
    $get2=$db->prepare("select aplication_id, ability from app_abil");
    $get2->execute();
    $inf2=$get2->fetchALL();
    $count=$db->prepare("select count(*) from app_abil where ability=?");
    foreach($abl_def as $abl){
      $i=0;
      $count->execute(array($abl));
      $abil_count[]=$count->fetchAll()[$i][0];
      $i++;
    }
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
    exit();
  }
  $users=$inf;
  $abil=$inf2;
  include('table.php');
}
