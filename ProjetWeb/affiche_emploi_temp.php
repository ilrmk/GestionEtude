<?php session_start();

if(!isset($_SESSION["submit"])):
include_once('login.php'); 

 

else:

include_once('menuprof.php');
if(isset($_GET['semestre'])):
   
   $semestre =$_GET['semestre'];
try{
    $db= new PDO(
        'mysql:host=localhost;port=3307; dbname=ensah;charset=utf8',
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


   $seance=$db->prepare('SELECT * FROM seance 
    LEFT JOIN module on module.id=seance.nom_module
    LEFT JOIN prof on prof.id=seance.nom_prof
    where seance.nom_filiere=:filiere and seance.semestre=:semestre  
   ');
   $seance->bindValue(':semestre', $semestre);
   $seance->bindValue(':filiere', $_SESSION['id_filiere']);
   $seance->execute();
   $seances=$seance->fetchAll();
  

   $jour=$db->prepare('SELECT * FROM jour ');
            $jour->execute();
            $jour=$jour->fetchAll();


    $lundi=$db->prepare("SELECT * FROM seance 
    LEFT JOIN module on module.id=seance.nom_module
    LEFT JOIN prof on prof.id=seance.nom_prof
    where seance.nom_filiere=1 and seance.semestre=$semestre and jour='Lundi'"); 
    $lundi->execute();
    $lundi=$lundi->fetchAll();
    
    
    $mardi=$db->prepare("SELECT * FROM seance 
    LEFT JOIN module on module.id=seance.nom_module
    LEFT JOIN prof on prof.id=seance.nom_prof
    where seance.nom_filiere=1 and seance.semestre=$semestre and jour='Mardi'"); 
    $mardi->execute();
    $mardi=$mardi->fetchAll();
    
    $mercredi=$db->prepare("SELECT * FROM seance 
    LEFT JOIN module on module.id=seance.nom_module
    LEFT JOIN prof on prof.id=seance.nom_prof
    where seance.nom_filiere=1 and seance.semestre=$semestre and jour='Mercredi'"); 
    $mercredi->execute();
    $mercredi=$mercredi->fetchAll();
   
    $jeudi=$db->prepare("SELECT * FROM seance 
    LEFT JOIN module on module.id=seance.nom_module
    LEFT JOIN prof on prof.id=seance.nom_prof
    where seance.nom_filiere=1 and seance.semestre=$semestre and jour='Jeudi'"); 
    $jeudi->execute();
    $jeudi=$jeudi->fetchAll();


    $vendredi=$db->prepare("SELECT * FROM seance 
    LEFT JOIN module on module.id=seance.nom_module
    LEFT JOIN prof on prof.id=seance.nom_prof
    where seance.nom_filiere=1 and seance.semestre=$semestre and jour='Vendredi'"); 
    $vendredi->execute();
    $vendredi=$vendredi->fetchAll();



    $samedi=$db->prepare("SELECT * FROM seance 
    LEFT JOIN module on module.id=seance.nom_module
    LEFT JOIN prof on prof.id=seance.nom_prof
    where seance.nom_filiere=1 and seance.semestre=$semestre and jour='Samedi'"); 
    $samedi->execute();
    $samedi=$samedi->fetchAll();
    
      

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         table{
            border-collapse: collapse;
            margin-top: 50px;
            margin-left: 40px;
            margin-right: 40px;
            background-color:beige;
            
        }
        
         th{
            background-color:blueviolet;
            
            border: 1px black solid;
            
        }
        
        td{
            color: black;
            text-align: center;
            height: 50px;
            border: 1px black solid;
         }
         .my-button {
  background-color: blueviolet; 
  color: white; 
  border: none; 
  padding: 10px 20px; 
  text-align: center; /* Alignement du texte */
  text-decoration: none; /* Supprime la décoration du texte */
  display: inline-block; /* Affichage en ligne */
  font-size: 16px; /* Taille de la police */
  cursor: pointer; /* Curseur de souris en forme de main */
  border-radius: 4px; /* Arrondi des bords */
}
.buttom{
    display: flex;
    justify-content: space-between;
    margin: 30px;
}
    </style>
</head>
<body>
    <h2 style="color: black;">Semestre: S<?php echo $semestre?><br>Niveau:<?php echo $_GET['niveau']?>
    </h2>
    
    <table>
    <tr>
        <th></th>
        <th><span>8h30</span><span>9h30</span></th>
        <th><span>9h30</span><span>10h30</span></th>
        <th><span>10h30</span><span>11h30</span></th>
        <th><span>11h30</span><span>12h30</span></th>
        <th></th>
        <th><span>14h30</span><span>15h30</span></th>
        <th><span>15h30</span><span>16h30</span></th>
        <th><span>16h30</span><span>17h30</span></th>
        <th><span>17h30</span><span>18h30</span></th>
    </tr> 
    <?php foreach ($jour as $val): ?>
        <tr>
        <td><?php echo $val['nom_jour']; ?></td>
       
        <?php for ($i = 0; $i < 9; $i++): ?>
                <td>
                    <?php
                    $heureDebut = strtotime('08:30:00');
                    $heureFin = strtotime('09:30:00');
                    $heureCol = strtotime('08:30:00') + ($i * 3600);

                    foreach ($seances as $seance) {
                        $seanceDebut = strtotime($seance['heure_debut']);
                        $seanceFin = strtotime($seance['heure_fin']);

                        if ($seance['jour'] == $val['nom_jour'] && $heureCol >= $seanceDebut && $heureCol < $seanceFin) {
                            echo $seance['nom_m'] ."<br>".$seance['full_name'];
                            break;
                        }
                    }
                    ?>
                </td>
            <?php endfor; ?>
        </tr>
    <?php endforeach; ?>
</table>
   <div class="buttom">
    <a href="modifier_emploi_de_temp.php?semestre=<?php echo $semestre;?>"><button class="my-button">Modifier</button></a>
    <a href="#"><button class="my-button">Telecharger</button></a>
    <a href="#"><button class="my-button">Exporter en Excel</button></a>
    </div>
</body>
</html>
<?php endif; ?>
<?php endif; ?>
