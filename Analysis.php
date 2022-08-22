<?php

require "db.php";
session_start() ;
// check if the user authenticated before
if( !validSession()) {
    header("Location: loginPage.php") ;
    exit ; 
}

 $id = $_GET["id"] ;
 $date = $_GET["date"] ;
 try {
   $stmt = $db->prepare("SELECT * FROM analyzes WHERE id = ? AND date = ?") ;
   $stmt->execute([$id,$date]) ;
   $analysis = $stmt->fetch(PDO::FETCH_ASSOC) ;
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
    <title></title>
    <link rel="stylesheet" href="./styles/app.css">
</head>
<body>
<h1>Kan Tahlili</h1>
    <table>
        <img class="logos" src="./images/PetbilirLogo.png" height="100px" width="380px">
        <th>Kullanici Adi</th>
        <th>Tarih</th>
        <tr>
            <td><?= $id ?></td>
            <td><?= $date ?></td>
        </tr>
        <tr>
            <td> <?= $analysis["var1"] ?></td>
            <td> <?= $analysis["var2"] ?><td>
            <td> <?= $analysis["var3"] ?></td>
        </tr>
        <tr>
            <td><?= $analysis["var4"] ?></td>
            <td><?= $analysis["var5"] ?></td>
            <td><?= $analysis["var6"] ?></td>
        </tr>
        <tr>
            <td><?= $analysis["var7"] ?></td>
            <td><?= $analysis["var8"] ?></td>
            <td><?= $analysis["var9"] ?></td>
        </tr>
        <tr>
            <td><?= $analysis["var10"] ?></td>
            <td><?= $analysis["var11"] ?></td>
            <td><?= $analysis["var12"] ?></td>
        </tr>
        <tr>
            <td><?= $analysis["var13"] ?></td>
            <td><?= $analysis["var14"] ?></td>
            <td><?= $analysis["var15"] ?></td>
        </tr>
        <tr>
            <td><?= $analysis["var16"] ?></td>
            <td><?= $analysis["var17"] ?></td>
            <td><?= $analysis["var18"] ?></td>
        </tr>
        <tr>
            <td colspan="3" onClick="this.style.visibility='hidden'; window.print();this.style.visibility='visible';" >
            <button class="btn">Yazdır</button>
            </td>
        </tr>
    </table> 
</body>
</html>