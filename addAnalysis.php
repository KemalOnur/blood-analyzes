<?php

    require "db.php" ;
    session_start() ;
    // check if the user authenticated before
    if( !validSession()) {
        header("Location: loginPage.php") ;
        exit ; 
    }
   
    $id = $_GET["id"] ;
    
    if ( !empty($_POST)) {
        extract($_POST) ;
        try {
         $stmt = $db->prepare("INSERT INTO analyzes (id,date,var1,var2,var3,var4,var5,var6,var7,var8,var9,var10,var11,var12,var13,var14,var15,var16,var17,var18) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" ) ;
         $stmt->execute([$id,$date, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var10, $var11, $var12, $var13, $var14, $var15, $var16, $var17, $var18]) ;
         $msg = "Tahlil (" . $db->lastInsertId() . ") Eklendi" ;
         header("Location: Analyzes.php?id=$id") ;
        } catch(PDOException $ex) {
          echo $ex->getMessage();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahlil Ekle</title>
    <link rel="stylesheet" href="./styles/app.css">
</head>
<body>
<div id="main-header">
        <div id="main-header-container">
            <div id="main-header-left">
                <a href="https://www.petbilir.com/">
                <img src="./images/LogoBeyaz.png" alt="petbilir-logo" height="50" width="200">
                </a>
                <h1>Kan Tahlili Ekle</h1>
            </div>

            <div id="main-header-right">
                <p><a class="written-prestige" href="http://www.prestige.vet/index.php">Prestige Veteriner Tıp Merkezi</a> için hazırlanmıştır.</p>
            </div>
        </div>
    </div>
    <form action="?" method="POST">
    <table>
        <tr>
            
            <td colspan="2">
                <?= $id ?>
                <input type="hidden" name="id" value="<?= $id?>">
            </td>
            <td>
                <input type="date" name="date">
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="text" name="var1" placeholder="Deger1"></td>
            <td><input type="text" name="var2" placeholder="Deger2"></td>
            <td colspan="2"><input type="text" name="var3" placeholder="Deger3"></td>
        </tr>
        <tr>
            <td><input type="text" name="var4" placeholder="Deger4"></td>
            <td colspan="2"><input type="text" name="var5" placeholder="Deger5"></td>
            <td><input type="text" name="var6" placeholder="Deger6"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="text" name="var7" placeholder="Deger7"></td>
            <td><input type="text" name="var8" placeholder="Deger8"></td>
            <td colspan="2"><input type="text" name="var9" placeholder="Deger9"></td>
        </tr>
        <tr>
            <td><input type="text" name="var10" placeholder="Deger10"></td>
            <td colspan="2"><input type="text" name="var11" placeholder="Deger11"></td>
            <td><input type="text" name="var12" placeholder="Deger12"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="text" name="var13" placeholder="Deger13"></td>
            <td><input type="text" name="var14" placeholder="Deger14"></td>
            <td colspan="2"><input type="text" name="var15" placeholder="Deger15"></td>
        </tr>
        <tr>
            <td><input type="text" name="var16" placeholder="Deger16"></td>
            <td colspan="2"><input type="text" name="var17" placeholder="Deger17"></td>
            <td> <input type="text" name="var18" placeholder="Deger18"></td>
        </tr>
        <tr>
            <td colspan="3" >
                <button type="submit" class="btn" title="Tahlil Ekle">
                    Tahlil Ekle
                </button>
            </td>
        </tr>
    </table> 
    </form>   
    <footer>
        <div class="footer-section">
            <div class="footer-container-left">
                <a href="http://www.prestige.vet/index.php">
                <img src="./images/prestige-logo.jpg" alt="prestige-logo" height="60" width="120"> 
                </a>
            </div>
                <div class="footer-container-right">
                <a class="exit-button" href="logout.php">
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