<?php 
include_once('menuprof.php')?> 
<?php
if (!isset($_SESSION['submit'])) {
    header('location: login.php');
    exit();
}
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

// Sélectionner tous les modules de ce prof avec semestre et nom filiere
$sql="SELECT module.nom_mod, filiere.nom_fil, module.semestre
FROM seance
JOIN module ON seance.idmodule = module.id_mod
JOIN filiere ON module.id_fil = filiere.id_fil
WHERE seance.idprof = $id_professeur";

$resultat = $db->query($sql);
$modules = $resultat->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title> Mes modules </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
     <style>
	
		h2{
      color:black;
			text-align: center;
      font-family: Arial, sans-serif;
      font-size:30px;
      font-weight: bold;
      margin-top:20px; 
      text-decoration: underline;  
      margin-bottom: 50px;
		}

		.nommodule{
			color:black;
			text-align: center;
			line-height:15px;
      font-family: Arial, sans-serif;
      font-size:20px;
      font-weight: bold;
      font-style: italic;
		}
      .nommodules{
        margin-top:50px;
      }

	</style>
</head>
<body>

	<h2>Mes Modules </h2>
  <div class="nommodules">
	<?php foreach ($modules as $module) { ?>
		<p class="nommodule"><?php echo $module['nom_mod'] ," ", $module['nom_fil'] ," " ,$module['semestre']; ?></p> <?php
    } ?></div>