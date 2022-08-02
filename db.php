<?php

$dsn = "mysql:host=localhost;port=3306;dbname=test;charset=utf8mb4" ;
$user = "root" ;
$pass = "" ;

try {
  $db = new PDO($dsn, $user, $pass) ;
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
} catch( PDOException $ex) {
  gotoErrorPage() ;
}


function checkUser($id, $pass) {
  global $db ;

  $stmt = $db->prepare("select * from users where id=?") ;
  $stmt->execute([$id]) ;
  
  if ( $stmt->rowCount()) {
      $user = $stmt->fetch(PDO::FETCH_ASSOC) ;
      if($pass == $user["password"]){
        return true;
      }
  }
  return false ;
}

function validSession() {
  return isset($_SESSION["user"]) ;
}

function getUser($id) {
  global $db ;
  try {
     $stmt = $db->prepare("SELECT * FROM users WHERE id = ?") ;
     $stmt->execute([$id]) ;
     return $stmt->fetch(PDO::FETCH_ASSOC) ;
  } catch( PDOException $ex) {
    gotoErrorPage() ;
  }
}

function gotoErrorPage() {
  header("Location: error.php") ;
  exit ;
}
