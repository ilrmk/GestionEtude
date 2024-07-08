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
    div#page{
display: flex;
background-color: white;

  }
  


  div#id1{
  
  margin:2px 2px 2px;
  flex: auto; 
  border: 1px solid  rgb(145, 179, 247);
  
  }
  div#id2{
 display: flex;
 flex-direction: column;
  margin-right: 6px;
  flex: auto;

 
  }
  table{
    width: 100%;
  }
     
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
  
      <div id="prof">
        <h1>l'affectation des modules</h1>
        </div>
        
<div id="titr">
  
  <div>
 
        <h1 id="sem">choisir une semestre</h1>
       
<form action="affectation.php" method="post"  id="pet-select" s>
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
 

?>



<?php 
if (isset($_POST['button'])) 
{
echo'<div id="page">';

 echo'    <div id="id1">';
    
     
 $user="SELECT id_prof,nom_prof,specialite FROM `professeur`  WHERE   id_dep='$_SESSION[id_dep]'";
 $repons=$db->query($user);

 echo "<table>";
       echo"<tr>"; echo "<th>"; echo"professeur"; echo"</th>";echo"<th>";echo"Spécialité"; echo"</th>";echo"</tr>";
      
     
      while($prof = $repons->fetch())
      {
       echo"<tr>";
       
       echo"<td>" ;  
       echo "<span  class='ms' draggable='true'>".$prof['nom_prof']."</span>" ;
       echo"</td>";
       
        echo"<td  >";
        echo $prof['specialite'];
        echo"</td>";
        
        echo"</tr>";
 
 }
 echo"</table>";
    echo"
    </div>";



     
   
    
   



{
  echo'<div id="id2">';
    $user = "SELECT id_mod, nom_mod FROM module WHERE semestre = '{$_POST['choix']}'";
    $repons = $db->query($user);
    echo '<div id="id1">';
    echo "<table>";
    echo "<tr><th>Module</th><th>Professeur</th></tr>";

    echo "<form action='' method='post'>";

    while ($module = $repons->fetch()) {
        echo "<tr>";
        echo "<td>{$module['nom_mod']}</td>";
        echo "<td>";
        echo "<input type='hidden' name='id_mod[]' value='{$module['id_mod']}' />";
        echo "<input type='text'   name='nom_prof[]' />";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
    echo "<div>";
    echo"<lable for='i'  style='color:black;'>        enregesté le tableau:        </lable>";
    echo "<button type='submit' name='enregistrer' id='i'>Enregistrer</button>";
    echo "</form>";
    echo "</div>";
  }



echo"</div>";
echo"</div>";


}



        if (isset($_POST['enregistrer'])&&isset($_POST['nom_prof']))
          

                   
       


            {
            $mod = $_POST['id_mod'];
            $prof = $_POST['nom_prof'];

            for ($i = 0; $i < count($mod); $i++) {
             

                $req = "SELECT id_prof FROM professeur WHERE nom_prof = :nom";
$pre = $db->prepare($req);
$pre->bindValue(':nom', $prof[$i]);
$pre->execute();
$pr = $pre->fetch();

if ($pre->rowCount() > 0) {
    // La requête a renvoyé des résultats, vous pouvez accéder à $pr['id_prof']
    $req = "UPDATE `module` SET responsable = :id_prof WHERE id_mod = :id";
    $pre = $db->prepare($req);
    $pre->bindValue(':id_prof', $pr['id_prof']);
    $pre->bindValue(':id', $mod[$i]);
    $pre->execute();
          
     
}
} 
if($pr){

echo "<script>";
 
echo "window.alert('Bien enregisté')";
echo "</script>";
    }
 
  else
        {
          echo "<script>";


   echo "window.alert('les champs vide');";
       echo "</script>";     } 

    
        }









?>
<script type="text/javascript">

var modules = document.getElementsByClassName("ms");


for (var i = 0; i < modules.length; i++) {
  modules[i].addEventListener("dragstart", function(event) {
    event.dataTransfer.setData("text/plain", event.target.innerHTML);
  });
}




</script>

</section>
</body>



</html>