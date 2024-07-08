<?php   
  include("menuprof.php");

 
?>


  



<!DOCTYPE html>
<html>  
<head>
    <
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="menuprof.css">
    <link rel="stylesheet" type="text/css" href="style_chefde.css">
</head>
<body>

      <section>
      
      <div id="id2">
<form  action="" method="post">
<div id="go">
    <p style="color:black" ><b>le responsable:</b><br></p> <input type="texte" name="Nom" value="<?php if (!isset ($_GET['modifer']) && (!isset($_POST['enregistré'])))  echo $_GET['nom_prof'];  ?>">

    <p style="color:black" ><b>le module:</b><input type="texte" name="module" value="<?php if (!isset ($_GET['modifer']) && (!isset($_POST['enregistré'])))  echo $_GET['nom_mod'];?>" >
   
    <p style="color:black" ><b>enregistré</b></p>
<button  name="enregistré" value="enregistré">enregistré</button>  
<div id="go">

</from>
   </div>
   

   


<?php
if(isset($_POST['enregistré'])&&!empty($_POST['Nom'])&&!empty($_POST['module']))
     {
try{
    $db= new PDO(
        'mysql:host=localhost;port=3306; dbname=eservice;charset=utf8',
        'root',
        '');
           
       
    }
    catch(Exception $e)
    {
      // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
            
    }

 
    $Nom=$_POST["Nom"];
    $module =$_POST["module"];
   
 
 
 
    //EXTRETE DE CHAMPS
    
 
   
    $user="SELECT id_prof FROM  professeur  WHERE nom_prof='$Nom'";
    $repons=$db->query($user); 
    $prof = $repons->fetch();
 
 
    $req="SELECT id_mod FROM  module WHERE nom_mod='$module'";
    $reponse=$db->query($req); 
    $mod = $reponse->fetch();
   //INSERTION DES CHAMP
 // Ecriture de la requête
 
 $sqlQuery ="UPDATE  `module` SET responsable='$prof[id_prof]' WHERE id_mod='$mod[id_mod]'";
 
 // Préparation
        $insertRecipe = $db->prepare($sqlQuery);
 // Exécution ! La recette est maintenant en base de données
         $insertRecipe->execute();
        if(isset($insertRecipe) ) 
         { echo "<script>";
        echo "window.alert('Bien enregistré');";
        echo "</script>";
         }
         
}
  
  
  ?>
 
</section>
</body>



</html>