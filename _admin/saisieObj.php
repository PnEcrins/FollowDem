<?php
include ("verification.inc.php");
include ("head.inc.php");
include ("nav.inc.php");

// Initialisation des variables
$msgClass = "";
$message = "";
$valueInactive = "checked";
$valueActive = "";
$valueNom = "";
$valueNaissance = "";
$valueSexeF = "checked";
$valueSexeM = "";
$valueCouleurD = "";
$valueCouleurG = "";
$id = "";
$valueJourCreation = "";
$valueHeureCreation = "";
$modif = "";

// Lorsque l'on arrive par le bouton modifier
if(!isset($_GET['btModifier']) && ($_GET['btModifier'] == "")){
	$titre = "Ajout d'un objet";
	$msgPopover = "Veuillez saisir un nombre entier, qui n'existe pas dans la base";
	$placeholderId = "id de l'objet";
	$modif = "";
}
else{
	$id = $_GET['btModifier'];
	$titre = "Modification de l'objet avec l'id ".$id;
	$modif = "ok";
	$placeholderId = $id;
	
	$db=db::get();	
	$reqObj = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'tracked_objects where id = :id ');
	$reqObj->execute(array('id' => $id));
	$resultObj = $reqObj->fetchAll();
	
	$reqProp = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'objects_features where id_tracked_objects = :id ');
	$reqProp->execute(array('id' => $id));
	$resultProp = $reqProp->fetchAll();

	foreach($resultObj as $valueObj)
	{
		$valueNom = $valueObj['nom'];
		$dateCreation = $valueObj['date_creation'];
		$valueJourCreation = substr($dateCreation,0,10);
		$valueHeureCreation = substr($dateCreation,11,8);
		if($valueObj['active'] == 1){
			$valueActive = "checked";
			$valueInactive = "";
		}
		else {
			$valueActive = "";
			$valueInactive = "checked";
		}
	}
	foreach($resultProp as $valueProp)
	{
		if($valueProp['nom_prop'] == "naissance"){
			$valueNaissance = $valueProp['valeur_prop'];
		}
		else{
			if($valueProp['nom_prop'] == "sexe"){
				if($valueProp['valeur_prop'] == "M"){
					$valueSexeM = "checked";
					$valueSexeF = "";
				}
				else {
					if($valueProp['valeur_prop'] == "F"){
						$valueSexeM = "";
						$valueSexeF = "checked";
					}
				}
			}
			else{
				if($valueProp['nom_prop'] == "couleurD"){
					$valueCouleurD = $valueProp['valeur_prop'];
				}
				else{
					if($valueProp['nom_prop'] == "couleurG"){
						$valueCouleurG = $valueProp['valeur_prop'];
					}
				}
			}
		}
	}
	$desactive = "readonly";
	$msgPopover = "";
}

// Traitement du formulaire
if(isset($_POST['btEnregistrer'])){
	
	if($modif != "ok"){
		
		if(isset($_POST['objId']) && isset($_POST['objNom']) && isset($_POST['objJourCreation']) && isset($_POST['objHeureCreation']) && isset($_POST['objActive']) && !empty($_POST['objId']) && !empty($_POST['objNom']) && !empty($_POST['objJourCreation']) && !empty($_POST['objHeureCreation']) && !empty($_POST['objActive']) && isset($_POST['objId']) && isset($_POST['propValeur1']) && isset($_POST['propValeur2']) && isset($_POST['propValeur3']) && isset($_POST['propValeur4']) && !empty($_POST['objId']) && !empty($_POST['propValeur1']) && !empty($_POST['propValeur2']) && !empty($_POST['propValeur3']) && !empty($_POST['propValeur4'])){
		
			// Traitement de l'ajout d'objet
			$objId = $_POST['objId'];
			$objNom = $_POST['objNom'];
			$traitementObjJourCreation = $_POST['objJourCreation'];
			$suiteTraitementObjJourCreation = substr($traitementObjJourCreation,6,4)."-".substr($traitementObjJourCreation,0,2)."-".substr($traitementObjJourCreation,3,2);
			$objDateCreation = $suiteTraitementObjJourCreation." ".$_POST['objHeureCreation'];
			$objDateMaj = date('Y-m-d')." ".date('h:i:s');
			$objActive = $_POST['objActive'];
			
			$db=db::get();
			$requeteAjoutObj = $db->prepare(
				'INSERT INTO '.config::get('db_prefixe').'tracked_objects(id,nom,date_creation,date_maj,active) 
				VALUES(
					:id,
					:nom,
					:date_creation,
					:date_maj,
					:active
				)'
			);
			
			$requeteAjoutObj ->execute(array(
				'id' => $objId,
				'nom' => $objNom,
				'date_creation' => $objDateCreation,
				'date_maj' => $objDateMaj,
				'active' => $objActive
				)
			);
			
		// Traitement de l'ajout de propriétés à l'objet
			
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
			$requeteAjoutProp = $db->prepare(
				'INSERT INTO '.config::get('db_prefixe').'objects_features(id_tracked_objects,nom_prop,valeur_prop) 
				VALUES(
					:id_tracked_objects,
					:nom_prop,
					:valeur_prop
				)'
			);
			
			$requeteAjoutProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom1,
				'valeur_prop' => $propValeur1
				)
			);
			
			$requeteAjoutProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom2,
				'valeur_prop' => $propValeur2
				)
			);
			
			$requeteAjoutProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom3,
				'valeur_prop' => $propValeur3
				)
			);
			
			$requeteAjoutProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom4,
				'valeur_prop' => $propValeur4
				)
			);
			
			$message = "L'ajout à la base de données a été réalisé avec succès !";
			$msgClass = "text-success bs-callout-success bs-callout";
		}
		else{
			$message = "L'ajout à la base de données a échoué !";
			$msgClass = "text-danger bs-callout-danger bs-callout";
		}
	}
	
	// Traitement des modifications d'un objet
	else{
		if(isset($_POST['objId']) && isset($_POST['objNom']) && isset($_POST['objJourCreation']) && isset($_POST['objHeureCreation']) && isset($_POST['objActive']) && !empty($_POST['objId']) && !empty($_POST['objNom']) && !empty($_POST['objJourCreation']) && !empty($_POST['objHeureCreation']) && !empty($_POST['objActive']) && isset($_POST['objId']) && isset($_POST['propValeur1']) && isset($_POST['propValeur2']) && isset($_POST['propValeur3']) && isset($_POST['propValeur4']) && !empty($_POST['objId']) && !empty($_POST['propValeur1']) && !empty($_POST['propValeur2']) && !empty($_POST['propValeur3']) && !empty($_POST['propValeur4'])){
			
			$objId = $_POST['objId'];
			$objNom = $_POST['objNom'];
			$objDateCreation = $_POST['objJourCreation']." ".$_POST['objHeureCreation'];
			$objDateMaj = date('Y-m-d')." ".date('h:i:s');
			$objActive = $_POST['objActive'];
			
			$db=db::get();
			$requeteModifObj = $db->prepare(
				'UPDATE '.config::get('db_prefixe').'tracked_objects 
				SET nom = :nom,
				date_creation = :date_creation, 
				date_maj = :date_maj, 
				active = :active 
				WHERE id = :id'
			);
			
			$requeteModifObj ->execute(array(
				'nom' => $objNom,
				'date_creation' => $objDateCreation,
				'date_maj' => $objDateMaj,
				'active' => $objActive,
				'id' => $objId
				)
			);
			// Traitement des modifications des propriétés d'un objet
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
			$requeteModifProp = $db->prepare(
				'UPDATE '.config::get('db_prefixe').'objects_features 
				SET nom_prop = :nom_prop,
				valeur_prop = :valeur_prop
				WHERE id_tracked_objects = :id_tracked_objects'
			);
			$requeteModifProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom1,
				'valeur_prop' => $propValeur1
				)
			);
			$requeteModifProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom2,
				'valeur_prop' => $propValeur2
				)
			);			
			$requeteModifProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom3,
				'valeur_prop' => $propValeur3
				)
			);			
			$requeteModifProp ->execute(array(
				'id_tracked_objects' => $propIdObj,
				'nom_prop' => $propNom4,
				'valeur_prop' => $propValeur4
				)
			);
			$message = "L'ajout à la base de données a été réalisé avec succès !";
			$msgClass = "text-success bs-callout-success bs-callout";
		}
		else{
			$message = "L'ajout à la base de données a échoué !";
			$msgClass = "text-danger bs-callout-danger bs-callout";
		}
	}
}
?>
<div id="decale"  class="text-center">
	<div class="jumbotron"><h2><?php echo("$titre"); ?></h2></div>
	<div class="row">
		<div class="col-md-3"></div>
		<div id="message" class="<?php echo $msgClass; ?> col-md-6"> <?php echo $message; ?></div>
		<div class="col-md-3"></div>
	</div>
	<form class="form-horizontal" name="monForm" action="saisieObj.php" method="POST">
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objId">Id</label>
			<div class="col-md-4">				
				<input class="form-control"  <?php echo $desactive; ?> type="text" placeholder="<?php echo $placeholderId; ?>" name="objId" id="objId" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $msgPopover; ?>">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objNom">Nom</label>
			<div class="col-md-4">
				<input class="form-control" type="text" value="<?php echo $valueNom ;?>" placeholder="nom de l'objet" name="objNom" id="objNom" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Veuillez saisir le nom de l'objet">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objJourCreation">Jour de création</label>
			<div class="col-md-4 input-group date">
				<input class="form-control" type="text" value="<?php echo $valueJourCreation ;?>" placeholder="aaaa-mm-jj" name="objJourCreation" id="objJourCreation"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objHeureCreation">Heure de création</label>
			<div class="col-md-4">
				<input class="form-control" type="text" value="<?php echo $valueHeureCreation ;?>" placeholder="hh:mm:ss" name="objHeureCreation" id="objHeureCreation" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Veuillez saisir l'heure où vous recevez la 1ère donnée">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="objActive">Etat de l'objet</label>
			<div class="col-md-4 text-left">
				<input type="radio" name="objActive" value="1" id="objActive" <?php echo $valueActive; ?>> Objet actif
				&nbsp;&nbsp;
				<input type="radio" name="objActive" value="0" id="objActive" <?php echo $valueInactive; ?>> Objet inactif
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur1">Naissance</label>
			<div class="col-md-4">
				<input class="form-control" type="text" value="<?php echo $valueNaissance ;?>" placeholder="année de naissance" name="propValeur1" id="propValeur1" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Veuillez saisir l'année de naissance (ex : 2006)">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur3">Sexe</label>
			<div class="col-md-4 text-left">
				<input type="radio" name="propValeur3" value="M" id="propValeur3" <?php echo $valueSexeM; ?>> Masculin
				&nbsp;&nbsp;
				<input type="radio" name="propValeur3" value="F" id="propValeur3" <?php echo $valueSexeF; ?>> Féminin
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur2">Couleur droite</label>
			<div class="col-md-4">
				<input class="form-control color {hash:true}" type="text" value="<?php echo $valueCouleurD ;?>" placeholder="valeur HTML de la couleur (ex : #000000)" name="propValeur2" id="propValeur2" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Veuillez saisir la valeur HTML de la couleur (ex : #000000)">
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="form-group">
			<div class="col-md-2"></div>
			<label class="col-md-2 control-label" for="propValeur4">Couleur gauche</label>
			<div class="col-md-4">
				<input class="form-control color {hash:true}" type="text" value="<?php echo $valueCouleurG ;?>" placeholder="valeur HTML de la couleur (ex : #FFFFFF)" name="propValeur4" id="propValeur4" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Veuillez saisir la valeur HTML de la couleur (ex : #FFFFFF)">
			</div>
			<div class="col-md-3"></div>
		</div>		
		<div class="form-group">
			<div class="col-md-2"></div>
			<div class="col-md-offset-2 col-md-4">
				<input type="submit" class="btn btn-primary btn-lg btn-block" name="btEnregistrer" value="Enregistrer" id="btEnregistrer" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Vérifiez que tous les champs ont été correctement remplis">
			</div>
			<div class="col-md-3"></div>
		</div>
	</form>
</div>
<?php
include ("bottom.inc.php");
?>