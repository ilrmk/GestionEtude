<?php session_start();
$_SESSION['id_m']=$_POST['id']

?>
<?php
    if(!isset($_SESSION["submit"])):
        include_once('login.php'); 
        
         
        
        
      
     else : //if(isset($_POST['id']) && isset($_POST['modifier']))  
        
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
    if(isset($_POST['id'])):
        $_SESSION['id_m']=$_POST['id'];
        $id=$_POST['id'];
    $module=$db->prepare('SELECT module.id_mod, module.nom_mod, module.volume_horaire,p2.id_prof AS id_enseignant  , p2.nom_prof AS nom_enseignant
    FROM module 
    
    
    LEFT JOIN professeur p2 ON module.responsable = p2.id_prof where module.id_mod=:id;');
    $module->execute([
        'id'=>$id,
    ]);
    $infom=$module->fetchAll(); 

    $prof=$db->prepare('SELECT id_prof, nom_prof from professeur');
    $prof->execute();
    $name_prof=$prof->fetchAll();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Module</title>
    <style>
        section{
            color: black;
        }
        form{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color:black;
            
        }
        h1{
            font-size: xx-large;

        }
        input,label{
            margin: 10px;
            display: block;
        }
        .buttom{
            
            float: right;
           
        }
        #autreForm{
            display: flex;
            flex-direction: row;
        }

    </style>
</head>
<body>
   <section>
   <h1>Mettre à jours <?php ?></h1> 
   
   <form action="detaille_modifier.php" method="POST">
   
   <label for="nom_m">Le nom de module</label>
 
   <input type="text" name="nom_m" id="nom_m"  value="<?php echo $infom[0]['nom_mod'] ?>" required>
  
  
   <label for="volume_horaire">Volume horaire</label>
   <input type="text" name="volume_horaire" id="volume_horaire" value="<?php echo $infom[0]['volume_horaire']?>" required >
  
        <label for="enseignant">Enseignant</label>
        <select id="enseignant" name="id_e">
        <optgroup>
        <?php foreach($name_prof as $val): ?> 
        
        <option value="<?php echo $val['id_prof'] ?>" ><?php echo $val['nom_prof'] ?>  </option>
        <?php endforeach; ?>
        </optgroup>
        <optgroup>
        <option value="autre" id="autre">Autre</option>
        </optgroup>
        </select> 
        
         <!-- Votre formulaire à remplir lorsque l'option "Autre" est sélectionnée -->
        <div id="autreForm" style="display: none;">
        <label for="nom">Nom de vacataire</label>
        <input type="text" name="nom_v" id="nom">
        <label for="email">Email</label>
        <input type="email" name="email_v" id="email">
        </div>

        <div class="buttom">
        <input type="submit" name="enregestrer" value="Enregestrer">
          </div>
</form>

<?php endif; ?>
<?php endif; ?>


</section>
<script>
  var enseignantSelect = document.getElementById("enseignant");
  var autreForm = document.getElementById("autreForm");

  enseignantSelect.addEventListener("change", function() {
    if (enseignantSelect.value === "autre") {
      autreForm.style.display = "block";
    } else {
      autreForm.style.display = "none";
    }
  });
</script>
</body>
</html>