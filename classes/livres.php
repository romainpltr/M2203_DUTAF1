<?php 

// Les auteurs peuvent exister mais ne pas avoir ecris de livres
class auteur {
    private $id; 
    private $f_name;
    private $l_name;
    private $age;
    private $nationalite;

    // Constructeur
    function __construct(){
       
    }
    
    public function getID(){
        return $this->id;
    }

    // Acceseur
    public function getFirstName(){
        return $this->f_name;
    }

    public function getLastName(){
        return $this->l_name;
    }

    public function getAge(){
        return $this->age;
    }

    public function getNationality(){
        return $this->nationalite;
    }

    // Mutateurs

    public function setID($id){
        $this->id = $id;
    }

    public function setFirstName($fname){
        $this->f_name = $fname;
    }

    public function setLastName($lname){
        $this->l_name = $lname;
    }

    public function setAge($age){
        $this->age = $age;
    }

    public function setNationality($nat){
        $this->nationalite = $nat;
    }

    // Function


}
// Les editeurs peuvent exister mais ne pas avoir editer les livres de la table
class editeur {
    
    private $id;
    private $name;
    private $country;
    private $telephone;

    public function __construct()
    {

    }

    public function getID(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getCountry(){
        return $this->country;
    }

    public function getTelephone(){
        return $this->telephone;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setCountry($country){
        $this->country = $country;
    }

    public function setTelephone($telephone){
        $this->telephone = $telephone;
    }
}
// Les livres existent seulement si leur auteurs existe, leur editeur peut etre connu, il ne peux y avoir de livre sans auteurs (dépendance de la classe auteur)
class album {

    private $editeur;
    private $auteur;
    private $isbn;
    private $title;
    private $serie;
    private $prix;
    private $id;
    private $id_editeur;
    private $id_auteur;

    // Fonction global
    public function __construct()
    {
        
    }

    public function newEditor() {
        $this->editeur = new editeur();
    }

    public function newAuteur() {
        $this->auteur = new auteur();
    }

    // Acceseur

    public function getISBN(){
        return $this->isbn;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getSerie(){
        return $this->serie;
    }

    public function getPrix(){
        return $this->prix;
    }

    public function getEditor(){
        return $this->editeur;
    }

    public function getAuteur(){
        return $this->auteur;
    }

    public function getID(){
        return $this->id;
    }
    
    public function getID_Editeur(){
        return $this->id_editeur;
    }

    public function getID_Auteur(){
        return $this->id_auteur;
    }

    // Mutateur

    public function setISBN($isbn){
        $this->isbn = $isbn;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setSerie($serie){
        $this->serie = $serie;
    }

    public function setPrix($prix){
        $this->prix = $prix;
    }

    public function setEditor($editeur){
        $this->editeur = $editeur;
    }

    public function setAuteur($auteur){
        $this->auteur = $auteur;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function setID_Auteur($id){
        $this->id_auteur = $id;
    }

    public function setID_Editeur($id){
        $this->id_editeur = $id;
    }
}


?>