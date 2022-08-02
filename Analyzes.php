<?php

// connection to the database
require "db.php" ;
session_start() ;
    // check if the user authenticated before
    if( !validSession()) {
        header("Location: loginPage.php") ;
        exit ; 
    }
$id = $_GET["id"] ;
   try {
     $stmt = $db->prepare("SELECT * FROM analyzes WHERE id = ?") ;
     $stmt->execute([$id]) ;
     $analyzes = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
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
    <title>Tahliller</title>
    <link rel="stylesheet" href="./styles/app.css">
</head>
    <body>
        <h1>Tahliller</h1>
        <table>
            <th>Kullanici ID</th>
            <th>Tarih</th>
            <?php foreach( $analyzes as $analysis) : ?>
            <tr>
                <td><?= $analysis['id'] ?></td>
                <td><?= $analysis['date'] ?></td>
                <td>
                    <a class="btn" href="Analysis.php?id=<?=$analysis["id"]?>&date=<?=$analysis["date"]?>">Tahlili gor</a>
                </td>
                
            </tr>
            <?php endforeach ?>    
            <tr>
                <td colspan="5">Tahlil Sayisi: <?= $stmt->rowCount() ?></td>
            </tr>
            <tr>
                <td>
                    <a class="btn" href="logout.php">Çıkış Yap</a>
                </td>
            </tr>
        </table>
    </body>
</html>