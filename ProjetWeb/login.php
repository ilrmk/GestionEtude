<?php session_start();?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>

img{
  margin-bottom: 20px;
     margin-top: 50px ;
     margin-left:50px;
    max-width: 300px;
    display: block;
  }    
  .section2{
    height:515px;
  }
hr{
border: 0;
height: 1px;
background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
    }

input[type=text] ,input[type=password]{
      border:2px solid white;
      background-color:lightgray;
      outline:none;
      height:40px;
       }
input[type=checkbox]{
         border-radius: 5px;
         border:2px solid white;
         background-color:lightgray;
           }
.btn{
   height:40px;
   border-radius: 25px;
}
.bg{
background-color: #23177B;
}
  </style>
</head>
<?php if(!isset($_POST["submit"])): ?>
<body class="bg" >
  <div class="container-login100 wrap-login100" style="margin-left:20%;margin-right:20%;">
    <div class="row row mt-5 mb-5 bg-white" >
       <div class="col-sm-6  d-none d-sm-block " > 
        <img src="ensahlogo.png">
        <div class="text-center p-3">
              <strong>UNIVERSITÉ ABDELMALEK ESSAADI<br>
         Ecole Nationale des Sciences<br>
           Appliquées d'Al Hoceima</strong></div>
           
       
       </div>
       
       <div class="col-sm-6 section2 pt-3 pb-1 px-3" >
            <form class="login100-form validate-form" method="POST" action="indexprof.php">
              <div class="text-center p-3">
                 <span class="login100-form-title">
        			  	<h4 >Plateforme eServices</h4>
        		 </span>
                </div>

            <div class="form-group">
                 <input  name="username" type="text" class="form-control form-control-user mb-1" placeholder="votre nom d'utilisateur" >
           </div>

            <div class="form-group">
                  <input  name="password" type="password" class="form-control form-control-user mb-1" placeholder=" votre mot de passe" >
            </div>

                <div class="custom-control custom-checkbox mb-3 ml-1">
                     <input type="checkbox" class="custom-control-input" id="customCheck" name="customcheck">
                    <label class="custom-control-label" for="customCheck">Se rappeler de moi</label>
               </div>
               <input type="submit" class="btn btn-success btn-user btn-block" value="Se connecter" name="submit" >

                 <hr>
                 <div class=" text-center">
                        <a class="small" href="mdp.php">mot de passe oublié ?</a>
                </div>

               <div class="text-center">
                  <a class="small" href="quest.php">Questions ?</a>
              </div>

             <br><br>
             <div class="text-center" >
                  <p>Copyright © 2020 - Tous droits réservés</p>
              </div>
     </div>
    </div>
  </div>
  </div>
</body>
<?php endif; ?>
</html>



<?php
if(isset($_POST["submit"])){
  try{
    $db= new PDO(
        'mysql:host=localhost;port=3306; dbname=eservice;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION], //Pour afficher des détails sur l'erreur, il faut activer les erreurs lors de la connexion à la base de données via PDO.
    );
    
    }
    catch(Exception $e)
    {
      // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
            
    }
    $user= $db->prepare('SELECT * FROM `professeur`');

    $user->execute();
    $profs = $user->fetchAll();
foreach($profs as $prof ):{
if($_POST['username']==$prof['email'] && $_POST['password']==$prof['mot_pass']): { 
       $v=1;
       $_SESSION['username']= $prof['email'];
       $_SESSION['full name']= $prof['nom_prof'];
       $_SESSION['role']= $prof['role'];
       $_SESSION['id_prof']=$prof['id_prof'];
       $_SESSION["submit"]=$_POST['submit'];
      break;
    } 
  endif; 
}
endforeach; 
if($v!=1):
 header("location:login.php?error=2&password=".$password);
endif;

}
?>