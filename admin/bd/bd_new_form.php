<?php 
    include('../../classes/livres.php');
    include('../../config_inc.php');

    $albums = array();
    $auteurs = array();
    $editeurs = array();

    ob_start("ob_gzhandler");
    session_start();
    if(!empty($_SESSION['albums'])){
        $albums = unserialize($_SESSION['albums']);
     }
    if(!empty($_SESSION['auteurs'])){
         $auteurs = unserialize($_SESSION['auteurs']);
    } 
    if(!empty($_SESSION['editeurs'])){
         $editeurs = unserialize($_SESSION['editeurs']);
    }

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
            <?php if(!empty($_GET['type']) && $_GET['type'] == "livre"){ // Ajouter livre dans BDD + Créer Objet et l'ajouter dans le tableau.
                echo '
                
                <form action="bd_new_valide.php" method="GET" >
                <div class="form-group">
                    <label for="exampleInputEmail1">ISBN :</label>
                    <input class="form-control" name="l_isbn" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Titre :</label>
                    <input class="form-control" name="l_title" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Série :</label>
                    <input  class="form-control"" name="l_serie" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Prix :</label>
                    <input  class="form-control"" name="l_price" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Auteur</label>
                    <select class="form-control" name="auteur" id="exampleFormControlSelect1">
                    <option></option>';
                    for($i=0;$i<count($auteurs);$i++){
                        echo '<option value="'.$auteurs[$i]->getID().'">'.$auteurs[$i]->getFirstName().' '.$auteurs[$i]->getLastName().'</option>';
                    }
                    echo '
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Editeur</label>
                    <select class="form-control" name="editeur" id="exampleFormControlSelect1">
                    <option></option>';
                    for($i=0;$i<count($editeurs);$i++){
                        echo '<option value="'.$editeurs[$i]->getID().'">'.$editeurs[$i]->getName().'</option>';
                    }
                    echo '
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Ajouter</button> 
                </form>';
            }
            ?>
            
            </form>
            <br>
            <a href="bd_gestion.php"><button class="btn btn-primary">Retour</button></a>
            <br>
            <br>
        </div>
    </body>
</html>