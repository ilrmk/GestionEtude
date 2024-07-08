
<?php session_start() ;?>
<?php 
if(!isset($_SESSION['aller'])){
   ?>

<script>alert("Il faut  Choisir un semestre d'abord ") ;</script>
<?php
}
else if(isset($_POST['enregestrer']) ){

   
    unset($_SESSION['aller']);

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
        

    $module=$_POST['module'];
    $enseingnant=$_POST['enseingnant'];
    $heure_debut = $_POST['date_debut'];
    $heure_fin = $_POST['date_fin'];
    $jour=$_POST['jour'];
       

    for($i=0;$i<8;$i++){
        for($j=0;$j<10;$j++){
            
            
        if(!empty($module[$i][$j]) && !empty($enseingnant[$i][$j])){
             echo "<br>".$module[$i][$j]."<br>";
             echo $enseingnant[$i][$j]."<br>".$heure_debut[$i][$j]."<br>".$heure_fin[$i][$j]."<br>".$_SESSION['semestre']."<br>".$jour[$i][$j];
    

        $query = $db->prepare("SELECT id_mod,nom_mod,id_fil,semestre,id_prof AS id_enseignant, nom_prof AS nom_enseignant
                            FROM module 
                            LEFT JOIN professeur ON module.responsable = professeur.id_prof 
                            WHERE nom_mod=:nom_m AND id_fil=1;");
    
        $query->bindValue(':nom_m', $module[$i][$j]);

        $query->execute();
        $resultat_module=$query->fetchAll();

        echo "<br> executer".$resultat_module[0]['id'];
        
    $insert_seance=$db->prepare("INSERT INTO `seance` (`id`, `nom_filiere`, `semestre`, `nom_module`, `nom_prof`, `heure_debut`, `heure_fin`, `jour`) VALUES (NULL, 1,:semestre,:module,:prof,:debut,:fin,:jour);");
        
    
    try {
        $insert_seance->execute([
            'semestre'=>$_SESSION['semestre'],
            'module'=> $resultat_module[0]['id'],
            'prof'=>$resultat_module[0]['id_enseignant'],
            'debut'=>$heure_debut[$i][$j],
            'fin'=>$heure_fin[$i][$j],
            'jour'=>$jour[$i][$j],
        ]);
        
        echo "l'enregestrement bien execute <br>";

        
        

    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
 
     }
}
?>
<script>alert("Emploi de temps bien enregistrer ") ;</script>
<?php
}

?>
