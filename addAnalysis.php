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
    <link rel="stylesheet" href="./styles/add-analysis.css">
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
                <p>
                    <a class="written-prestige" href="http://www.prestige.vet/index.php">Prestige Veteriner Tıp
                    Merkezi</a> için hazırlanmıştır.
                </p>
            </div>

        </div>
    </div>
    <div class="analysis-add-form-section">
        <form class="add-analysis-form" action="?" method="POST">
            <table class="new-analysis-table">
                <div class="date-id-count-container">
                    <div class="id-count-container">
                        <h3>Tahlil Eklenen ID</h3>
                        <?= $id ?>
                        <input type="hidden" name="id" value="<?= $id?>">
                    </div>
                    <div>
                        <input type="date" name="date">
                    </div>
                </div>
                <div>
                    <div colspan="2"><input type="text" name="var1" placeholder="Deger1"></div>
                    <div><input type="text" name="var2" placeholder="Deger2"></div>
                    <div colspan="2"><input type="text" name="var3" placeholder="Deger3"></div>
                </div>
                <div>
                    <div><input type="text" name="var4" placeholder="Deger4"></div>
                    <div colspan="2"><input type="text" name="var5" placeholder="Deger5"></div>
                    <div><input type="text" name="var6" placeholder="Deger6"></div>
                </div>
                <div>
                    <div colspan="2"><input type="text" name="var7" placeholder="Deger7"></div>
                    <div><input type="text" name="var8" placeholder="Deger8"></div>
                    <div colspan="2"><input type="text" name="var9" placeholder="Deger9"></div>
                </div>
                <div>
                    <div><input type="text" name="var10" placeholder="Deger10"></div>
                    <div colspan="2"><input type="text" name="var11" placeholder="Deger11"></div>
                    <div><input type="text" name="var12" placeholder="Deger12"></div>
                </div>
                <div>
                    <div colspan="2"><input type="text" name="var13" placeholder="Deger13"></div>
                    <div><input type="text" name="var14" placeholder="Deger14"></div>
                    <div colspan="2"><input type="text" name="var15" placeholder="Deger15"></div>
                </div>
                <div>
                    <div><input type="text" name="var16" placeholder="Deger16"></div>
                    <div colspan="2"><input type="text" name="var17" placeholder="Deger17"></div>
                    <div> <input type="text" name="var18" placeholder="Deger18"></div>
                </div>
                <div>
                    <div colspan="3">
                        <button type="submit" class="btn" title="Tahlil Ekle">
                            Tahlil Ekle
                        </button>
                    </div>
                </div>
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