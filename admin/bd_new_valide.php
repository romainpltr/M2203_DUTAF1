<?php 

//AUTEUR
if(!empty($_GET['a_prenom']) || !empty($_GET['a_name']) || 
!empty($_GET['a_nationalite']) || !empty($_GET['a_age'])){
    
}
//EDITEUR
else if(!empty($_GET['e_name']) || 
!empty($_GET['e_tel']) || !empty($_GET['e_country'])){
    
}

//LIVRE
else if(!empty($_GET['auteur'])){
    var_dump($_GET['auteur']);
}

?>