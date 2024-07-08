<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         .continu{
            display: flex;

         }
         .module_ensiegnant{
            flex: 0.5;
            overflow: scroll;
            height: 450px;
            margin-left: 50px;
         }

         .table{
            flex: 1.5;
            margin-right: 30px;
            overflow: scroll;
         }
        
         body> form{
           display: flex;
           justify-content: center;
           padding: 5px;
          
         }
         select{
            margin-left: 30px;
            margin-right: 30px;

         }

         .tab table{
            border-collapse: collapse;
            margin-left: 30px;
            
            width: 100%;
        }
        .tab th{
            
          border: 2px black solid;
          color: black;
          background-color: azure;
         
         
        }
       
         .tab td{
            color: black;
             text-align: center;
            border: 2px black solid;
            height: 50px;
         }

        .tab tr td:nth-child(1) {
            background-color: azure;
           }
         
        
        .module_ensiegnant table{
            border-collapse: collapse;
            margin-right: 40px;
        }

        .module_ensiegnant table th{
            background-color:blueviolet;
            padding: 10px;
            
        }
        .module_ensiegnant table td{
            background-color:beige;
            padding: 10px;
        }

        .module_ensiegnant table tr{
            border: 2px solid black;
        }

       

    </style>
</head>
<body>
    <?php
        if(!isset($_SESSION["submit"])):
        include_once('login.php'); 
       
         
  
        else:
        
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

            $module=$db->prepare('SELECT id_mod,nom_mod,semestre,id_prof AS id_enseignant  ,nom_prof AS nom_enseignant
                FROM module 
               LEFT JOIN professeur  ON module.responsable = professeur.id_prof where id_fil=:filiere;');
            $module->bindValue(':filiere', $_SESSION['id_filiere']);
            $module->execute();
            $infom=$module->fetchAll(); 

            $jour=$db->prepare('SELECT * FROM jour ');
            $jour->execute();
            $jour=$jour->fetchAll();

    ?>

     <h1 style="color: black; margin-bottom:20px">Gestion des Emplois de temps</h1>

     <form action="gestion_emploi_de_temp.php" method="POST">
    
    <select name="semestre" >
        <option value=""></option>
        <option value="1" >semestre 1</option>
        <option value="2">semestre 2</option>
        <option value="3">semestre 3</option>
        <option value="4">semestre 4</option>
        <option value="5">semestre 5</option>
    </select>
     <input type="submit" name="aller" value="filtrer">

    </form>
    <div class="continu">

    <section class="module_ensiegnant">
       
     <table >
        <tr ><th >Liste des modules avec leur enseignant</th></tr>
        <?php if($_POST['semestre']=="" || !isset($_POST['aller'])): ?>
         <?php foreach($infom as $val): ?>
        <tr ><td style="color: black;" ><span draggable="true" class="ms"><?php echo $val['nom_mod']?> </span><?php echo"<br>"?>  <span draggable="true" class="ps"> <?php echo $val['nom_enseignant'] ?></span></td></tr>
         <?php endforeach; ?>
         <?php else: 
                  $_SESSION['semestre']=$_POST['semestre'];
                  $_SESSION['aller']=$_POST['aller'];
                  ?>
                
                <?php foreach($infom as $val): ?>
                    <?php if($val['semestre']==$_POST['semestre']): ?>
                        <tr ><td style="color: black;" ><span draggable="true" class="ms"><?php echo $val['nom_mod']?> </span><?php echo"<br>"?>  <span draggable="true" class="ps"> <?php echo $val['nom_enseignant'] ?></span></td></tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                

         <?php endif; ?>
     </table>
   
   



    </section>

    <section class="table">
    
    <form action="traitement_emploi.php" method="post">
    <input type="hidden" name="nom_filiere" value="<?php echo $_SESSION['id_filiere']; ?>">
    <input type="hidden" name="semestre" value="<?php echo $_POST['semestre']; ?>">
    <div class="tab">
    <table >
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

        <?php $i=0; foreach($jour as $val): ?>
            <tr>
                <td><?php echo $val['nom_jour'] ?></td>
               
                
                
 <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="08:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="09:30:00">

                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" >
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="09:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="10:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" >
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="10:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="11:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" >
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="11:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="12:30:00">
                </td>
                <td></td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" >
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="14:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="15:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" >
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="15:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="16:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="16:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="17:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" >
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="17:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="18:30:00">
                </td>
            
            </tr>
        <?php $i++; endforeach; ?>    
    </table>
    </div>
    </section>
    </div>
    <div style="display: flex; margin:10px;justify-content:right">
     <input type="submit" name="enregestrer" value="Enregestrer" style="margin-right: 20px;" >
     <input type="reset"  value="Réiniliser" >
    </div>
    </form>
    <a href="liste_emploi_de_temp.php" style="color:blueviolet; margin:20px;text-align:center">Liste des Emploi de temps modifier</a>
    
    

<?php  endif; ?>
<script type="text/javascript">

var modules = document.getElementsByClassName("ms");

var profs=document.getElementsByClassName("ps");
for (var i = 0; i < modules.length; i++) {
  modules[i].addEventListener("dragstart", function(event) {
    event.dataTransfer.setData("text/plain", event.target.innerHTML);
  });
}

for (var i = 0; i < modules.length; i++) {
  profs[i].addEventListener("dragstart", function(event) {
    event.dataTransfer.setData("text/plain", event.target.innerHTML);
  });
}

</script>

</body>
</html>