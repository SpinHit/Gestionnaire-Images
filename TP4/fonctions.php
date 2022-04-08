<?php

require('connexion.php');

// fonction pour téléversser l'image
 function insereBddDossier($pdo,$pname,$psize,$dest){
    $sql = "INSERT into images (file_name, size , chemin) VALUES ('$pname','$psize','$dest')";
    
     // dossier ou l'on va insserer les images 
    
     
    if ($_FILES['mon_fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
     // upload de l'image dans le dossier 
    $resultat = move_uploaded_file($_FILES['mon_fichier']['tmp_name'],$dest.$_FILES['mon_fichier']['name']);
    
    if ($resultat) $pdo->query($sql) ; echo "Transfert réussi"; header("Refresh:0");
    }
// fonction pour charger toutes les images du dossier docs
    function insereBddDossierCopy($pdo,$pname,$psize,$dest,$path_source){
        $sql = "INSERT into images (file_name, size , chemin) VALUES ('$pname','$psize','$dest')";
        
         // dossier ou l'on va insserer les images 
        
         // upload de l'image dans le dossier 
        $resultat = Copy($path_source,$dest.$pname);
        
        if ($resultat) $pdo->query($sql) ; 
    }
    // fonction permettant de supprimer une image
    function supprimeImg($pdo,$pname,$pid){
        // supression de l'image de la bdd
        $sql = "DELETE from `images` WHERE `id` = '$pid'";
        // suppression de l'image du dossier images
        $resultat = unlink("images/".$pname);
        if ($resultat) $pdo->query($sql) ; 

    }
    // fonction permettant de récupérer l'extention d'un fichier
    function recupExtention($fname) {
        return substr(strrchr($fname,'.'),1);
        }
?>