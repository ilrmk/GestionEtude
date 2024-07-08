<?php   
  include("menuprof.php");

 
?>


  



<!DOCTYPE html>
<html>  
<head>
    <
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="menuprof.css">
    <link rel="stylesheet" type="text/css" href="style_chefde.css">
    <style> 
     div#titr{
      display: flex;
      justify-content: center;
    }
    
    

      #sem{ text-decoration: underline;
    color:darkslateblue;}
    
    
    
    </style>
</head>
<body>

      <section>
        <div id="chix">
      <div id="prof">
        <h1>consulter les modules</h1>
        </div>

        <div id="titr">
  
  <div>
  <h1 id="sem">choisir une semestre</h1>
<form action="modifier1.php" method="post"  id="pet-select" s>
<select name="choix" >
  <option value="" >choisir semestre</option>
    <option value="S1" >Semestre1</option>
    <option value="S2">Semestre2</option>
    <option value="S3">Semestre3</option>
    <option value="S4">Semestre4</option>
    <option value="S5">Semestre5</option></select>
   
    <button  name="button">
        choisir
</button>

</form>
       </div>
</div>
</div>


<?php
if(isset($_POST['button']))
    { 
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
  
  $user="SELECT id_mod, nom_mod,responsable,nom_prof,semestre FROM `module`join professeur WHERE module.responsable=professeur.id_prof AND semestre='$_POST[choix]'";
  $repons=$db->query($user);
  
  echo "<table>";
  echo"<tr>";echo"<th>"; echo"Module"; echo"</th>"; echo "<th>"; echo"Responsable"; echo"</th>";;echo"<th>";echo"Action"; echo"</th>";echo"</tr>";
  
  
  while($module = $repons->fetch()){
  echo"<tr>";
  echo"<td>";
  echo $module['nom_mod'] ;
  echo"</td>";
  echo"<td>" ;  
  echo $module['nom_prof'] ;
  echo"</td>";
   echo"<td>";
   
  echo"<button name='modifer' ><a href='pageModifier.php?nom_prof=$module[nom_prof]&&nom_mod=$module[nom_mod]&&semestre=$module[semestre]'>modifer";
  
  
  
  echo"</td>";
   echo"</tr>";
  
  }
  
  echo "</table>";


 
  
  
}
  
  
  
  ?>
  

  

  
  
  
</section>
</body>



</html>