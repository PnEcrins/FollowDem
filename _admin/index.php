<?php
include ("head.inc.php");
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");

if (isset($_POST['button']) && $_POST['button'] == "Connexion"){
        
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
			header("Location: listeObj.inc.php?btPrecedent=0");
			}
		}
		
		else{
		$erreur='<div class="text-danger bs-callout-danger bs-callout col-md-6">Identification incorrecte ou droits insuffisants.</div>';
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
<div id="decale"  class="text-center">
	<div class="row">
		<div class="col-md-3"></div>
			<div class="col-md-6">
				<img src="../images/logo.jpg" alt="Parc national des Ecrins">
			</div>
		<div class="col-md-3"></div>
	</div>
	<div class="jumbotron"><h2>Identification</h2></div>
		
	<? if (isset($erreur)){ ?>
	<div class="row">
		<div class="col-md-3"></div>
		<?=$erreur;?>
		<div class="col-md-3"></div>
	</div>
	<? } ?>
		
	<form class="form-horizontal" name="formlogin" method="post" action="index.php">
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label">Utilisateur</label>
			<div class="col-md-4">
					<!-- <span id="vlogin"> -->
				<input class="form-control" type="text" id="login" name="flogin" value="<?php if(isset($login)){echo $login;}?>" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Veuillez saisir votre identifiant">
					<!-- </span> -->
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label">Mot de passe</label>
			<div class="col-md-4">
					<!-- <span id="vpassword"> -->
				<input class="form-control" type="password" id="password" name="fpassword" value="<?php if(isset($password)){echo $password;}?>" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Veuillez saisir votre mot de passe">
					<!-- </span> -->
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<div class="col-md-offset-2 col-md-4">
				<input class="btn btn-primary btn-lg btn-block" type="submit" name="button" id="button" value="Connexion" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Vérifiez que tous les champs ont été correctement remplis">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="row">
			<div class="col-md-3"></div>
				<div class="col-md-6">&copy; 2015 - Parc national des Ecrins</div>
			<div class="col-md-3"></div>
		</div>
	</form>
</div>
<?php
include ("bottom.inc.php");
?>