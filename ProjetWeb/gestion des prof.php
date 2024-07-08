<?php 
 include("menuprof.php");
?>


<!DOCTYPE html>
<html>  
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="menuprof.css">
    <link rel="stylesheet" type="text/css" href="style_chefde.css">
    
    
</head>
<body>


    

<section>
  <div  id="prof">
<h1>Les professeurs de département mathématique et informatique</h1>
<form>
              <input type="text" name="" placeholder="Rechercher...">
              <button type="submit" name="submit">OK</button>
          </form>
          </div>
 
  




<?php

      try{
        $db= new PDO(
            'mysql:host=localhost;port=3306; dbname=eservice;charset=utf8',
            'root',
            '');
               
           
        }
        catch(Exception $e)
        {
          // En cas d'erreur, on affiche un message et on arrête tout
                die('Erreur : '.$e->getMessage());
                
        }
      
        $user= $db->prepare("SELECT * FROM  `professeur`    WHERE   id_dep='$_SESSION[id_dep]'");

        $user->execute();
        

echo "<table>";
      echo"<tr>";echo"<th>"; echo"CIN"; echo"</th>"; echo "<th>"; echo"Nom"; echo"</th>";echo"<th>";echo"Spécialité"; echo"</th>";echo"<th>";echo"Email"; echo"</th>";echo"</tr>";
     
    
     while($profs = $user->fetch())
     {
      echo"<tr>";
      echo"<td>";
      echo $profs['id_prof'] ;
      echo"</td>";
      echo"<td>" ;  
      echo $profs['nom_prof'] ;
      echo"</td>";
       echo"<td>";
       echo $profs['specialite'];
       echo"</td>";
       echo"<td>";
       echo $profs['email'];
       echo"</td>";
       echo"</tr>";

}

echo "</table>";


?>

</section>


</body>
</html>