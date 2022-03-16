<h1>Gestion d'images</h1><br/>
 
 <form method="post" enctype="multipart/form-data">
      <label for="mon_fichier">Fichier :</label><br />
      <input type="file" name="mon_fichier" id="mon_fichier" /><br />
      <input type="submit" name="submit" value="Envoyer" />
 </form>

 <?php
// on se login a la bdd
$localhost = "localhost"; 
$dbusername = "root"; 
$dbpassword = "";  
$dbname = "testexo2";  
 

$conn = mysqli_connect($localhost,$dbusername,$dbpassword,$dbname);
// nom de l'image
$pname = $_FILES['mon_fichier']['name'];
// on insert la vleur nom de l'image dans nom_image(bdd)
$sql = "INSERT into images (nom_image) VALUES ('$pname')";
$conn->query($sql);
 // dossier ou l'on va insserer les images 
$dest = "images/";
 
if ($_FILES['mon_fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
 // upload de l'image dans le dossier 
$resultat = move_uploaded_file($_FILES['mon_fichier']['tmp_name'],$dest.$_FILES['mon_fichier']['name']);
 
if ($resultat) echo "Transfert réussi";
 
?>