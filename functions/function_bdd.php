<?php 
include('../../config_inc.php');

function BDD_Select($req, $res){
    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $res = $bdd->prepare($req);
    $res->execute();
    return $res;
}

function BDD_Add($req){
    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $res = $bdd->prepare($req);
    $res->execute();
    
    return $bdd->lastInsertId();

}

function BDD_Del($req){
    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $res = $bdd->prepare($req);
    $res->execute();
    
}

function BDD_Update($req, $data){
    $data = $data;
    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $res = $bdd->prepare($req);
    $res->execute($data);
}


?>