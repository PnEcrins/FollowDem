<?php
include ("head.inc.php");
include ("nav.inc.php");
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");

// Initialisation des variables
$msgClass = "";
$message = "";


// Traitement du formulaire
if(isset($_POST['btConnect'])){
	if(isset($_POST['objId']) && isset($_POST['objNom']) && isset($_POST['objDateCreation']) && isset($_POST['objActive']) && !empty($_POST['objId']) && !empty($_POST['objNom']) && !empty($_POST['objDateCreation']) && !empty($_POST['objActive'])){
		
		$objId = $_POST['objId'];
		$objNom = $_POST['objNom'];
		$objDateCreation = $_POST['objDateCreation'];
		$objDateMaj = $_POST['objDateMaj'];
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
			'date_maj' => 'now()',
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
}
?>
<div id="decale"  class="text-center">
	<div class="jumbotron"><h2>Ajout d'un nouvel objet</h2></div>
	<div class="row">
		<div class="col-md-3"></div>
		<div id="message" class="<?php echo $msgClass; ?> col-md-6"> <?php echo $message; ?></div>
		<div class="col-md-3"></div>
	</div>
	<form class="form-horizontal" name="monForm" action="ajoutObjet.php" method="POST">
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objId">id</label>
			<div class="col-md-4">				
				<input class="form-control" type="text" placeholder="id de l'objet" name="objId" id="objId">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objNom">nom</label>
			<div class="col-md-4">
				<input class="form-control" type="text" placeholder="nom de l'objet" name="objNom" id="objNom">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objDateCreation">date_creation</label>
			<div class="col-md-4">
				<input class="form-control" type="datetime" placeholder="aaaa-mm-jj hh:mm:ss" name="objDateCreation" id="objDateCreation">
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