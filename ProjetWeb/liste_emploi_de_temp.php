<?php session_start();

if(!isset($_SESSION["submit"])):
include_once('login.php'); 

 

else:

include_once('menuprof.php');


try{
    $db= new PDO(
        'mysql:host=localhost;port=3306; dbname=eservice;charset=utf8',
        'root',
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION], //Pour afficher des détails sur l'erreur, il faut activer les erreurs lors de la connexion à la base de données via PDO.
    );
    
    }
    catch(Exception $e)
    {
      // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
            
    }


   $seance=$db->prepare("SELECT * FROM seance where nom_filiere=:filiere");
   $seance->bindValue(':filiere', $_SESSION['id_filiere']);
   
   $seance->execute();

   $seance_info=$seance->fetchAll(); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <style>
        h1{
            color:black;

        }
        h3{
            background-color:aquamarine;
            width: 30%;
            padding: 10px;
            margin-left: 10px;
        }
        table{
            border-collapse: collapse;
            margin-left: 30px;
            margin-right: 30px;
            background-color:beige;
            
        }
        
         th{
            background-color:blueviolet;
            padding: 10px;
            
        }
        tr:nth-child(2n+1) {
            background-color: azure;
           }
        td{
            color: black;
             text-align: center;
            height: 50px;
         }
         a{
            margin-left:20px;
         }

         button {
            margin-left: 20px;
  background-color:aquamarine; 
  color: white; 
  border: none; 
  padding: 10px 20px; 
  text-align: center; /* Alignement du texte */
   /* Supprime la décoration du texte */
  display: inline-block; /* Affichage en ligne */
  font-size: 16px; /* Taille de la police */
  cursor: pointer; /* Curseur de souris en forme de main */
  border-radius: 4px; /* Arrondi des bords */
}
button a{
    text-decoration: none; 
}

    </style>
</head>
<body>
    <h1>Emplois du temps</h1>
    <h3>Année Universitaire : 2022/2023<br>
        Semestre : printemps</h3>

<table>
    <tr>
        <th>Classe</th>
        
        <th>Action</th>
    </tr>
    
    
     <tr>
        <?php foreach($seance_info as $val):?>
        <?php if($val['semestre']==1 || $val['semestre']==2): ?>
        <td><a href="affiche_emploi_temp.php?semestre=<?php echo $val['semestre']; ?>&niveau=GI1">GI1</a></td>
        <td>
        <button><a href="supprimer_emploi_de_temp.php?semestre=<?php echo $val['semestre']; ?>">supprimer</a></button>
            <button><a href="modifier_emploi_de_temp.php?semestre=<?php echo $val['semestre'];?>">Modifier</a></button>
        </td>
        <?php break; endif ?>
        <?php endforeach; ?>
     </tr> 
      <tr>
      <?php foreach($seance_info as $val):?>
        <?php if($val['semestre']==3 || $val['semestre']==4): ?>
        <td><a href="affiche_emploi_temp.php?semestre=<?php echo $val['semestre']; ?>&niveau=GI2">GI2</a></td>
        <td><button><a href="supprimer_emploi_de_temp.php?semestre=<?php echo $val['semestre']; ?>">supprimer</a></button>
            <button><a href="modifier_emploi_de_temp.php?semestre=<?php echo $val['semestre']; ?>">Modifier</a></button></td>
        
        <?php break; endif ?>
        <?php endforeach; ?>
      </tr> 
      <tr>
        <?php foreach($seance_info as $val):?>
        <?php if($val['semestre']==5 || $val['semestre']==6): ?>
        <td><a href="affiche_emploi_temp.php?semestre=<?php echo $val['semestre']; ?>&niveau=GI3">GI3</a></td>
        <td>
            <button><a href="supprimer_emploi_de_temp.php?semestre=<?php echo $val['semestre']; ?>">supprimer</a></button>
            <button><a href="modifier_emploi_de_temp.php?semestre=<?php echo $val['semestre']; ?>">Modifier</a></button>
        </td>
        <?php break; endif ?>
        <?php endforeach; ?>
      </tr>
   
</table>
</body>
</html>



<?php 
endif;
?>