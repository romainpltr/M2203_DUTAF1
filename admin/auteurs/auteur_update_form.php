<?php
    include('../../classes/livres.php');

    $auteur_Select;
    session_start();

    if(!empty($_SESSION['auteurs'])){
        $auteurs = unserialize($_SESSION['auteurs']);
    }

    

    for($i=0; $i < count($auteurs); $i++){
        if($auteurs[$i]->getID() == $_GET['num_id']){ 
            $auteur_Select = $auteurs[$i];
        }
    }

    $_SESSION['auteurs'] = serialize($auteurs);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF - Ajouter un <?php echo $_GET['type'] ?></title
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
  
        <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include '../../includes/header.php'; ?>
        <div class="container">
            <br>
            <center><h3>Modification de <?php echo $auteur_Select->getFirstName().' '.$auteur_Select->getLastName()?> </h3></center>
            <?php 
                if(!empty($_GET['num_id'])){
            
                    echo '<form action="auteur_update_valide.php" method="GET" ><div class="form-group">
                        <label for="exampleInputPassword1">Prénom de l`auteur :</label>
                        <input class="form-control" value="'.$auteur_Select->getFirstName().'" name="a_prenom" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nom de l`auteur :</label>
                        <input  class="form-control" value="'.$auteur_Select->getLastName().'" name="a_name" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nationalité de l`auteur :</label>
                        <input  class="form-control" value="'.$auteur_Select->getNationality().'" name="a_nationalite" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Age de l`auteur:</label>
                        <input  class="form-control" value="'.$auteur_Select->getAge().'" name="a_age" id="exampleInputPassword1">
                    </div>
                    <button type="submit" name="idAuteur" value="'.$auteur_Select->getID().'" class="btn btn-success">Modifier</button>
                    </form>';
                }
            ?>
        </div>
    </body>
</html>