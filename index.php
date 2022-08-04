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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    
    <title>Kan Tahlilleri</title>
    <link rel="stylesheet" href="./styles/app.css">

</head>

<body>
    <div id="main-header">
        <div id="main-header-container">
            <div id="main-header-left">
                <img src="./images/LogoBeyaz.png" alt="petbilir-logo" height="50" width="200">
                <h1>Kan Tahlilleri</h1>
            </div>

            <div id="main-header-right">
                <p>Prestige Veteriner Tıp Merkezi için hazırlanmıştır.</p>
            </div>
        </div>
    </div>
    <div id="table-container">
    <form class="form-section" action="?" method="post">
        <table>
            <tr class="table-row-header">
                <th>🆔 Kullanıcı ID</th>
                <th>🧑 Kullanıcı Adı Soyadı</th>
                <th>🐾 Hayvanın Adı</th>
                <th>⏏️ Eylemler</th>
            </tr>
            <?php foreach( $users as $user) : ?>
            <tr>
                <td><?= $user["id"] ?></td>
                <td><?= $user["nameSurname"] ?></td>
                <td><?= $user["petName"] ?></td>
                <td>
                    <a class="btn" href="?delete=<?= $user["id"] ?>" title="Delete"><i
                            class="fa-solid fa-trash-can"></i></a>
                    <a class="btn" href="edit.php?id=<?= $user["id"] ?>" title="Edit"><i
                            class="fa-solid fa-pen"></i></i></a>
                </td>
            </tr>
            <?php endforeach ?>
            <tr>
                <td class="user-number-row" colspan="5">Kullanıcı Sayısı: <?= $rs->rowCount() ?></td>
            </tr>
            <tr>
                <td colspan="2"><input class="input-data" type="text" name="id" placeholder="Kullanıcı ID"></td>
                <td><input class="input-data" type="text" name="nameSurname" placeholder="Kullanıcı Ad Soyad"></td>
                <td><input class="input-data" type="text" name="petName" placeholder="Hayvanın Adı"></td>
                <td>
                    <button type="submit" class="add-user-btn" title="Add">
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
    </div>
    <?php
       if ( isset($msg)) {
           echo "<p class='msg'>" , $msg, "</p>" ;
       }
    ?>

</body>

</html>