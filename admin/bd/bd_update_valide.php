<?php 
    include('../../classes/livres.php');
    include('../../functions/function_bdd.php');
    session_start();    
    $album_selected;
    $auteur;
    $editeur;
    
    if(!empty($_SESSION['albums'])){
        $albums = unserialize($_SESSION['albums']);
    } 
    
    if(!empty($_SESSION['editeurs'])){
        $editeurs = unserialize($_SESSION['editeurs']);
    }
    
    if(!empty($_SESSION['auteurs'])){
        $auteurs = unserialize($_SESSION['auteurs']);
    }

    // POSTION DANS LE TABLEAU ALBUM = ALBUM SELECTIONNER
    if(!empty($_GET['idAlbum']) || $_GET['idAlbum'] == "0"){
        // POUR PLUS DE SECURITER FAIRE LES VERIFICATIONS HERE
        $album_selected = $_GET['idAlbum'];
    }

    if(!empty($_GET['title'])){
        $albums[$album_selected]->setTitle($_GET['title']);    
    }
    
    if(!empty($_GET['series'])){
        $albums[$album_selected]->setSerie($_GET['series']);
    }
    
    if(!empty($_GET['price'])){
        $albums[$album_selected]->setPrix($_GET['price']);
    }


    if(!empty($_GET['auteur'])){
        if($albums[$album_selected]->getID_Auteur() != $_GET['auteur']){
            $albums[$album_selected]->setID_Auteur($_GET['auteur']);
            for($e = 0; $e < count($auteurs); $e++){
                if(!empty($auteurs[$e])){
                    if($auteurs[$e]->getID() == $albums[$album_selected]->getID_Auteur()){
                        $albums[$album_selected]->setAuteur($auteurs[$e]);
                    }
                }
            }
        }
    }

    if($_GET['auteur'] == '-1'){
        $auteur = "-1";
        $albums[$album_selected]->setAuteur(null);
        $albums[$album_selected]->setID_Auteur(null);
    }else{
        $auteur = $_GET['auteur'];
    }

    

    if(!empty($_GET['editeur'])){
        if($albums[$album_selected]->getID_Editeur() != $_GET['editeur']){
            $albums[$album_selected]->setID_Editeur($_GET['editeur']);
            for($i= 0; $i < count($editeurs); $i++){
                if(!empty($editeurs[$i])){
                    if($editeurs[$i]->getID() == $albums[$album_selected]->getID_Editeur()){
                        $albums[$album_selected]->setEditor($editeurs[$i]);
                    }
                }
            }
        }
    }
    
    if($_GET['editeur'] == "-1"){
        $editeur = -1;
        $albums[$album_selected]->setID_Editeur(null);
        $albums[$album_selected]->setEditor(null);
    }else{
        $editeur = $_GET['editeur'];
    }

    $idAlbum = $albums[$album_selected]->getID();

        $data = [
            'isbn' => $_GET['isbn'],
            'title' => $_GET['title'],
            'series' => $_GET['series'],
            'price' => $_GET['price'],
            'auteur' => $auteur,
            'editeur' => $editeur,
            'id' => $idAlbum
        ];

        

        $req = "UPDATE album SET album_isbn=:isbn, album_serie=:series, album_titre=:title, album_prix=:price, auteur_id_=:auteur, editeur_id_=:editeur WHERE album_id=:id";
        BDD_Update($req, $data);
        
        $_SESSION['erreurs']['success'] = '<br><div class="alert alert-success" role="alert">
        Vous venez de modifier l\'album : '.$albums[$album_selected]->getTitle().'  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
        
        header('Location: bd_gestion.php');
         
        $_SESSION['albums'] = serialize($albums); // Tableau des albums contenant les auteurs et editeurs en fonction de leur id.
        $_SESSION['auteurs'] = serialize($auteurs);  // Tableau des auteurs 
        $_SESSION['editeurs'] = serialize($editeurs); // Tableau des éditeurs 





?>