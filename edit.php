<?php
   require "db.php" ;
   session_start() ;
   // check if the user authenticated before
   if( !validSession()) {
       header("Location: loginPage.php") ;
       exit ; 
   }
   if ( !empty($_POST)) {
       extract($_POST) ;
       try {
         $stmt = $db->prepare("UPDATE users SET id= :id , nameSurname = :nameSurname, petName = :petName WHERE id = :id") ;
         $stmt->execute(["id" => $id, "nameSurname" => $nameSurname, "petName" => $petName]) ;
         header("Location: index.php?edit=$id") ;
         exit ;
       } catch(PDOException $ex) {
           gotoErrorPage() ;
       }
   }


   $id = $_GET["id"] ;
   try {
     $stmt = $db->prepare("SELECT * FROM users WHERE id = ?") ;
     $stmt->execute([$id]) ;
     $user = $stmt->fetch(PDO::FETCH_ASSOC) ;
   } catch( PDOException $ex) {
        gotoErrorPage() ;
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

    <title>Kullanıcı Ayarları</title>
    <link rel="stylesheet" href="./styles/edit-php.css">
</head>
<body>
<div id="main-header">
        <div id="main-header-container">
            <div id="main-header-left">
                <a href="https://www.petbilir.com/">
                <img src="./images/LogoBeyaz.png" alt="petbilir-logo" height="50" width="200">
                </a>
                <h1 class="header-title">Kullanıcı Ayarları</h1>
            </div>

            <div id="main-header-right">
                <p><a class="written-prestige" href="http://www.prestige.vet/index.php">Prestige Veteriner Tıp Merkezi</a> için hazırlanmıştır.</p>
            </div>
        </div>
    </div>
    
    <div class="form-container">
    <form action="" method="post">
        <table class="table-section">
            <tr>
                <td>Kullanıcı ID</td>
                <td>
                   <?= $user["id"] ?>
                   <input type="hidden" name="id" value="<?= $user["id"] ?>">
                </td>
            </tr>
            <tr>
                <td>Ad Soyad</td>
                <td>
                    <input type="text" name="nameSurname" value="<?= $user["nameSurname"] ?>">
                </td>
            </tr>
            <tr>
                <td>Hayvan Ad</td>
                <td>
                    <input type="text" name="petName" value="<?= $user["petName"] ?>"> 
                </td>
            </tr>
            <tr>
                <td>
                   <button type="submit" class="submit-btn">
                   Değişiklikleri Kaydet
                   </button>
                </td>
                <td>
                    <a class="add-btn" href="addAnalysis.php?id=<?= $user["id"] ?>" title="Tahlil Ekle">Tahlil Ekle</a>
                    <a class="show-btn" href="Analyzes.php?id=<?= $user["id"] ?>" title="Tahlilleri gör">Tahlilleri gör</a>
                    <a class="delete-btn" href="Analyzes.php?id=<?= $user["id"] ?>" title="Tahlilleri gör">Kullanıcıyı Sik</a>

                </td>
            </tr>
            
        </table>
    </form>
    </div>
    <footer>
        <div class="footer-section">
            <div class="footer-container-left">
                <a href="http://www.prestige.vet/index.php">
                <img src="./images/prestige-logo.jpg" alt="prestige-logo" height="60" width="120"> 
                </a>
            </div>
            <a class="exit-button" href="index.php">
                <div class="footer-container-right">
                    <div class="footer-exit-button">
                    
                    <i class="fa-solid fa-backward fa-xl"></i>
                    Geri Dön
                    
                </div>
                </a>     
            </div>
        </div>
    </footer>
</body>
</html>