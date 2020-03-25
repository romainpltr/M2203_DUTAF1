<?php 
    include('../classes/livres.php');
    include('../config_inc.php');

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
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
    </head>
    <body>
        <?php include '../includes/header.php'; ?>
        <div class="container">
        <br>
            <?php if(!empty($_GET['type']) && $_GET['type'] == "livre"){ // Ajouter livre dans BDD + Créer Objet et l'ajouter dans le tableau.
                echo '
                <form action="#" method="GET" ><div class="form-group">
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
                        echo '<option name="'.$auteurs[$i]->getID().'" >'.$auteurs[$i]->getFirstName().' '.$auteurs[$i]->getLastName().'</option>';
                    }
                    echo '
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Editeur</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                    <option></option>';
                    for($i=0;$i<count($editeurs);$i++){
                        echo '<option>'.$editeurs[$i]->getName().'</option>';
                    }
                    echo '
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Ajouter</button> 
                </form>';
            }else if(!empty($_GET['type']) && $_GET['type'] == "auteur"){
            
                echo '<form action="bd_new_form.php?" method="GET" ><div class="form-group">
                    <label for="exampleInputPassword1">Prénom de l`auteur :</label>
                    <input  class="form-control" name="a_prenom" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nom de l`auteur :</label>
                    <input  class="form-control" name="a_name" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nationalité de l`auteur :</label>
                    <input  class="form-control" name="a_nationalite" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Age de l`auteur:</label>
                    <input  class="form-control" name="a_age" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-success">Ajouter</button>
                </form>';
            }else if(!empty($_GET['type']) && $_GET['type'] == "editeur"){
                echo '
                <form action="#" method="GET" ><div class="form-group">
                    <label for="exampleInputPassword1">Nom de l`editeur :</label>
                    <input class="form-control" name="e_name" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Pays de l`editeur :</label>
                    <input class="form-control" name="e_country" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Téléphone de l`editeur :</label>
                    <input class="form-control" name="e_tel" id="exampleInputPassword1">
                    <button type="submit" class="btn btn-success">Ajouter</button> 
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