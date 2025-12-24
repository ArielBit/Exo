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
    $nom= trim(filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS));
    $prenom= trim(filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS ));
    $nu = trim(filter_input(INPUT_POST, 'nu', FILTER_SANITIZE_SPECIAL_CHARS ));
    $email =trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $mdp =trim($_POST['mdp']?? '');
    $mdpc =trim($_POST['mdpc']?? '');

    //Vérification de l'existence des données
    if(empty($nom) || empty($prenom) || empty($nu) || empty($email) || empty($mdp) || empty($mdpc)){
      die('Champ vide.');
    }
  //Vérification de la validité de l'email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      die('Email non valide.');
    }
  if($mdpc !==$mdp){
    die('Mot de passs différents.');
  }
  
    
  $stmt= $connect->prepare('SELECT COUNT(*) FROM db WHERE email =:email OR nom_utilisateur =:nu ');
$stmt->bindParam(':email', $email);
$stmt->bindParam(':nu', $nu);
    $stmt->execute();
$count=$stmt->fetchColumn();
if($count >0){
  echo "Compte Existant.";
}else{
  //Hachage du Mot de passe
  $mdpHash= password_hash($mdp, PASSWORD_DEFAULT);
  //Insertion des nouvelles données
  $stmt=$connect->prepare('INSERT INTO db(nom, prenom, nom_utilisateur, email, mot_de_passe) VALUES(:nom, :prenom, :nu, :email, :mdp)');
  if($stmt->execute([ ':nom'=>$nom,   ':prenom'=>$prenom,  ':nu'=>$nu,  ':email'=>$email,  ':mdp'=>$mdpHash])){
    header('Location: Confirmation.html');
    exit();
  }else{
    echo "Erreur lors de l'insertion des données.";
  }
}

} 
}catch(PDOException $e){
  echo "Erreur de Connexion." . $e->getMessage();
}
?>
