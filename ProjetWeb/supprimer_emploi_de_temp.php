<script>
    confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")
  // Code à exécuter si l'utilisateur clique sur OK
  // Par exemple, supprimer l'élément

  </script>
  
<?php 

session_start();
if(isset($_GET['semestre']))
echo "envoyer".$_SESSION['id_filiere'];
$semestre=$_GET['semestre'];
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

    $requete = $db->prepare("DELETE FROM seance WHERE semestre = :semestre and nom_filiere = :filiere");
$requete->bindValue(':semestre', $semestre);
$requete->bindValue(':filiere', $_SESSION['id_filiere']);
$requete->execute();
    header('location:liste_emploi_de_temp.php');
 ?>


