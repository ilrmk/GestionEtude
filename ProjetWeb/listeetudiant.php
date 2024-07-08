<?php 
include_once('menuprof.php')?> 
<?php
if (!isset($_SESSION['submit'])) {
    header('location: login.php');
    exit();
}
?>
<?php
// Connexion à la base de données
try{
    $db= new PDO(
        'mysql:host=localhost;port=3306; dbname=eservice;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION], 
    );
    }
    catch(Exception $e)
    {
      die('Erreur : '.$e->getMessage());     
    }
$id_professeur = $_SESSION['id_prof'];

// afficher tous les modules de ce prof
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
    <title>Liste des étudiants</title>
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
		.absence-btn {
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
		.absence-btn:hover {
			background-color: #3e8e41;
		}
		.nommodule{
			color:black;
			text-align: center;
			line-height:5px;
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

<h2>Liste des étudiants</h2>


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
  
  // Récupérez le module sélectionnée de la liste déroulante avant la soumission du formulaire
  const selectedModule = localStorage.getItem('selectedModule');
  if (selectedModule) {
    moduleSelect.value = selectedModule;
  }
  
  form.addEventListener('submit', function(event) {
    // Stockez le module sélectionnée dans localStorage avant la soumission du formulaire
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
            <?php foreach ($etudiants as $etudiant) { ?>
                <tr>
                    <td><?php echo $etudiant['id']; ?></td>
                    <td><?php echo $etudiant['nom']; ?></td>
                    <td><?php echo $etudiant['prenom']; ?></td>
                    <td><?php echo $etudiant['email']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="marquer_absence.php "; class="absence-btn">Marquer l'absence</a>
<?php } ?>
</body>
</html>