<?php
   // No Validation in this example.

   // CONNECT to mysql server
   session_start() ;
   require "db.php" ;

   // check if the user authenticated before
   if( !validSession()) {
       header("Location: loginPage.php") ;
       exit ; 
   }

   // DELETE a Game
   if ( isset($_GET["delete"])) {
       $id = $_GET["delete"] ;
       $user = getUser($id) ;
       try {
          $stmt = $db->prepare("DELETE FROM users where id = ?") ;
          $stmt->execute([$id]) ;
          $msg = "{$user["nameSurname"]} Silindi" ;
          header("Location: index.php") ;
       } catch(PDOException $ex) {
            gotoErrorPage();
       } 
   }

   // INSERT a user
   if ( !empty($_POST)) {
       extract($_POST) ;
       try {
        $userType = "normal" ;
        $randomNum = rand(10000000,99999999);
        $stmt = $db->prepare("INSERT INTO users (id,userType,nameSurname,petName, password) VALUES (?,?,?,?,?)" ) ;
        $stmt->execute([$id,$userType, $nameSurname,$petName,$randomNum]) ;
        $msg = "$nameSurname (" . $db->lastInsertId() . ") Eklendi" ; 
       } catch(PDOException $ex) {
         gotoErrorPage();
       
        } 
    
        
   }
  


   // READ all Users
   try {
       $rs = $db->query("select * from users") ;
       $users = $rs->fetchAll(PDO::FETCH_ASSOC) ;
   } catch( PDOException $ex) {
        gotoErrorPage();
   }
   // Read all analyzes
   try{
    $rs = $db->query("select * from analyzes") ;
    $analyzes = $rs->fetchAll(PDO::FETCH_ASSOC) ;
   } catch( PDOException $ex) {
        gotoErrorPage();
   }

   // Edit Message
   if ( isset($_GET["edit"])) {
       $user = getUser($_GET["edit"]) ;
       $msg = "{$user["nameSurname"]} Güncellendi." ;
   }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kan Tahlilleri</title>
    <link rel="stylesheet" href="./styles/app.css">
    
</head>
<body>

<h1>Kan Tahlilleri</h1>
    <form action="?" method="post">
 
    <table>
          
            <tr>
                <th>Kullanıcı ID</th>
                <th>Kullanıcı Adı Soyadı</th>
                <th>Hayvan Ad</th>
            </tr>
            <?php foreach( $users as $user) : ?>
            <tr>
                <td><?= $user["id"] ?></td>
                <td><?= $user["nameSurname"] ?></td>
                <td><?= $user["petName"] ?></td>
                <td>
                    <a class="btn" href="?delete=<?= $user["id"] ?>" title="Delete"><i class="fa-solid fa-trash-can"></i></a>
                    <a class="btn" href="edit.php?id=<?= $user["id"] ?>" title="Edit"><i class="fa-solid fa-pen"></i></i></a>
                </td>
            </tr>
            <?php endforeach ?>    
            <tr>
                <td colspan="5">Kullanıcı Sayısı: <?= $rs->rowCount() ?></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="id" placeholder="Kullanıcı ID"></td>
                <td><input type="text" name="nameSurname" placeholder="Kullanıcı Ad Soyad"></td>
                <td><input type="text" name="petName" placeholder="Hayvan Ad Soyad"></td>
                <td>
                  <button type="submit" class="btn" title="Add">
                   Kullanıcı Ekle
                  </button>
                </td>
            </tr>
            <tr>
                <td>
                    <a class="btn" href="logout.php">Çıkış Yap</a>
                </td>
            </tr>
        </table>
    </form>
    <?php
       if ( isset($msg)) {
           echo "<p class='msg'>" , $msg, "</p>" ;
       }
    ?>
       
</body>
</html>