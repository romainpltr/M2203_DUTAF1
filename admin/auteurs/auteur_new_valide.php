<?php 
include('../../classes/livres.php');
include('../../functions/function_bdd.php');
session_start();


if(!empty($_SESSION['auteurs'])){
    $auteurs = unserialize($_SESSION['auteurs']);
}

if(!empty($_GET['idAuteur_validate']) && $_GET['idAuteur_validate'] == 1){
    $validate = true;
}

//AUTEUR
if(!empty($validate) && $validate == true){
    if(!empty($_GET['a_prenom']) || !empty($_GET['a_name']) || 
    !empty($_GET['a_nationalite']) || !empty($_GET['a_age'])){

        // RECUPERATION DES INFOS
        $prenom = $_GET['a_prenom'];
        $nom = $_GET['a_name'];
        $nationalite = $_GET['a_nationalite'];
        $age = $_GET['a_age'];


        // A FAIRE CREER DES OBJET POUR LES REQUETES
        $data;
        $req = 'INSERT INTO auteur (auteur_prenom, auteur_nom, auteur_nat, auteur_age) VALUES ("'.$prenom.'", "'.$nom.'", "'.$nationalite.'", '.$age.')';
        
        // Fonction qui ajoute en fonction de la requete avec une sous-fonction pour recupere le dernier ID.
        $id = BDD_Add($req,$data);

        //CREATION D'UN AUTEUR
        $auteur = new auteur();
        $auteur->setID($id);
        $auteur->setFirstName($prenom);
        $auteur->setLastName($nom);
        $auteur->setNationality($nationalite);
        $auteur->setAge($age);
        $auteurs[] = $auteur;
        
        $_SESSION['erreurs']['success'] = '<div class="alert alert-success" role="alert"> Vous avez ajouter '.$auteur->getFirstName()." ". $auteur->getLastName(). ' à la liste des auteurs <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
        $_SESSION['auteurs'] = serialize($auteurs);
        header('Location: auteur_gestion.php');


    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF - Validation d'ajout </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
  
        <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include '../../includes/header.php'; ?>
        <div class="container">
            <br>
            <center><h1>Validation d'ajout de  <?php echo $_GET['a_prenom'].' '.$_GET['a_name'];?></h1></center>
            <br>
            <?php 
            
                    echo '<form action="#" method="GET" ><div class="form-group">
                        <label for="exampleInputPassword1">Prénom de l`auteur :</label>
                        <input class="form-control" value="'.$_GET['a_prenom'].'" name="a_prenom" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nom de l`auteur :</label>
                        <input  class="form-control" value="'.$_GET['a_name'].'" name="a_name" id="exampleInputPassword1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nationalité de l`auteur :</label>
                        <input  class="form-control" value="'.$_GET['a_nationalite'].'" name="a_nationalite" id="exampleInputPassword1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Age de l`auteur:</label>
                        <input  class="form-control" value="'.$_GET['a_age'].'" name="a_age" id="exampleInputPassword1" readonly>
                    </div>
                    <button type="submit" name="idAuteur_validate" value="1" class="btn btn-danger">Valider cet ajout</button>
                    <button type="submit" class="btn btn-primary">Annuler</button>
                    
                    </form>';
            ?>
        </div>
    </body>
</html>


