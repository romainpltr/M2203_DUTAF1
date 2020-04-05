<?php
    include('../../classes/livres.php');
    include('../../config_inc.php');
    $admin = 1;
    $editeur_Select;
    session_start();

    if(!empty($_SESSION['editeurs'])){
        $editeurs = unserialize($_SESSION['editeurs']);
    }

    for($i=0; $i < count($editeurs); $i++){
        if($editeurs[$i]->getID() == $_GET['num_id']){ 
            $editeur_Select = $editeurs[$i];
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF - Modification de </title
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
  
        <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include '../../includes/header.php'; ?>
        <div class="container">
            <?php 
                if(!empty($_GET['num_id'])){
                    echo '
                    <form action="editeur_update_valide.php" method="GET" ><div class="form-group">
                        <label for="exampleInputPassword1">Nom de l`editeur :</label>
                        <input class="form-control" value="'.$editeur_Select->getName().'" name="e_name" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Pays de l`editeur :</label>
                        <input class="form-control" value="'.$editeur_Select->getCountry().'" name="e_country" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Téléphone de l`editeur :</label>
                        <input class="form-control" value="'.$editeur_Select->getTelephone().'" name="e_tel" id="exampleInputPassword1"> 
                    </div>
                    <button type="submit" name="idEditeur" value="'.$editeur_Select->getID().'"class="btn btn-success">Modifier</button> 
                    </form>';
                }
            ?>
        </div>
    </body>
</html>