<?php
//header('Content-type: text/plain');
$host = 'localhost';
    $dbname = 'testexo2';
    $username = 'root';
    $password = '';
  $nbrElementParPage = 10;
  $i = 1;
  // on récupére le numéro de la page dans laquel on est
  if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = (int) strip_tags($_GET['page']);
  }else{
    $page = 1;
  }
  // on créer la valeur de debut pour l'utiliser sur la fonction limit en SQL
  $debut=($page-1)* $nbrElementParPage;
    
        
    $dsn = "mysql:host=$host;dbname=$dbname"; 
    // récupérer tous les utilisateurs a partir de la variable debut 
    $sql = "SELECT name from mytable limit $debut,$nbrElementParPage";
     
    try{
        // on se login a la base de odnnée
     $pdo = new PDO($dsn, $username, $password);
     // on execute la requete sql
     $stmt = $pdo->query($sql);
     // on récupére les lignes
     $rows = $stmt->fetchAll();
    
     // on compte le nombdre de lignes
     $var = $pdo->prepare('SELECT COUNT(*) from mytable') ;
     $var->execute();
     $nbrDelignes = $var->fetch(PDO::FETCH_NUM);

     // on fait une division pour savoir combien de noms on aura par page
     $nbrDePage = ceil($nbrDelignes[0]/ $nbrElementParPage);
     //echo $nbrDePage;

    // on affiche l'erreur si il y'en a une
     if($stmt === false){
        die("Erreur");
     }
     
    }catch (PDOException $e){
        echo $e->getMessage();
    }
?>




<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/styles.css?v=1.0">

</head>

<body>
    <!-- on rajoute un peu de css -->
    <style>
     div#pagination a {
      text-align:center;
      background-color: grey;
      border: solid;
      align-items: center;
    }
    </style>

    <!-- on va afficher ligne par ligne les noms-->
    <div id="listePagination">
    <?php foreach($rows as $row): ?>
        <a><?= $row['name'] ; ?><br></a>
    <?php endforeach; ?>
    </div>


    <!-- création des boutons en fonction du nombre de page-->
    <div id="pagination">
    <?php
    //affichage du précédent
    echo "<a  href='?page=$i--'>précédent</a>&nbsp;";
    // affichage des chiffres
    for($i=1;$i<=$nbrDePage;$i++){
        if($page!=$i)
            echo "<a href='?page=$i'>$i</a>&nbsp;";
        else
            echo "<a>$i</a>&nbsp;";
    }
    //affichage du suivant
    echo "<a  href='?page=$i++'>suivant</a>&nbsp;";
    ?>
    </div>

</body>
</html>