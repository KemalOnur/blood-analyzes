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
<div id="main-header">
    <div id="main-header-left">
        <img src="./images/LogoBeyaz.png" alt="petbilir-logo" height="50" width="200">
        <h1>Kan Tahlilleri</h1>
    </div>
    <div id="main-header-right">
    <p>Prestige Veteriner Tıp Merkezi için hazırlanmıştır.</p>
    </div>
</div>

    <form action="?" method="post">
 
    <table>
          
            <tr>
                <th>Kullanıcı ID</th>
                <th>Kullanıcı Adı Soyadı</th>
                <th>Hayvan Ad</th>
            </tr>
            <?php
                for($i = 0;$i<count($users)-1;$i++){
                    echo '<tr class = "data-row">' ;
                    echo '<td class="data">' . $users[$i]["id"] . '</td>' ;
                    echo '<td class="data">' . $users[$i]["petName"] . '</td>' ;
                    echo '<td class="data">' . $users[$i]["nameSurname"] . '</td>' ;
                    echo '<td class="action">' ;
                    echo '<a class="delete-btn" href="?delete=' . $users[$i]["id"] .  'title="Delete"><i class="fa-solid fa-trash-can"></i></a>'; 
                    echo ' <a class="edit-btn" href="edit.php?id=' . $users[$i]["id"] . 'title="Edit"><i class="fa-solid fa-pen"></i></i></a>' ;
                    echo '</td>' ;
                    echo '</tr>' ;
                }

                ?>  
    </table>  
            
                <div class = "user-count"> Kullanıcı Sayısı : <?= $rs->rowCount()-1 ?> </div>

            <div class="new-input-section">
                <div class="new-input-container">
                    <div>
                        <input class="input-area" type="text" name="id" placeholder="Kullanıcı ID">
                    </div>
                    <div>
                        <input class="input-area" type="text" name="nameSurname" placeholder="Kullanıcı Ad Soyad">
                    </div>
                    <div>
                        <input class="input-area" type="text" name="petName" placeholder="Hayvan Ad Soyad">
                    </div>
                </div>
                <div class="add-data-container">
                    <button type="submit" class="add-button" title="Add">
                        Kullanıcı Ekle
                    </button>
                </div>
            </div>
            <footer>
                <div class="footer-left-container"><img src="#" alt="prestige-logo"> </div>
                <div class="footer-right-container">
                    <a class="exit-button" href="logout.php">Çıkış Yap</a>
                </div>
            </footer>
    </form>
    <?php
       if ( isset($msg)) {
           echo "<p class='msg'>" , $msg, "</p>" ;
       }
    ?>
       
</body>
</html>