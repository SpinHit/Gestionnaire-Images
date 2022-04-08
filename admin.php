    <!-- script pour afficher les icones -->
 <script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>
 <?php
require('connexion.php');
try{



// pagination 
$nbrElementParPage = 4;

// mettre par defaut l'index sur la page 1
if(isset($_GET['page']) && !empty($_GET['page'])){
     $page = (int) strip_tags($_GET['page']);
   }else{
     $page = 1;
   }

   $debut=($page-1)* $nbrElementParPage;


$sql2 = "SELECT id,chemin,file_name from images order by id DESC limit $debut,$nbrElementParPage";

$pdo = new PDO($dsn, $dbusername, $dbpassword);
// on execute la requete sql
$stmt = $pdo->query($sql2);

// on récupére les lignes
$rows = $stmt->fetchAll();

$var = $pdo->prepare('SELECT COUNT(*) from images') ;
$var->execute();
$nbrDelignes = $var->fetch(PDO::FETCH_NUM);
$nbrDePage = ceil($nbrDelignes[0]/ $nbrElementParPage);

if($stmt === false){
     die("Erreur");
  }
  
 }catch (PDOException $e){
     echo $e->getMessage();
 }

 require('fonctions.php');


// nom de l'image

if(isset($_FILES["mon_fichier"])){
$pname = $_FILES['mon_fichier']['name'];
$psize = $_FILES['mon_fichier']['size'];
$dest = "images/";



// on insert la vleur nom de l'image dans nom_image(bdd)
insereBddDossier($pdo,$pname,$psize,$dest);


}


?>

<!-- Partie HTML-->
<center>
<h1>Gestion d'images</h1><br/>
 
 <form method="post" enctype="multipart/form-data">
      <label for="mon_fichier">Veuiller choisir une image a téléversser :</label>
      <input type="file" name="mon_fichier" id="mon_fichier" accept="images/png, images/jpeg, images/jpg, images/gif" />
      <input type="submit" name="submit" value="Envoyer" />
 </form>

<!-- on va afficher image par image et l'id avec-->
<div id="listePagination">
    <?php $i=0; foreach($rows as $row): ?>
        <img src="<?= $row['chemin'],$row['file_name'] ; ?>" alt="" />
        <span><?= $row['id'] ; ?></span>
<<<<<<< Updated upstream
        <a href='admin.php?supprime=true'>Supprimer</a>
=======
        <a href='<?php echo "admin.php?idImage=" . $row['id'] ?>'>Supprimer</a>
>>>>>>> Stashed changes
        
        <?php $i++; if($i%2==0){ ?> <br> <?php } ?>
        
    <?php endforeach; 

<<<<<<< Updated upstream
    if (isset($_GET['supprime'])) {
    // on lance la fonction pour supprimer
    supprimeImg($pdo,$row['file_name'],$row['id']);
=======
    if (isset($_GET['idImage'])) {
    // on lance la fonction pour supprimer
    supprimeImg($pdo,$row['file_name'],$_GET['idImage']);
>>>>>>> Stashed changes
    header("location: admin.php");
    } ?>
    </div>


    <!-- création des boutons en fonction du nombre de page-->
    <div id="pagination">
    <?php
    // affichage des chiffres
    for($i=1;$i<=$nbrDePage;$i++){
        if($page!=$i)
            echo "<a href='?page=$i'>$i</a>&nbsp;";
        else
            echo "<a>$i</a>&nbsp;";
    }

    ?>
    </div>


<div id='bouttonscan'>
<a href='admin.php?scan=true'>Scan</a>
</div>

<?php 
// imporation du module pour afficher transferer les fichiers
include 'scan.php'; ?>

<center/>

<style>
<?php include 'style.css'; ?>

div#listePagination {
padding-left: 6%;
}
</style>
