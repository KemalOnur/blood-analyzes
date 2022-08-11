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

   // DELETE a User
   if ( isset($_GET["delete"])) {
       $id = $_GET["delete"] ;
       $user = getUser($id) ;
       try {

          $stmt = $db->prepare("DELETE FROM users where id = ?") ;
          $stmt->execute([$id]) ;
          $msg = "{$user["nameSurname"]} Silindi" ;
          header("Location: index.php") ;
       } catch(PDOException $ex) {
            $ex->getMessage();
            echo $ex ;
            echo $id ;
       } 
   }

   // INSERT a user
   if ( !empty($_POST)&&!isset($_POST['input'])) {
       extract($_POST) ;
       try {
        $userType = "normal" ;
        $randomNum = rand(10000000,99999999);
        $stmt = $db->prepare("INSERT INTO users (id,userType,nameSurname,petName,animalType, password) VALUES (?,?,?,?,?,?)" ) ;
        $stmt->execute([$id,$userType, $nameSurname,$petName,$animalType,$randomNum]) ;
        $msg = "$nameSurname Eklendi" ; 
       } catch(PDOException $ex) {
        echo $ex->getMessage();
       
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
    $rss = $db->query("select * from analyzes") ;
    $analyzes = $rss->fetchAll(PDO::FETCH_ASSOC) ;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Kan Tahlilleri</title>
    <link rel="stylesheet" href="./styles/app.css">


</head>

<body>
    <div id="main-header">
        <div id="main-header-container">
            <div id="main-header-left">
                <a href="https://www.petbilir.com/">
                    <img src="./images/LogoBeyaz.png" alt="petbilir-logo" height="50" width="200">
                </a>
                <h1>Kan Tahlilleri</h1>
            </div>

            <div id="main-header-right">
                <p><a class="written-prestige" href="http://www.prestige.vet/index.php">Prestige Veteriner Tıp
                        Merkezi</a> için hazırlanmıştır.</p>
            </div>
        </div>
    </div>
    <div id="table-container">
        <form class="form-section" action="?" method="post">
            <div class="user-count-search-section">
                    <div class="user-count-container">
                        Kullanıcı Sayısı : <?= $rs->rowCount()-1 ?>
                    </div>
                    <div class="user-search-container">
                        <input type="text" name="search-text" id="search-text"
                        placeholder="Kullanıcı Adına Göre Arama">
                    </div>
                </div>
                
            </div>
    </div>
    <div class="new-input-section">
        <div class="new-input-container">
            <div>
                <input class="input-area" type="number" name="id" placeholder="Kullanıcı ID">
            </div>
            <div>
                <input class="input-area" type="text" name="nameSurname" placeholder="Kullanıcı Ad Soyad">
            </div>
            <div>
                <input class="input-area" type="text" name="petName" placeholder="Hayvan Adı">
            </div>
            <div>
                <select class="input-area-select" name="animalType" id="animal-type">
                    <option value="kedi">Kedi</option>
                    <option value="köpek">Köpek</option>
                </select>
            </div>
        </div>
        <div class="add-data-container">
            <button type="submit" class="add-button" title="Add">
                <i class="fa-solid fa-plus fa-xl"></i>Kullanıcı Ekle
            </button>
        </div>
    </div>

    <table>
        <div class="table-header-container">
            <div class="table-row-header">
                <div class="table-row-header-left">Kullanıcı ID</div>
                <div class="table-row-header-middle-left">Kullanıcı Adı Soyadı</div>
                <div class="table-row-header-middle-right">Hayvanın Adı</div>
                <div class="table-row-header-right">Eylemler</div>
            </div>
        </div>
        <div class="search-result-section">
            <div id="searchresult">

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
                <div class="footer-exit-button">
                    <a class="exit-button" href="logout.php">
                        <i class="fa-solid fa-power-off fa-xl"></i>
                        Çıkış Yap
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <?php
       if ( isset($msg)) {
           echo "<p class='msg'>" , $msg, "</p>" ;
       }
    ?>
    <script type="text/javascript">
    $(document).ready(function() {

        var input = $(this).val();
        $.ajax({
            url: "livesearch.php",
            method: "POST",
            data: {
                input: input
            },

            success: function(response) {
                $("#searchresult").html(response);
            }
        });

        $("#search-text").keyup(function() {
            var input = $(this).val();
            $.ajax({

                url: "livesearch.php",
                method: "POST",
                data: {
                    input: input
                },

                success: function(response) {
                    $("#searchresult").html(response);
                }
            });
        });
    });
    </script>
</body>

</html>