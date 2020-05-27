

<?php 
    include('../../classes/livres.php');
    include('../../functions/function_bdd.php');
    session_start();    
    $validate = false;
    if(!empty($_SESSION['auteurs'])){
        $auteurs = unserialize($_SESSION['auteurs']);
    }

    for($i=0; $i <= count($auteurs); $i++){
        if(!empty($auteurs[$i])){
            if(!empty($_GET['idAuteur']) && $auteurs[$i]->getID() == $_GET['idAuteur']){ 
                $auteurs_Selected = $i;
            }else if(!empty($_GET['idAuteur_validate']) && $auteurs[$i]->getID() == $_GET['idAuteur_validate']){
                $auteurs_Selected = $i;
                $validate = true;
            }
        }
    }

    if($validate == true){
        $idAuteur = $_GET['idAuteur_validate'];
        // POSTION DANS LE TABLEAU ALBUM = ALBUM SELECTIONNER
        if(!empty($_GET['idAuteur']) || $_GET['idAuteur'] == "0"){
            // POUR PLUS DE SECURITER FAIRE LES VERIFICATIONS HERE
            $idAuteur = $_GET['idAuteur'];
        }

        if(!empty($_GET['a_prenom'])){
            $auteurs[$auteurs_Selected]->setFirstName($_GET['a_prenom']);    
        }
        
        if(!empty($_GET['a_name'])){
            $auteurs[$auteurs_Selected]->setLastName($_GET['a_name']);
        }
        
        if(!empty($_GET['a_nationalite'])){
            $auteurs[$auteurs_Selected]->setNationality($_GET['a_nationalite']);
        }

        if(!empty($_GET['a_age'])){
            $auteurs[$auteurs_Selected]->setAge($_GET['a_age']);
        }


        $data = [
            'prenom' => $_GET['a_prenom'],
            'nom' => $_GET['a_name'],
            'nat' => $_GET['a_nationalite'],
            'age' => $_GET['a_age'],
            'id' => $idAuteur
        ];

        

        $req = "UPDATE auteur SET auteur_prenom=:prenom, auteur_nom=:nom, auteur_nat=:nat, auteur_age=:age WHERE auteur_id=:id";
        BDD_Update($req, $data);
        
        $_SESSION['erreurs']['success'] = '<br><div class="alert alert-success" role="alert">
        Vous venez de modifier l\'auteur : '.$auteurs[$auteurs_Selected]->getFirstName().' '.$auteurs[$auteurs_Selected]->getLastName().'  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
        $_SESSION['auteurs'] = serialize($auteurs);  // Tableau des auteurs 
       
        header('Location: auteur_gestion.php');

    }
         
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF - Validation de la modification </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
  
        <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include '../../includes/header.php'; ?>
        <div class="container">
            <br>
            <center><h3>Validation de la modification de <?php echo $auteurs[$auteurs_Selected]->getFirstName().' '.$auteurs[$auteurs_Selected]->getLastName() ?></h3></center>
            <br>
            <?php 
                if(!empty($_GET['idAuteur'])){
            
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
                    <button type="submit" name="idAuteur_validate" value="'.$_GET['idAuteur'].'" class="btn btn-danger">Valider les modifications</button>
                    
                    
                    </form><br><a href="auteur_gestion.php"><button type="submit" class="btn btn-primary">Annuler</button></a>';
                }
            ?>
        </div>
    </body>
</html>