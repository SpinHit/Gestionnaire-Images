

<?php
require('connexion.php');


//
set_time_limit (500);
$path= "docs";


// code pour en faire en sorte d'avoir toute la fonction dans un bouton .
  if (isset($_GET['scan'])) {
	?></center>
	<footer><?php
    explorerDir($pdo,$path);
	?></footer>
	<center><?php
}


function explorerDir($pdo,$path)

{
	// ouvre le dossier
	$folder = opendir($path);
	
	//tant qu'on lis les entrées du fichier
	while($entree = readdir($folder))
	{		
		// si la variable $entree est différente de . et ..
		if($entree != "." && $entree != "..")
		{
			// si un dossier est présent
			if(is_dir($path."/".$entree))
			{
				// on affiche un logo pour le fichier
				echo "<p><i class='far fa-folder-open'> </i> ".$entree."<p> <br> ";
				// met le chemin courant dans une variable
				$sav_path = $path;
				// met le chemin du dossier qu'il a trouvé dans une variable
				$path .= "/".$entree;
                
				// fait un appel récursive avec le nouveau chemin (il va explorer le nouveau dossier trouver)		
				explorerDir($pdo,$path);
				// met l'ancien chemin courant afin de continué à le parcourir
				$path = $sav_path;

			}
			else
			{
				//switch pour afficher un logo en fonction de l'extention
				$extention = recupExtention($entree);
				switch ($extention) {
					case 'txt':
						echo " <p>ㅤㅤㅤㅤ <i class='far fa-file'></i> ".$entree."</p><br>";
						break;
					case 'html':
						echo " <p>ㅤㅤㅤㅤ <i class='far fa-file-code'></i> ".$entree."</p><br>";
						break;
					default :
					echo " <p>ㅤㅤㅤㅤ <i class='far fa-image'></i> ".$entree."</p><br>";
					}

				
				// c'est le chemin entier de l'entrée + le nom de l'entrée
				$path_source = $path."/".$entree;	
                    
                $extensionValide = array("png", "jpg", "jpeg", "gif", "jfif");
                $tmp = explode(".", $entree);
                $type = end($tmp);
                // on regarde si l'entrée est une image  et on lance la fonction pour mettre l'image dans le dossier local et mettre les informations dans la bdd .
                if (in_array($type,$extensionValide)){
					//fonction permettant de transferer toutes les images du fichier docs a la base de donnée et les verssée dans le dossier image
                  insereBddDossierCopy($pdo,$entree,filesize($path_source),"images/",$path_source);
                }

			}
		}
	}
    ?></div><?php
	closedir($folder);  
}
?>