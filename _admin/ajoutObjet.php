<?php
include ("head.inc.php");
include ("nav.inc.php");
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");

// Initialisation des variables
$msgClass = "";
$message = "";
$titre = "";

// Changer titre de la page
if($_GET['action'] == "update"){
	$titre = "Modification d'un objet";
}
else{
	$titre = "Ajout d'un nouvel objet";
}

// Traitement du formulaire
if(isset($_POST['btConnect'])){
	if(isset($_POST['objId']) && isset($_POST['objNom']) && isset($_POST['objDateCreation']) && isset($_POST['objActive']) && !empty($_POST['objId']) && !empty($_POST['objNom']) && !empty($_POST['objDateCreation']) && !empty($_POST['objActive'])){
		
		$objId = $_POST['objId'];
		$objNom = $_POST['objNom'];
		$objDateCreation = $_POST['objJourCreation']." ".$_POST['objHeureCreation'];
		$objDateMaj = now();
		$objActive = $_POST['objActive'];
		
		$db=db::get();
		$requete = $db->prepare(
			'INSERT INTO '.config::get('db_prefixe').'tracked_objects(id,nom,date_creation,date_maj,active) 
			VALUES(
				:id,
				:nom,
				:date_creation,
				:date_maj,
				:active
			)'
		);
		
		$requete->execute(array(
			'id' => $objId,
			'nom' => $objNom,
			'date_creation' => $objDateCreation,
			'date_maj' => $objDateMaj,
			'active' => $objActive
			)
		);
		$message = 'ajout ok !';
		$msgClass = "text-success bs-callout-success bs-callout";
	}
	else{
		$message = 'ajout ko !';
		$msgClass = "text-danger bs-callout-danger bs-callout";
	}
	// Traitement des propriétés
	if(isset($_POST['objId']) && isset($_POST['propValeur1']) && isset($_POST['propValeur2']) && isset($_POST['propValeur3']) && isset($_POST['propValeur4']) && !empty($_POST['objId']) && !empty($_POST['propValeur1']) && !empty($_POST['propValeur2']) && !empty($_POST['propValeur3']) && !empty($_POST['propValeur4'])){
		
		$propIdObj = $_POST['objId'];
		$propNom1 = "naissance";
		$propValeur1 = $_POST['propValeur1'];
		$propNom2 = "couleurD";
		$propValeur2 = $_POST['propValeur2'];
		$propNom4 = "couleurG";
		$propValeur4 = $_POST['propValeur4'];
		$propNom3 = "sexe";
		$propValeur3 = $_POST['propValeur3'];
	
		$db=db::get();
		$requete = $db->prepare(
			'INSERT INTO '.config::get('db_prefixe').'tracked_objects(id_tracked_objects,nom_prop,valeur_prop) 
			VALUES(
				:id_tracked_objects,
				:nom_prop,
				:valeur_prop
			)'
		);
		
		$requete->execute(array(
			'id_tracked_objects' => $propIdObj,
			'nom_prop' => $propNom1,
			'valeur_prop' => $propValeur1
			)
		);
		
		$db=db::get();
		$requete = $db->prepare(
			'INSERT INTO '.config::get('db_prefixe').'tracked_objects(id_tracked_objects,nom_prop,valeur_prop) 
			VALUES(
				:id_tracked_objects,
				:nom_prop,
				:valeur_prop
			)'
		);
		
		$requete->execute(array(
			'id_tracked_objects' => $propIdObj,
			'nom_prop' => $propNom2,
			'valeur_prop' => $propValeur2
			)
		);
		
		$db=db::get();
		$requete = $db->prepare(
			'INSERT INTO '.config::get('db_prefixe').'tracked_objects(id_tracked_objects,nom_prop,valeur_prop) 
			VALUES(
				:id_tracked_objects,
				:nom_prop,
				:valeur_prop
			)'
		);
		
		$requete->execute(array(
			'id_tracked_objects' => $propIdObj,
			'nom_prop' => $propNom3,
			'valeur_prop' => $propValeur3
			)
		);
		
		$db=db::get();
		$requete = $db->prepare(
			'INSERT INTO '.config::get('db_prefixe').'tracked_objects(id_tracked_objects,nom_prop,valeur_prop) 
			VALUES(
				:id_tracked_objects,
				:nom_prop,
				:valeur_prop
			)'
		);
		
		$requete->execute(array(
			'id_tracked_objects' => $propIdObj,
			'nom_prop' => $propNom4,
			'valeur_prop' => $propValeur4
			)
		);
}
?>
<div id="decale"  class="text-center">
	<div class="jumbotron"><h2><?php echo("$titre"); ?></h2></div>
	<div class="row">
		<div class="col-md-3"></div>
		<div id="message" class="<?php echo $msgClass; ?> col-md-6"> <?php echo $message; ?></div>
		<div class="col-md-3"></div>
	</div>
	<form class="form-horizontal" name="monForm" action="ajoutObjet.php" method="POST">
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objId">Id</label>
			<div class="col-md-4">				
				<input class="form-control" type="text" placeholder="id de l'objet" name="objId" id="objId">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objNom">Nom</label>
			<div class="col-md-4">
				<input class="form-control" type="text" placeholder="nom de l'objet" name="objNom" id="objNom">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objDateCreation">Jour de création</label>
			<div class="col-md-4">
				<input class="form-control" type="date" placeholder="aaaa-mm-jj" name="objJourCreation" id="objDateCreation">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objDateCreation">Heure de création</label>
			<div class="col-md-4">
				<input class="form-control" type="text" placeholder="hh:mm:ss" name="objHeureCreation" id="objDateCreation">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objActive"></label>
			<div class="col-md-4">
				<input type="radio" name="objActive" value="1" id="objActive"> Objet actif
				&nbsp;&nbsp;
				<input type="radio" name="objActive" value="0" id="objActive" checked> Objet inactif
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur1">Naissance</label>
			<div class="col-md-4">
				<input class="form-control" type="text" placeholder="valeur de la propriété" name="propValeur1" id="propValeur1">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur3">Sexe</label>
			<div class="col-md-4">
				<input type="radio" name="propValeur3" value="M" id="propValeur3"> Masculin
				&nbsp;&nbsp;
				<input type="radio" name="propValeur3" value="F" id="propValeur3" checked> Féminin
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur2">Couleur primaire</label>
			<div class="col-md-4">
				<input class="form-control" type="text" placeholder="valeur de la propriété" name="propValeur2" id="propValeur2">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur4">Couleur secondaire</label>
			<div class="col-md-4">
				<input class="form-control" type="text" placeholder="valeur de la propriété" name="propValeur4" id="propValeur4">
			</div>
			<div class="col-md-3"></div>
		</div>		
		<div class="form-group">
			<div class="col-md-2"></div>
			<div class="col-md-offset-2 col-md-4">
				<input type="submit" class="btn btn-primary btn-lg btn-block" name="btConnect" value="Enregistrer">
			</div>
			<div class="col-md-3"></div>
		</div>
	</form>
</div>
<?php
include ("bottom.inc.php");
?>