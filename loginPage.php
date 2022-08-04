<?php
    session_start();
    require "db.php";
    if ( !empty($_POST)) {
        extract($_POST) ;
        if ( checkUser($id, $pass) ) {
            echo '<style>#wrong-password {display:none;margin-bottom: 5%;padding: 5%;width: 280px;font-family: "Montserrat", sans-serif;font-size: 1em;border-radius: 8px;border: 1px solid #ced4da;background-color: rgb(255, 23, 23);color: white;text-align: center;margin-top: 0;}</style>';
            // you are authenticated
            // session_start() creates a random id called session id.
            // and stores in a cookie.
  
            $_SESSION["user"] = getUser($id) ;
            if($_SESSION["user"]["userType"]=='normal'){
                header("Location: Analyzes.php?id=$id") ;
                exit ;
            }else {
                header("Location: index.php") ;
                exit ;
            }
        }
        else{
        echo '<style> #wrong-password{visibility:visible; margin-bottom: 5%;padding: 5%;width: 280px;font-family: "Montserrat", sans-serif;font-size: 1em;border-radius: 8px;border: 1px solid #ced4da;background-color: rgb(255, 23, 23);color: white;text-align: center;margin-top: 0;}</style>';
        }
    }else{
        echo '<style>#wrong-password {display:none;margin-bottom: 5%;padding: 5%;width: 280px;font-family: "Montserrat", sans-serif;font-size: 1em;border-radius: 8px;border: 1px solid #ced4da;background-color: rgb(255, 23, 23);color: white;text-align: center;margin-top: 0;}</style>';
    }

    
    // auto login
  if ( validSession()) {
    $_SESSION["user"] = getUser($id) ;
    if($_SESSION["user"]["userType"]=='normal'){
        header("Location: Analyzes.php?id=$id") ;
        exit ;
    }else {
        header("Location: index.php") ;
        exit ;
    }
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
    <link rel="stylesheet" href="./styles/style.css">
    <title>Giriş Yap</title>
</head>
<body>
    <section class="main-container">
            
            <div class="side-one">
                <div id="petbilir-logo-section">
                    <img src="./images/LogoBeyaz.png" alt="petbilir-logo-image" height="100" width="400">
                </div>
                <div id="petbilir-id-section">
                    <p class="description">Teknik Altyapı, Petbilir Tarafından sağlanmıştır.</p>
                </div>
            </div>

            <div class="side-two">
                <div id="main-container">
                    <section id="form-section">
                        <div id="form-container">
                            <h2>Hoşgeldiniz! 😺</h2>

                            <form action="?" method="POST">
                            <input type="number" name="id" placeholder="Kullanıcı Numarası">
                            <br>
                            <input type="password" name ="pass" placeholder="Parola">
                            <p id="wrong-password">Kullanıcı Adı veya Parola Hatalı  :(</p>
                            <button type="submit" title="Giriş Yap">Giriş Yap</button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>

    </section>
</body>
</html>