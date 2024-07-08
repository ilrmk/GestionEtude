<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img src="icon2.png" id="0">
    <img src="icon2.png" id="1">

    <script>
        var prix = [12, 13];
        var total = 0;

        var img1 = document.getElementById("0");
        img1.addEventListener("click", function() {
            total += prix[0];
        });

        var img2 = document.getElementById("1");
        img2.addEventListener("click", function() {
            total += prix[1];
        });

        alert("Total: " + total);
    </script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
  <title>Prix Total des Images</title>
</head>
<body>
  <h1>Prix Total des Images</h1>

  <img src="icon1.jpg" id="image1" onclick="ajouterPrix(this.id)" />
  <img src="icon1.jpg" id="image2" onclick="ajouterPrix(this.id)" />
  <img src="icon1.jpg" id="image3" onclick="ajouterPrix(this.id)" />
  <img src="icon1.jpg" id="image4" onclick="ajouterPrix(this.id)" />

  <h2>Prix Total : <span id="prixTotal">0</span> €</h2>

  <script>
    var prix = {    
      image1: 10,
      image2: 20,
      image3: 15,
      image4: 25
    };

    function ajouterPrix(id) {
      var prixImage = prix[id];
      var prixTotalElement = document.getElementById("prixTotal");
      var prixTotal = parseInt(prixTotalElement.innerText);
      
      prixTotal += prixImage;
      prixTotalElement.innerText = prixTotal;
    }
  </script>
</body>
</html>
