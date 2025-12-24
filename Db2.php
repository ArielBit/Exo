<?php
//Coordonnées du serveur Sql
$dbname="exo";
$host="127.0.1.0";
$port=3300;
$username="root";
$password="";

//Connexion au serveur Php
try{
$connect= new PDO("mysql:dbname=$dbname; host=$host; port=$port; charset=utf8mb4", $username, $password);
$connect-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Vérifications des données par la methode POST
  if($_SERVER["REQUEST_METHOD"] ==="POST"){
    

} 
}catch(PDOException $e){
  echo "Erreur de Connexion." . $e->getMessage();
}
?>
