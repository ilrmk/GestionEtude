<?php include_once('menuprof.php')?> 

<?php 
// Connexion à la base de données
try{
    $db= new PDO(
        'mysql:host=localhost;port=3306; dbname=eservice;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION], 
        //Pour afficher des détails sur l'erreur, il faut activer les erreurs lors de la connexion à la base de données via PDO.
    );
    }
    catch(Exception $e)
    {
      // En cas d'erreur, on affiche un message et on arrête tout
      die('Erreur : '.$e->getMessage());     
    }

	$id_professeur = $_SESSION['id_prof'];

	// Sélectionner tous les modules de ce prof
  $sql="SELECT module.nom_mod, filiere.nom_fil, module.semestre FROM seance
  JOIN module ON seance.idmodule = module.id_mod
  JOIN filiere ON module.id_fil = filiere.id_fil
  WHERE seance.idprof = $id_professeur";	
  $resultat = $db->query($sql);
	$modules = $resultat->fetchAll(PDO::FETCH_ASSOC);
	

?>
<!DOCTYPE html>
<html>
<head>
    <title>Absence </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
     <style>
		table {
			text-align: center;
			border-collapse: collapse;
			width: 50%;
			margin: 10px auto;
			font-size: 1em;
			font-family: sans-serif;
		}
		th, td {
			text-align: left;
			padding: 15px;
			border: 2px solid gray;
			color:black;
		}
		th {
			background:rgb(145, 179, 247);		
			color: white;
		}
		tr:nth-child(even) {
			background-color: white;
		}
		h2{
			color:black;
			text-align: center;
		}
		.save {
			position: fixed;
			bottom: 40px;
			right: 20px;
			background-color: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			font-size: 1em;
			font-family: sans-serif;
			transition: all 0.2s ease-in-out;
		}
		.save :hover {
			background-color: #3e8e41;
		}
		.nommodule{
			color:black;
			text-align: center;
			line-height:5px;
		}
          #absence{
         width:20px; 
         text-align: center;

        }

         input[type=checkbox] {
            height: 20px;
            width: 20px;
            margin: 0;
            padding: 0;
            border: 3px solid #ccc;
            outline: none;
            cursor: pointer;
}
select {
  width: 350px;
  padding: 10px;
  font-size: 14px; 
  border: 1px solid #ccc; 
  border-radius: 4px; 
  background-color: #fff; 
  color: #333; 
}

select::-ms-expand {
  display: none;
}

select:hover {
  border-color: #999; 
}

select:focus {
  outline: none; 
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.3); 
}
.notification{
        background-color: #4CAF50; 
        color: white; 
        padding: 10px; 
        text-align: center; 
        width:300px; 
        margin-left: 37%;
    }
    h2{
        color:black;
			text-align: center;
            font-family: Arial, sans-serif;
            font-size:30px;
            font-weight: bold;
            margin-top:20px; 
            text-decoration: underline;  
    }

	</style>
</head>
<body>

	<h2>Absence</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="choixmod">
    <select name="module_selectionne" id="moduleSelect">
        <?php foreach ($modules as $module) { ?>
            <option class="nommodule" value="<?php echo $module['nom_mod']; ?>"><?php echo $module['nom_mod']. " - ".$module['nom_fil']."-". $module['semestre']; ?></option>
        <?php } ?>
    </select>
    <br><br>
    <input type="submit" name="submit" value="Valider">
</form>

<script>
  const form = document.getElementById('choixmod');
  const moduleSelect = document.getElementById('moduleSelect');
  
  // Récupérez la valeur sélectionnée de la liste déroulante avant la soumission du formulaire
  const selectedModule = localStorage.getItem('selectedModule');
  if (selectedModule) {
    moduleSelect.value = selectedModule;
  }
  
  form.addEventListener('submit', function(event) {
    // Stockez la valeur sélectionnée dans localStorage avant la soumission du formulaire
    localStorage.setItem('selectedModule', moduleSelect.value);
  });
</script>

<?php
if (isset($_POST["submit"])) {
    $moduleselectionne = $_POST['module_selectionne'];

    $requette = "SELECT * FROM etudiant WHERE semestre = (SELECT semestre FROM module WHERE nom_mod = '$moduleselectionne')";
    $statement = $db->query($requette);
    $etudiants = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
		<form method='post' action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
            <?php foreach ($etudiants as $etudiant) { ?>
                <tr>
                    <td><?php echo $etudiant['id']; ?></td>
                    <td><?php echo $etudiant['nom']; ?></td>
                    <td><?php echo $etudiant['prenom']; ?></td>
                    <td><?php echo $etudiant['email']; ?></td>
					<td id="absence"><input  type='checkbox' name='absent[]' value="<?php echo $etudiant['id']; ?>"></td></tr>
                </tr>
            <?php } ?>
        </tbody>
    </table>
	<input class="save" type='submit' name='save' value='Enregistrer'>
	</form>

<?php }
// Traitement de l'enregistrement de l'absence
if (isset($_POST["save"])) {
 echo '<div class="notification">Enregistrement de l\'absence réussi !</div>';

  // Récupération de la date1
  $date = date("Y-m-d");
  
  // Ouverture du fichier texte en mode append
  $filename = "absences.txt";
  $file = fopen($filename, "a");
  
  $requette = "SELECT nom , prenom, id FROM etudiant";
  $statement = $db->query($requette);
  $etudiants = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($_POST['absent'] as $id) { 
		foreach($etudiants as $etudiant ){
        if($id==$etudiant["id"]){
				$line = $date . " // // " . $etudiant['id']. " - " . $etudiant["prenom"] . " " . $etudiant["nom"] . "\n";
				fwrite($file, $line);}
			}
	}fclose($file);

} 
?></body>
</html>