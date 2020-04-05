

<?php 
    include('../../classes/livres.php');
    include('../../functions/function_bdd.php');
    session_start();    
    $idAuteur;
    if(!empty($_SESSION['auteurs'])){
        $auteurs = unserialize($_SESSION['auteurs']);
    }

    for($i=0; $i <= count($auteurs); $i++){
        if(!empty($auteurs[$i])){
            if($auteurs[$i]->getID() == $_GET['idAuteur']){ 
                $auteurs_Selected = $i;
            }
        }
    }

    
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
         
?>