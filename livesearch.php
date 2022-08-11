<?php
    require "db.php" ;
    
    try {
        $rs = $db->query("select * from users") ;
        $users = $rs->fetchAll(PDO::FETCH_ASSOC) ;
    } catch( PDOException $ex) {
         gotoErrorPage();
    }   
                if(isset($_POST['input'])){
                    $input = $_POST['input'] ;

                    $query = "SELECT * FROM users WHERE nameSurname LIKE '{$input}%'" ;

                    
                }else{
                    $query = "SELECT * FROM users " ;

                    
                }
                    $result = mysqli_query($con,$query);

                if(mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        $id = $row['id'];
                        $nameSurname = $row['nameSurname'];
                        $petName = $row['petName'];
                        $animalType = $row['animalType'];
                        echo '<tr class = "data-row">' ;
                        echo '<td class="data-left-side">' . $id . '</td>' ;
                        echo '<td class="data-pet-name">' . $nameSurname . '</td>' ;
                        if($animalType=="kopek"){
                            echo '<td class="animal-img"><img src="./images/kopek.png" alt="kopek" width="50" height="50">Köpek</td>' ;
                        }else if ($animalType=="kedi"){
                            echo '<td class="animal-img"><img src="./images/kedi.png" alt="kedi" width="50" height="50">Kedi</td>' ;
                        }
                        echo '<td class="data-user-name">' . $petName . '</td>' ;
                        echo '<td class="action-right-side">' ;
                                echo '<a class="delete-btn" href="?delete=' . $id .'"title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></a>'; 
                                echo ' <a class="edit-btn" href="edit.php?id=' . $id . ' "title="Edit"><i class="fa-solid fa-pen fa-xl"></i></i></a>' ;
                            echo '</td>' ;
                        echo '</tr>';
                    }
                }
                ?> 