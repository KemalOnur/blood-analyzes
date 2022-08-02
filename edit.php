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
    <title>Kullanıcı Ayarları</title>
    <link rel="stylesheet" href="./styles/app.css">
</head>
<body>
    <h1>Kullanıcı Ayarları</h1>
    <form action="" method="post">
        <table>
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
                   <button type="submit" class="btn">
                   Değişiklikleri Kaydet
                   </button>
                </td>
                <td>
                    <a class="btn" href="addAnalysis.php?id=<?= $user["id"] ?>" title="Tahlil Ekle">Tahlil Ekle</a>
                    <a class="btn" href="Analyzes.php?id=<?= $user["id"] ?>" title="Tahlilleri gör">Tahlilleri gör</a>

                </td>
            </tr>
            
        </table>
    </form>
</body>
</html>