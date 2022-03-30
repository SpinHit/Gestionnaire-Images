
<form method="post" action="">
        <div id="div_login">
            <h1>Connexion</h1>
            <div>
                <input type="text" class="textbox" id="user" name="user" placeholder="Pseudo" />
            </div>
            <div>
                <input type="password" class="textbox" id="pass" name="pass" placeholder="Mot de passe"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="envoyer" id="envoyer" />
            </div>
        </div>
    </form>
<?php

require('connexion.php');

$user = (isset($_POST["user"]) ? $_POST["user"] : null);
$pass = (isset($_POST["pass"]) ? $_POST["pass"] : null);

if(isset($_POST["user"]) && isset($_POST["pass"]))
{
		
	try
	{

		//sql 
		$stmt = $pdo->prepare("SELECT USERNAME, PASSWORD FROM USERS");

		//on execute
		$stmt->execute();
		
		//fetch
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		// on enregistre les infos
		$u = $result['USERNAME'];
		$p = $result['PASSWORD'];
		// si le user et le mdp correspondent alors on va dans le admin.php
		if($user == $u && $pass == $p)
		{
			$_SESSION['SESS_MEMBER_USER'] = $u;
			$_SESSION['SESS_MEMBER_PASS'] = $p;
			session_write_close();
			header("location: admin.php");
			exit();
		}
		else
		{ 
			// si il n'y apas le bon mdp on reviens a la case depart
			session_write_close();
			header("location: index.php");
			exit();
		}
		
	}
    catch(PDOException $e)
	{
		echo "Connection failed : " . $e->getMessage();
	}
}


?>