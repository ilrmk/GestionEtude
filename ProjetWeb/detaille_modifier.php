<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Modifier Détaille</title>
    <style>
    section{
        color: black;
    }
     a{
         text-decoration:none}
    button{
        margin: 20px;
      
    }
    </style>
</head>
<body>
    <?php
    if(!isset($_SESSION["submit"])):
        include_once('login.php'); 
        endif;
         
        ?>
        
        <?php
        if(isset($_SESSION["submit"])):
        
        include_once('menuprof.php');
        ?>
        
        <?php
if (isset($_POST['enregestrer'])) {
    $nom = $_POST['nom_m'];
    $volume = $_POST['volume_horaire'];
    $enseignant = $_POST['id_e'];
    $id = $_SESSION['id_m'];
    
    try {
        $db = new PDO(
            'mysql:host=localhost;port=3307;dbname=eservice;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        );
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    if ($enseignant == "autre") {
        $nom_v = $_POST['nom_v'];
        $email_v = $_POST['email_v'];
        
        $insere_v = $db->prepare("INSERT INTO `vacataire` (`id`, `nom`, `mail`) VALUES (NULL, :nom_v, :email_v)");
        $insere_v->bindParam(':nom_v', $nom_v);
        $insere_v->bindParam(':email_v', $email_v);
        
        $insere_v->execute();
        
        $enseignant = $db->lastInsertId();
  
    
    $vacataires = $db->prepare("SELECT * FROM `vacataire` WHERE nom=:nom_v AND mail=:email_v");
    $vacataires->bindParam(':nom_v', $nom_v);
    $vacataires->bindParam(':email_v', $email_v);
    $vacataires->execute();
    $vacataires = $vacataires->fetchAll();
   
    $enseignant = $vacataires[0]['id'];
    }
   
    $modifier_module = $db->prepare("UPDATE module SET nom_mod='$nom', volume_horaire='$volume', responsable='$enseignant' WHERE id_mod='$id'");
    
   
    
    try {
        $modifier_module->execute();
        echo "La requête a été exécutée avec succès";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<section>
<h1 style="color: black;">Les informations sont bien enregistrées !</h1>

<h3 style="color: black;">Les nouvelles informations du module sont :</h3>

<?php echo "Nom de module : " . $nom . "<br> Volume horaire : " . $volume . "<br> L'enseignant est : " . $enseignant; ?>
  <br> <button ><a href="affiche_gestion_module.php">Retour</a></button>
   <?php  endif; ?>
  
 </section>   
</body>
</html>