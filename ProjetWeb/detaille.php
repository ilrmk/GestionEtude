<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Détaille</title>
    <style>

        section{
            color: black;
            margin: 30px;
            display: flex;
            margin-left: 150px;
            
        }
        article{
            flex:1;
        }
        aside{
            flex:1;
        }
       h1{
        font-size: 40px;
        color: black;
        
       }
        span{
            color:black;
        }
        
      
        .tab table{
            border-collapse: collapse;
            margin-bottom: 5px;
            margin-left: 5px;
            padding: 5px;
        }
        .tab th{
            
          background-image:url(mesh-1430107_640.webp);
         
          color:black;
          border-top:2px solid  rgb(145, 179, 247) ;
        margin-top: 4px;
        padding: 5px;
        text-align: center;
        }
        .tab tr{
            
    border-top:2px solid  rgb(240, 237, 237); ;
  
  color:black;
  font-size: 20px;
  
  height: 40px;
  background-color:white;
    padding-left: 10px;
    

         }
         .tab td{
            padding: 10px;
            text-align: center;

         }

        .tab tr:nth-child(even){
 
         background-color: rgb(216, 227, 248);
        }

        .texte{
            color: black;
            text-align: justify;
            margin: 5px;
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
        
         
try{
    $db= new PDO(
        'mysql:host=localhost;port=3307; dbname=eservice;charset=utf8',
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
    
    
    
    $filiere=$db->prepare('SELECT id_fil as id_filiere,nom_fil,descriptif_fil,id_prof as id_coord,nom_prof FROM filiere INNER JOIN professeur ON professeur.id_prof=filiere.coordinateur ');
    $filiere->execute();
    $infof=$filiere->fetchAll(); 
    $module=$db->prepare('SELECT module.id_mod, module.nom_mod, module.volume_horaire, filiere.nom_fil, p2.nom_prof AS enseignant 
    FROM module 
    INNER JOIN filiere ON module.id_fil = filiere.id_fil 
    
    LEFT JOIN professeur p2 ON module.responsable = p2.id_prof;');
    $module->execute();
    $infom=$module->fetchAll(); 
     
    ?>
    
   <section>
    <article>
    <?foreach($infof as $val):?>
        <?php if($val['id_coord']==$_SESSION['id']):
          $n=$val['nom_fil'] ;
           ?>
            
                 
     <h1><?php echo $val['nom_fil'] ?></h1>
     
     <h2>Descriptif de filière</h2>
     <p class="texte"> <?php echo $val['descriptif_fil']?> </p>
    
     <?php endif; ?>
     <?php endforeach; ?>

     <h2>Module et cours</h2>
     <div class="tab">

     
    <table >
        <tr>
            <th>Module</th>
            <th>Sous Module</th>
            <th>Volume horaire</th>
           
            <th>Enseignant/vacataire</th>
            <th>Action</th>
        </tr>
     <?foreach($infom as $val):?>
        <?php if($val['nom_fil']==$n):?>
          <tr>
            <td><?php echo $val['nom_mod'] ?></td>
            <td>--</td>
            <td><?php echo $val['volume_horaire'] ?></td>
            
            <td><?php echo $val['enseignant'] ?></td>
            <td>
                <form action="gestion_module.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $val['id_mod']; ?>">
                <input type="submit" name="modifier" value="modifier">
                </form>
            </td>
          
          </tr>
            
          
     <?php endif; ?>
     <?php endforeach; ?>
    </table>
     </div>
     <div class="button">
    
    
    
   </div>
   
</article>

   </section>
   <?php  endif; ?>
    
</body>
</html>