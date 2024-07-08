
<!DOCTYPE html>
<html>
<head>
  <title>ENSAH Acceuil </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <style>
   
    body{
      display: flex ;
      flex-direction: column;
      min-height:90vh;
      background-color: white;
    }

    .container{
        margin-top: 10px;
      display:flex;
      flex :1;
      flex-direction: row;
      background-color: white;
    }
    .item1{
      display:flex;
      flex:4;
      background-position: center;
      background-image:url("ensah_pic.png");
      background-size: cover;
      border:1px solid #23177B;
      border-radius: 2px;
    }

    .item2{
      display:flex;
      flex:1;    
      flex-direction: column; 
      margin-left: 10px;
      border:1px solid #23177B;
      border-radius: 2px;
      padding:20px;

    }

    .item3{
      display:flex;
      flex:1; 
      padding:10px 4%; 
      background-color: white;
    }
    .item3 p {
        margin-left:10px;
        color:black;
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-style: italic; }      

    .menu1,.menu2{
      display:flex;
      flex :1;
      flex-direction: row;
      text-align: center;
    } 
   h4{
    color:black;
    text-decoration:underline;


   }

    @media screen and (min-width:780px) {
      .item1{
        background-image:url("ensah_pic.png");
        background-position: center;
        background-size: cover;
        height:400px;
      }
      
    }
  </style>
</head>

<body>
<?php include_once('menuprof.php')?> 

  <div class="container" >
    <div class="item1" ></div>
    <div class="item2" >
      <h4>RACCOURCIS</h4>
      <div  class="menu1" >
        <img src="icon1.png" style="height:60px;margin:0 5%;">
         <br><a href="mesmodules.php" ><div style="color: black;margin-top:20px;">Vos modules</div></a>
       </div>
      <div class="menu2" >
      <img src="icon2.png" style="height:60px;margin:0 5%;">
       <br><a href="emploisdetemps.php" ><div style="color: black;margin-top:20px;">Votre emplois du temps</div></a>
    </div>
</div>
  </div>

    <div class="item3"  >
      <h2 style="color:black; ">ENSA d'Al-Hoceima</h2>
      <p ><strong>l'Ecole Nationale des Sciences Appliquées d'Al-Hoceima
        (ENSAH)</strong> est un établissement public d'enseignement
    supérieur relevant de l'université Abdelmalek Essaadi. Sa création
    s'inscrit dans l'optique de favoriser la formation des ingénieurs
    d'Etat hautement qualifiés dans les spécialités les plus ouvertes
    et susceptibles de connaître d'importants développements au sein
    du tissu socio-économique régional et national. Le positionnement
    de l'Ecole contribuera à lui conférer une dimension
    euro-méditerranéenne et à répondre aux besoins régionaux et
    nationaux en matière de formation en ingénierie. L'Ecole
    Nationale des Sciences Appliquées Al-Hoceima dispense des
    formations de deux années préparatoires et trois années de
    spécialités dans 6 filiéres actuels </p>
    </div>

<body>
</html>
