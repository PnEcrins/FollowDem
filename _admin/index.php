<?php
include ("head.inc.php");
include ("nav.inc.php");
include ("accueil.inc.php");
include ("bottom.inc.php");

include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");

if ($_POST['button'] == "CONNEXION"){
        
	$login = $_POST['flogin'];
	$password = $_POST['fpassword'];
	$passmd5 = md5($_POST['fpassword']);
	$erreur = '';
    
	$db = db::get();
	
	$query = 'SELECT identifiant, pass, nom_user, prenom_user FROM '.config::get('db_prefixe').'users WHERE identifiant = :login AND pass = :pass';
    $sth=$db->prepare($query);
    $sth->execute(array(':login'=>$login,':pass'=>$passmd5));
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    
		if (count($result) === 1)
		{
		session_start();
			if (isset($_POST['flogin'])){
			$_SESSION['xlogin'] = $login;
			$_SESSION['xauthor'] = $dat['id_user'];
			$dernieracces = date("Y-m-d H:i:s");
			$query = ('UPDATE  '.config::get('db_prefixe').'users SET session_id = :session_id WHERE id_user = :id_user');
            $sth=$db->prepare($query);
            $sth->execute(array(
                ':session_id'=>session_id(),
                ':id_user'=>$result[0]['id_user']
            ));
			header("Location: listeObj.inc.php");
			}
		}
		
		else{
		$erreur='<img src="images/supprimer.gif" alt="" align="absmiddle">&nbsp;Identification incorrecte ou droits insuffisants';
		}
}
else{
	session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
	    setcookie(session_name(), '', time()-3600, '/');
	}
	session_destroy();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Suivi aigle - Identification</title>
		<style type="text/css">
			<!--
			body {
				background-color: #D7E3B5;
				font-family: Trebuchet MS;
				font-weight: normal;
				font-size: 10pt;
			}
			-->
		</style>
	</head>
	<body>
		<form name="formlogin" method="post" action="index.php">
		  <p>&nbsp;</p>
		  <table width="300" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0" valign="center" align="center">
		<tr>
			<td colspan="2" align="center" bgcolor="#740160"><img src="../images/logo.jpg" alt="Parc national des Ecrins" border="1" style="border-color:#f0f0f0"></td>
		</tr>
		</table>
		 <table width="300" border="0" cellspacing="2" cellpadding="10" bgcolor="#f0f0f0" align="center">
			<tr>
				<td colspan="2" bgcolor="#FCFDAF" align="center">
					<span class="Style1"><b>IDENTIFICATION</b></span>
				</td>
			</tr>
		  <? if (isset($erreur)){ ?>
		  <tr><td colspan="2" class="Style1"><?=$erreur;?></td></tr>
		  <? } ?>

		  <tr>
		    <td valign="top">Utilisateur</td>
		    <td><span id="vlogin"><input type="text" class="Style2" id="login" name="flogin" value="<?php if(isset($login)){echo $login;}?>" size="25"></span>
			</td>
		  </tr>
		  <tr>
		    <td valign="top">Mot de passe</td>
		    <td><span id="vpassword"><input type="password" class="Style2" id="password" name="fpassword" value="<?php if(isset($password)){echo $password;}?>" size="25"></span>
			</td>
		  </tr>
		  <tr>
		    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="CONNEXION">    </td>
		  </tr>
		  <tr>
		  	<td colspan="2" bgcolor="#A9A7A8" align="center"><span class="Style4">&copy; 2015 - Parc national des Ecrins </span></td>
		  </tr>
		</table>
		</form>
	</body>
</html>