<?php       
        include('../../classes/livres.php');
        include('../../functions/function_bdd.php');

        session_start();
        // Variables
        $num_id = $_GET['num_id']; // 
        $position_tableau_albums;
        $admin = 1;
   
        // Si la session exite alors on deserialise 
        if(!empty($_SESSION['albums'])){
            $albums = unserialize($_SESSION['albums']);
        }

        if(!empty($_SESSION['auteurs'])){
            $auteurs = unserialize($_SESSION['auteurs']);
        }

        if(!empty($_SESSION['editeurs'])){
            $editeurs = unserialize($_SESSION['editeurs']);
        }

        // Si aucune $_SESSION['albums'] existe. alors on la créer
        if(empty($albums) || empty($auteurs) || empty($editeurs)){
            $albums = array();
            $auteurs = array();
            $editeurs = array();
            $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
            $req = 'SELECT * from album';
            $res = $bdd->query($req);
            while($table_info = $res->fetch()){
                $album = new album();
                $album->setID($table_info['album_id']);
                $album->setID_Editeur($table_info['auteur_id_']);
                $album->setID_Auteur($table_info['editeur_id_']);
                $album->setISBN($table_info['album_isbn']);
                $album->setSerie($table_info['album_serie']);
                $album->setTitle($table_info['album_titre']);
                $album->setPrix($table_info['album_prix']);
                $albums[] = $album;
            }
    
            $res->closeCursor();
    
            $req = 'SELECT * from auteur';
            $res = $bdd->query($req);
            while($table_info = $res->fetch()){
                $auteur = new auteur();
                $auteur->setID($table_info['auteur_id']);
                $auteur->setAge($table_info['auteur_age']);
                $auteur->setFirstName($table_info['auteur_prenom']);
                $auteur->setLastName($table_info['auteur_nom']);
                $auteur->setNationality($table_info['auteur_nat']);
                $auteurs[] = $auteur;
            }
    
            $res->closeCursor();
    
            $req = 'SELECT * from editeur';
            $res = $bdd->query($req);
            while($table_info = $res->fetch()){
                $editeur = new editeur();
                $editeur->setID($table_info['editeur_id']);
                $editeur->setName($table_info['editeur_nom']);
                $editeur->setCountry($table_info['editeur_pays']);
                $editeur->setTelephone($table_info['editeur_tel']);
                $editeurs[] = $editeur;
            }
    
            $res->closeCursor();
        
            for($i= 0; $i < count($editeurs); $i++){
                for($i= 0; $i < count($auteurs); $i++){
                    for($a= 0; $a < count($albums); $a++){
                        if(isset($editeurs[$i])){
                            if($editeurs[$i]->getID() == $albums[$a]->getID_Editeur()){
                                $albums[$a]->setEditor($editeurs[$i]);
                            }
                        }
                        if(isset($auteurs[$i])){
                            if($auteurs[$i]->getID() == $albums[$a]->getID_Auteur()){
                                $albums[$a]->setAuteur($auteurs[$i]);
                            }
                        }
                    }
                }
            }
        }
        
        // On récupere l'indice de notre tableau désérializé pour récuperer les infos de notre objet par la suite
        if(!empty($_GET['num_id']) || $_GET['num_id'] == "0"){
            for($i = 0; $i < count($albums); $i++){
                
                if($albums[$i]->getID() == $num_id){
                    $position_tableau_albums = $i;
                }
            }
        }


        // On reserialize
        $_SESSION['albums'] = serialize($albums); // Tableau des albums contenant les auteurs et editeurs en fonction de leur id.
        $_SESSION['auteurs'] = serialize($auteurs);  // Tableau des auteurs 
        $_SESSION['editeurs'] = serialize($editeurs); // Tableau des éditeurs 

        // On affiche les infos de notre objet pour pouvoir le modifier


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
    </head>
    <body>
        <?php include '../../includes/header.php'; ?>
        <div class="container">
        <br>
        <form action='bd_update_valide.php' method="GET" >
            <div class="form-group">
                <label for="exampleInputEmail1">ISBN :</label>
                <input class="form-control" name="isbn" id="exampleInputEmail1" value="<?php  echo $albums[$position_tableau_albums]->getISBN(); ?>" aria-describedby="emailHelp">
             </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Titre :</label>
                <input class="form-control" name="title" id="exampleInputEmail1" value="<?php echo $albums[$position_tableau_albums]->getTitle(); ?>" aria-describedby="emailHelp">
             </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Série :</label>
                <input  class="form-control" name="series" value="<?php echo $albums[$position_tableau_albums]->getSerie(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Prix :</label>
                <input  class="form-control" name="price" value="<?php echo $albums[$position_tableau_albums]->getPrix(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                    <label for="exampleFormControlSelect1">Auteur</label>
                    <select class="form-control" name="auteur" id="exampleFormControlSelect1">
                    <?php 
                        for($i=0;$i<count($auteurs);$i++){
                            var_dump($auteurs);
                            if(!empty($auteurs[$i])){
                                if($auteurs[$i]->getID() == $albums[$position_tableau_albums]->getID_Auteur()){
                                    echo '<option value="'.$auteurs[$i]->getID().'"selected>'.$auteurs[$i]->getFirstName().' '.$auteurs[$i]->getLastName().'</option>';
                                }else{
                                    echo '<option value="'.$auteurs[$i]->getID().'">'.$auteurs[$i]->getFirstName().' '.$auteurs[$i]->getLastName().'</option>';
                                }
                            }
                        }

                        echo '<option value="-1"> Aucun Auteur</option>';
                    ?>
                    
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Editeur</label>
                    <select class="form-control" name="editeur" id="exampleFormControlSelect1">
                    <?php
                        for($i=0;$i<count($editeurs);$i++){ 
                            if(!empty($editeurs[$i])){              
                                if($editeurs[$i]->getID() == $albums[$position_tableau_albums]->getID_Editeur()){
                                    echo '<option selected value="'.$editeurs[$i]->getID().'"selected>'.$editeurs[$i]->getName().' </option>';
                                }else{
                                    echo '<option value="'.$editeurs[$i]->getID().'">'.$editeurs[$i]->getName().'</option>';
                                }
                            }
                        }
                        echo '<option value="-1"> Aucun Editeur</option>'; 
                    ?>
                    </select>
                </div>
            <button type="submit" name="idAlbum" value="<?php echo $position_tableau_albums ?>" class="btn btn-success">Modifier</button> 
            
            
            </form>
            <br>
            <a href="bd_gestion.php"><button class="btn btn-primary">Retour</button></a>
            <br>
            <br>
        </div>
    </body>
</html>

