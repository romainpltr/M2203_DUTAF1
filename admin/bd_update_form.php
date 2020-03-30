<?php 

        // Include classe livres
        include ('../functions/function_bdd.php');
        include('../classes/livres.php');
        include('../config_inc.php');
        

        // Variables

        $num_id;
        $admin = 1;
        $pos;

        // Si aucune $_SESSION['albums'] existe.

        if(empty($_SESSION['albums'])){
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

        // Si la session exite alors on deserialise 

        if(!empty($_SESSION['albums'])){
            $albums = unserialize($_SESSION['albums']);
        }
        
        // Si le num id = post => $num_id = id 
        !empty($_GET['num_id']) ?$num_id = $_GET['num_id']:""; ;

        if(!empty($pos)) {

            if(!empty($_GET['title'])){
                $albums[$pos]->setTitle($_GET['title']);
                
            }
            
            if(!empty($_GET['series'])){
                $albums[$pos]->setSerie($_GET['series']);
            }
            
            if(!empty($_GET['price'])){
                $albums[$pos]->setPrice($_GET['price']);
            }
            
            if(!empty($_GET['auteur'])){
                $album[$pos]->setID_Auteur($_GET['auteur']);
            }
            
            if(!empty($_GET['editeur'])){
                $album[$pos]->setID_Editeur($_GET['editeur']);
            }

            if(!empty($_GET['editeur']) && !empty($_GET['auteur'])){
                for($i= 0; $i < count($editeurs); $i++){
                    for($e = 0; $e < count($auteurs); $e++){
                        
                        if(isset($editeurs[$i])){
                            if($editeurs[$i]->getID() == $album->getID_Editeur()){
                                $album[$pos]->setEditor($editeurs[$i]);
                            }
                        }
                        if(isset($auteurs[$e])){
                            if($auteurs[$e]->getID() == $album->getID_Auteur()){
                                $album[$pos]->setAuteur($auteurs[$e]);
                            }
                        }
                    }
                }
            }  
        }

        for($i=0; $i < count($albums); $i++){
            if(!empty($albums[$i])){
                if(!empty($num_id) && $albums[$i]->getID() == $num_id){
                    $pos = $i;
                }
            }
        }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
    </head>
    <body>
        <?php include '../includes/header.php'; ?>
        <div class="container">
        <br>
        <form action="#" method="GET" >
            <div class="form-group">
                <label for="exampleInputEmail1">ISBN :</label>
                <input class="form-control" name="isbn" id="exampleInputEmail1" value="<?php echo $albums[$pos]->getISBN(); ?>" aria-describedby="emailHelp">
             </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Titre :</label>
                <input class="form-control" name="title" id="exampleInputEmail1" value="<?php echo $albums[$pos]->getTitle(); ?>" aria-describedby="emailHelp">
             </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Série :</label>
                <input  class="form-control" name="series" value="<?php echo $albums[$pos]->getSerie(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Prix :</label>
                <input  class="form-control" name="price" value="<?php echo $albums[$pos]->getPrix(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                    <label for="exampleFormControlSelect1">Auteur</label>
                    <select class="form-control" name="auteur" id="exampleFormControlSelect1">
                    <?php 
                    for($i=0;$i<count($auteurs);$i++){
                        if($auteurs[$i]->getID() == $albums[$pos]->getID_Auteur()){
                            echo '<option value="'.$auteurs[$i]->getID().'"selected>'.$auteurs[$i]->getFirstName().' '.$auteurs[$i]->getLastName().'</option>';
                        }else{
                            echo '<option value="'.$auteurs[$i]->getID().'">'.$auteurs[$i]->getFirstName().' '.$auteurs[$i]->getLastName().'</option>';
                        }
                    } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Editeur</label>
                    <select class="form-control" name="editeur" id="exampleFormControlSelect1">
                    <?php
                    for($i=0;$i<count($editeurs);$i++){               
                        if($editeurs[$i]->getID() == $albums[$pos]->getID_Editeur()){
                            echo '<option selected value="'.$editeurs[$i]->getID().'"selected>'.$editeurs[$i]->getName().' </option>';
                        }else{
                            echo '<option value="'.$editeurs[$i]->getID().'">'.$editeurs[$i]->getName().'</option>';
                        }
                    } ?>
                    </select>
                </div>
            <button type="submit" class="btn btn-success">Modifier</button> 
            
            
            </form>
            <br>
            <a href="bd_gestion.php"><button class="btn btn-primary">Retour</button></a>
            <br>
            <br>
        </div>
    </body>
</html>