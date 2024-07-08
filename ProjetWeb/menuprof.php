<?php session_start();
?>


<!DOCTYPE html>
<html>  
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="menuprof.css">
</head>
<body>


    <nav>
        <div class="logo">
          <img src="ensahlogo.png" alt="Logo">
        </div>
        <ul>
          <li><a href="acceuil.php">Accueil</a></li>
          <li>
            <a href="mesmodules.php">Modules</a>
            <ul>
              <li><a href="listeetudiant.php">Listes</a></li>
              <li><a href="marquer_absence.php">Absence</a></li>
            </ul>
          </li>
          <li><a href="emploisdetemps.php">Emplois de temps</a></li>
          <li><a href="#">Notes</a></li>


              <?php if($_SESSION['role']=="coordinateur"):
        
            $filiere=$db->prepare('SELECT id_fil as id_filiere,nom_fil,descriptif_fil,id_prof as id_coord,nom_prof FROM filiere INNER JOIN professeur ON professeur.id_prof=filiere.coordinateur ');
    $filiere->execute();
    $infof=$filiere->fetchAll(); 
    
    foreach($infof as $val):?>
      <?php if($val['id_coord']==$_SESSION['id']):
         $n=$val['nom_fil'];
        $_SESSION['id_filiere']=$val['id_filiere'];
      endif;
      endforeach; ?>
  
          <li><a href="#"> Filière de <?php echo $n ?></a>
          <ul>
              <li><a href="detaille.php">Détaille</a></li>
              <li><a href="affiche_gestion_module.php">Gestion des Module</a></li>
              <li><a href="#">Gestion des Notes</a></li>
              <li><a href="#">Gestion d'Emplois de temps</a>
                <ul>
                  <li><a href="gestion_emploi_de_temp.php"> Crée emplois de temps</a></li>
                  <li><a href="liste_emploi_de_temp.php">liste des emploi de temps crées</a></li>
                </ul>  
              </li>
              
            </ul>
           </li>
          <?php endif; ?> 
          <?php if( $_SESSION['role']=="chef de departement"):
            
             
              try{
               $db= new PDO(
                   'mysql:host=localhost;port=3306; dbname=eservice;charset=utf8', 'root', '');
                     
                  
               }
               catch(Exception $e)
               {
                 // En cas d'erreur, on affiche un message et on arrête tout
                       die('Erreur : '.$e->getMessage());
                       
               }
             
 
            
    $user= $db->prepare("SELECT * FROM  `professeur`  JOIN `departement`  WHERE professeur.id_dep=departement.id_dep  AND id_prof='$_SESSION[id_prof]'");

    $user->execute();
    $profs = $user->fetch();
    $_SESSION['id_dep']= $profs['id_dep'];
         ?>
              
           <li><a href='#'>Département  de <?php  echo $profs['nom_dep']; ?></a> 
          <ul>
          <li><a href='gestion des module.php'>Module </a></li>
             <li><a href='gestion des prof.php'>Gestion des proffesseur</a></li>
              <li><a href='#'>Gestionss Ensiengment</a>
                 <ul>';
                    <li><a href='affectation.php'>affectation des modules</a></li>
                    <li><a href='modifier1.php'>consulter</a></li>
               </ul>
                 </li>
              
           </ul>
           </li>
           
       </ul>
              
            </ul>
           </li>
          <?php endif; ?> 
        </ul>
        <form>
              <input type="text" name="" placeholder="Rechercher...">
              <button type="submit" name="submit">OK</button>
          </form>
           <span>
            <ul>
            <li>
           <div id="profil_icon"><i class="fa-solid fa-user"></i></div>
            <?php echo $_SESSION['full name']?>
              <ul>
                <li><a href="deconnecter.php"><p>déconnecter</p></a>
              </li>
              </ul>
          </li>
          </ul>
          </span>
          
            
      </nav>  
</body>
</html>