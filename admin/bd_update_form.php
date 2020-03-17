<?php 

        // Include classe livres
        include('../classes/livres.php');
        include('../config_inc.php');


        // Variables

        $num_id;
        $admin = 1;

        // Si aucune $_SESSION['albums'] existe.

        if(empty($_SESSION['albums'])){
            $albums = array();
            $auteurs = array();
            $editeurs = array();
            $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
            $req = 'SELECT * from auteur INNER JOIN album ON auteur.auteur_id = album.auteur_id_ INNER JOIN editeur ON album.editeur_id_ = editeur.editeur_id';
            $res = $bdd->query($req);
        
            while($table_info = $res->fetch()){
            
            $album = new album();
            $album->newAuteur();
            $album->getAuteur()->setID($table_info['auteur_id']);
            $album->getAuteur()->setAge($table_info['auteur_age']);
            $album->getAuteur()->setFirstName($table_info['auteur_prenom']);
            $album->getAuteur()->setLastName($table_info['auteur_nom']);
            $album->getAuteur()->setNationality($table_info['auteur_nat']);
        
            $album->setID($table_info['album_id']);
            $album->setISBN($table_info['album_isbn']);
            $album->setSerie($table_info['album_serie']);
            $album->setTitle($table_info['album_titre']);
            $album->setPrix($table_info['album_prix']);
            
            $album->newEditor();
            $album->getEditor()->setID($table_info['editeur_id']);
            $album->getEditor()->setName($table_info['editeur_nom']);
            $album->getEditor()->setCountry($table_info['editeur_pays']);
            $album->getEditor()->setTelephone($table_info['editeur_tel']);
            $albums[] = $album;
            }
        }

        // Si la session exite alors on deserialise 

        if(!empty($_SESSION['albums'])){
            $albums = unserialize($_SESSION['albums']);
        }
        
        // Si le num id = post => $num_id = id 
        !empty($_GET['num_id']) ?$num_id = $_GET['num_id']:""; ;

        if(!empty($pos) && (!empty($_POST['title']) ||  !empty($_POST['series']) || 
        !empty($_POST['price']) || !empty($_POST['f_name']) || 
        !empty($_POST['l_name']) || !empty($_POST['natonality']) || 
        !empty($_POST['age']) || !empty($_POST['editor_name']) || 
        !empty($_POST['country']) || !empty($_POST['tel']))){
            if($_POST['country']){
                $albums[$pos]->getEditor()->setCountry($_POST['country']);
            }else if(!empty($_POST['title'])){
                $albums[$pos]->setTitle($_POST['title']);
            }else if(!empty($_POST['series'])){
                $albums[$pos]->setSerie($_POST['series']);
            }else if(!empty($_POST['price'])){
                $albums[$pos]->setPrice($_POST['price']);
            }else if(!empty($_POST['f_name'])){
                $albums[$pos]->getAuteur()->setFirstName($_POST['f_name']);
            }else if(!empty($_POST['l_name'])){
                $albums[$pos]->getAuteur()->setLastName($_POST['l_name']);
            }else if(!empty($_POST['nationality'])){
                $albums[$pos]->getAuteur()->setNationality($_POST['series']);
            }else if(!empty($_POST['age'])){
                $albums[$pos]->getAuteur()->setAge($_POST['series']);
            }else if(!empty($_POST['editor_name'])){
                $albums[$pos]->getEditor()->setName($_POST['series']);
            }else if(!empty($_POST['tel'])){
                $albums[$pos]->getEditor()->setTelephone($_POST['tel']);
            }


            $req = 'UPDATE album, editeur, auteur SET album.
            
            album_id='.$albums[$pos]->getID().'AND editeur.editeur_id = '.$albums[$pos]->getEditeur()->getID().' AND auteur.auteur_id = '.$albums[$pos]->getAuteur()->getID();
            $res = $bdd->query($req);
            
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
                <label for="exampleInputPassword1">Prénom de l'auteur :</label>
                <input  class="form-control" name="f_name" value="<?php echo $albums[$pos]->getAuteur()->getFirstName(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Nom de l'auteur :</label>
                <input  class="form-control" name="l_name" value="<?php echo $albums[$pos]->getAuteur()->getLastName(); ?> " id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Nationalité de l'auteur :</label>
                <input  class="form-control" name="nationality" value="<?php echo $albums[$pos]->getAuteur()->getNationality(); ?> " id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Age de l'auteur:</label>
                <input  class="form-control" name="age" value="<?php echo $albums[$pos]->getAuteur()->getAge(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Nom de l'editeur :</label>
                <input class="form-control" name="editor_name" value="<?php echo $albums[$pos]->getEditor()->getName(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Pays de l'editeur :</label>
                <input class="form-control"  name="country" value="<?php echo $albums[$pos]->getEditor()->getCountry(); ?>" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Téléphone de l'editeur :</label>
                <input class="form-control" name="tel" value="<?php echo $albums[$pos]->getEditor()->getTelephone(); ?>" id="exampleInputPassword1">
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