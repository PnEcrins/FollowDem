<?php
include ("head.inc.php");
include ("nav.inc.php");
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");

if ($_POST['button'] == "Connexion"){
        
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
			$_SESSION['xauthor'] = $dat['identifiant'];
			$dernieracces = date("Y-m-d H:i:s");
			$query = ('UPDATE  '.config::get('db_prefixe').'users SET session_id = :session_id WHERE identifiant = :identifiant');
            $sth=$db->prepare($query);
            $sth->execute(array(
                ':session_id'=>session_id(),
                ':identifiant'=>$result[0]['identifiant']
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
<form name="formlogin" method="post" action="index.php">
	<p>&nbsp;</p>
	<div class="row">
		<div class="col-md-3"></div>
		<table class="col-md-6 table table-striped table-bordered table-hover table-condensed">
			<tr>
				<td><img src="../images/logo.jpg" alt="Parc national des Ecrins"></td>
			</tr>
		</table>
		<div class="col-md-3"></div>
	</div>
	
	<table class="col-md-6 table table-striped table-bordered table-hover table-condensed">
		<tr>
			<td>
				<span><b>IDENTIFICATION</b></span>
			</td>
		</tr>
		
		<? if (isset($erreur)){ ?>
		<tr><td><?=$erreur;?></td></tr>
		<? } ?>

		<tr>
			<td valign="top">Utilisateur</td>
			<td>
				<span id="vlogin">
					<input type="text" id="login" name="flogin" value="<?php if(isset($login)){echo $login;}?>">
				</span>
			</td>
		</tr>
		
		<tr>
			<td valign="top">Mot de passe</td>
			<td>
				<span id="vpassword"><input type="password" id="password" name="fpassword" value="<?php if(isset($password)){echo $password;}?>"></span>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" align="center"><input type="submit" name="button" id="button" value="Connexion"></td>
		</tr>
		
		<tr>
			<td colspan="2" bgcolor="#A9A7A8" align="center"><span class="Style4">&copy; 2015 - Parc national des Ecrins </span></td>
		</tr>
	</table>
</form>
<?php
include ("bottom.inc.php");
?>