

<?php 
    include('../../classes/livres.php');
    include('../../functions/function_bdd.php');
    session_start();    
    $idEditeur;
    if(!empty($_SESSION['editeurs'])){
        $editeurs = unserialize($_SESSION['editeurs']);
    }

    for($i=0; $i <= count($editeurs); $i++){
        if(!empty($editeurs[$i])){
            if($editeurs[$i]->getID() == $_GET['idEditeur']){ 
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
         
?>