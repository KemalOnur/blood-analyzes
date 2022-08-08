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
    <div id="main-header">
        <div id="main-header-container">
            <div id="main-header-left">
                <a href="https://www.petbilir.com/">
                <img src="./images/LogoBeyaz.png" alt="petbilir-logo" height="50" width="200">
                </a>
                <h1>Tahliller</h1>
            </div>

            <div id="main-header-right">
                <p><a class="written-prestige" href="http://www.prestige.vet/index.php">Prestige Veteriner Tıp Merkezi</a> için hazırlanmıştır.</p>
            </div>
        </div>
    </div>
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
        </table>
        <footer>
        <div class="footer-section">
            <div class="footer-container-left">
                <a href="http://www.prestige.vet/index.php">
                <img src="./images/prestige-logo.jpg" alt="prestige-logo" height="60" width="120"> 
                </a>
            </div>
                <div class="footer-container-right">
                    <div class="footer-exit-button">
                    <a class="exit-button" href="logout.php">
                    <i class="fa-solid fa-power-off fa-xl"></i>
                    Çıkış Yap
                    </a>
                </div>     
            </div>
        </div>
    </footer>
    </body>
</html>