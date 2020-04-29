

<?php 
    include('../../classes/livres.php');
    include('../../functions/function_bdd.php');
    session_start();    
    $idEditeur;
    
    if(!empty($_SESSION['editeurs'])){
        $editeurs = unserialize($_SESSION['editeurs']);
    }

    if(!empty($_GET['idEditeur']) || $_GET['idEditeur'] == '0'){
        for($i=0; $i <= count($editeurs); $i++){
            if(!empty($editeurs[$i])){
                if($editeurs[$i]->getID() == $_GET['idEditeur']){ 
                    $editeur_selected = $i;
                }
            }
        }
    }

    if(isset($_GET['validate'])){
        if(!empty($_GET['validate']) || $_GET['validate'] == '0'){
        
            for($i=0; $i <= count($editeurs); $i++){
                if(!empty($editeurs[$i])){
                    if($editeurs[$i]->getID() == $_GET['validate']){ 
                        $editeur_selected = $i;
                    }
                }
            }

        // POSTION DANS LE TABLEAU ALBUM = ALBUM SELECTIONNER
            if(!empty($_GET['idEditeur']) || $_GET['idEditeur'] == "0"){
                // POUR PLUS DE SECURITER FAIRE LES VERIFICATIONS HERE
                $idEditeur = $_GET['idEditeur'];
            }

            if(!empty($_GET['e_name'])){
                $editeurs[$editeur_selected]->setName($_GET['e_name']);    
            }
            
            if(!empty($_GET['e_country'])){
                $editeurs[$editeur_selected]->setCountry($_GET['e_country']);
            }
            
            if(!empty($_GET['e_tel'])){
                $editeurs[$editeur_selected]->setTelephone($_GET['e_tel']);
            }


            $data = [
                'nom' => $_GET['e_name'],
                'country' => $_GET['e_country'],
                'tel' => $_GET['e_tel'],
                'id' => $idEditeur
            ];

            

            $req = "UPDATE editeur SET editeur_nom=:nom, editeur_pays=:country, editeur_tel=:tel WHERE editeur_id=:id";
            BDD_Update($req, $data);
            
            $_SESSION['erreurs']['success'] = '<br><div class="alert alert-success" role="alert">
            Vous venez de modifier l\'éditeur : '.$editeurs[$editeur_selected]->getName().'  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
            $_SESSION['editeurs'] = serialize($editeurs);  // Tableau des auteurs 
        
            header('Location: editeur_gestion.php');
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
                
                echo '
                    <br>
                    <form action="#" method="GET" ><div class="form-group">
                        <label for="exampleInputPassword1">Nom de l`editeur :</label>
                        <input class="form-control" value="'.$_GET['e_name'].'" name="e_name" id="exampleInputPassword1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Pays de l`editeur :</label>
                        <input class="form-control" value="'.$_GET['e_country'].'" name="e_country" id="exampleInputPassword1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Téléphone de l`editeur :</label>
                        <input class="form-control" value="'.$_GET['e_tel'].'" name="e_tel" id="exampleInputPassword1" readonly> 
                    </div>
                    <button type="submit" name="validate" value="'.$editeurs[$editeur_selected]->getID().'"class="btn btn-danger">Valider les modification</button> 
                    </form>
                ';
                
            ?>
        </div>
    </body>
</html>