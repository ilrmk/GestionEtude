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

            $module=$db->prepare('SELECT id_mod,nom_mod,semestre,id_prof AS id_enseignant  ,nom_prof AS nom_enseignant
                FROM module 
               LEFT JOIN professeur  ON module.responsable = professeur.id_prof;');

            $module->execute();
            $infom=$module->fetchAll(); 

            $jour=$db->prepare('SELECT * FROM jour ');
            $jour->execute();
            $jour=$jour->fetchAll();

           
    ?>

     <h1 style="color: black; margin-bottom:20px">Modifier l'Emploi de temps</h1>

    
    <div class="continu">

    <section class="module_ensiegnant">
       
     <table >
        <tr ><th >Liste des modules avec leur enseignant</th></tr>
        
        
         
                  

                <?php foreach($infom as $val): ?>
                    <?php if($val['semestre']==$_GET['semestre']): ?>
                       <tr ><td style="color: black;"><?php echo $val['nom_m']."<br>".$val['nom_enseignant'] ?></td></tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                

        
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

        <?php $i=0;$j=0; foreach($jour as $val): ?>
            <tr>
                <td><?php echo $val['nom_jour'] ?></td>
              <?php  $chaque_jour=$db->prepare("SELECT * FROM seance 
                     LEFT JOIN module on module.id=seance.nom_module
                     LEFT JOIN prof on prof.id=seance.nom_prof
                     where seance.nom_filiere=:filiere and seance.semestre=:semestre and jour=:jour"); 
                        $chaque_jour->bindValue(':semestre', $semestre);
                        $chaque_jour->bindValue(':jour', $val['nom_jour']);
                        $chaque_jour->bindValue(':filiere', $_SESSION['id_filiere']);
                     $chaque_jour->execute();
                     $chaque_jour=$chaque_jour->fetchAll(); ?>
                <td>
                    <?php if($seance[$j]['jour']==$val['nom_jour'] && $seance[$j]['heure_debut']=='08:30:00'): ?>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" value="<?php echo $seance[$j]['nom_m']?>">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant" value="<?php echo $seance[$j]['full_name']?>">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="08:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="09:30:00">
                    <?php else: ?>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module" >
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="08:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="09:30:00">
                    <?php endif; ?>
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="09:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="10:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="10:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="11:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="11:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="12:30:00">
                </td>
                <td></td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="14:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="15:30:00">
                </td>
                <td>
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
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
                    <input type="text" name="module[<?php echo $i ?>][]" placeholder="module">
                    <input type="text" name="enseingnant[<?php echo $i ?>][]" placeholder="Enseignant">
                    <input type="hidden" name="jour[<?php echo $i ?>][]" value="<?php echo $val['nom_jour']; ?>">
                    <input type="hidden" name="date_debut[<?php echo $i ?>][]" value="17:30:00">
                    <input type="hidden" name="date_fin[<?php echo $i ?>][]" value="18:30:00">
                </td>
            
            </tr>
        <?php $i++;$j++; endforeach; ?>    
    </table>
    </div>
    </section>
    </div>
    <div style="display: flex; margin:10px;justify-content:right">
     <input type="submit" name="modifier" value="Modifier" style="margin-right: 20px;" >
     <input type="reset"  value="Réiniliser" >
    </div>
    </form>
    <a href="liste_emploi_de_temp.php" style="color:blueviolet; margin:20px;text-align:center">Liste des Emploi de temps modifier</a>
    
    

<?php  endif; ?>

</body>
</html>