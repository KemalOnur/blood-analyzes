<?php
session_start() ;
require "db.php" ;
// check if the user authenticated before
if( !validSession()) {
    header("Location: loginPage.php") ;
    exit ; 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servis Yok!</title>
    <link rel="stylesheet" href="./styles/app.css">
</head>
<body>
    <h1>Servis yok, lütfen sonra deneyin!</h1>
</body>
</html>