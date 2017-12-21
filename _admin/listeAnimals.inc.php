<?php
include ("verification.inc.php");
include ("head.inc.php");
include ("nav.inc.php");

$db=db::get();

// Suppression
if(isset($_GET['btSupprimer'])){
	$reqSupprObj = $db->prepare('DELETE FROM '.config::get('db_prefixe').'animal where id = :id');
	$reqSupprObj->execute(array('id' => $_GET['btSupprimer']));
	$reqSupprProp = $db->prepare('DELETE FROM '.config::get('db_prefixe').'animal where id_animal = :id_animal');
	$reqSupprProp->execute(array('id_animal' => $_GET['btSupprimer']));
}

$cpt = 0;
if (isset($_GET['btSuivant'])){
	$nbDepart = 15;
	$nbDepart = $_GET['btSuivant'];
	$cpt = $nbDepart + 15;
	$db=db::get();
	$reqObj = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'animal LIMIT '.$cpt.',15');
	$reqObj->execute();
	$resultObj = $reqObj->fetchAll();
}
else{
	if (isset($_GET['btPrecedent'])){
	$nbDepart2 = 0;
	$nbDepart2 = $_GET['btPrecedent'];
	if ($nbDepart2 <= 0){
		$cpt = 0;
		$disable2 = "disabled";
	}
	else{
		$cpt = $nbDepart2 - 15;
		$disable2 = "";
	}
	$db=db::get();
	$reqObj = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'animal LIMIT '.$cpt.',15');
	$reqObj->execute();
	$resultObj = $reqObj->fetchAll();
	}
	else{
		$db=db::get();
		$reqObj = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'animal LIMIT 0,15');
		$reqObj->execute();
		$resultObj = $reqObj->fetchAll();
	}
}
?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			<h3>Contenu de la table animal</h3>
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-4">
			<form class="navbar-form" role="rechercher">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Rechercher" name="rechercher" id="idRechercher">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-1"></div>	
	</div>	
	<div class="col-md-1"></div>
	<div class="col-md-10">	
	<table class="table table-striped table-bordered table-hover table-condensed">
		<tr><th></th><th></th><th></th><th>Id</th><th>Name</th><th>Creation date</th><th>Sexe</th><th>Active</th></tr>
		<?php foreach($resultObj as $row){ ?>
			<tr>
				<td>
					<form name="formSuppr" action="listeAnimals.inc.php" method="GET"><button type="submit" class="btn btn-default" name="btSupprimer" value="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash"></span></button></form>
				</td>
				<td>
					<form name="formModif" action="saisieObj.php" method="GET"><button type="submit" class="btn btn-default" name="btModifier" value="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></button></form>			
				</td>
				<td>	
					<form name="formDetail" action="detailObj.php" method="GET"><button type="submit" class="btn btn-default" name="btDetails" value="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-info-sign"></span></button></form>
				</td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['ani_name']; ?></td>
                <td><?php echo $row['creation_date']; ?></td>
                <td><?php echo $row['sexe']; ?></td>
				<td><?php echo $row['active']; ?></td>
			</tr>
		<?php } ?>
	</table>
	</div>
	<div class="col-md-1"></div>
		<form action="" method="GET" class="form-horizontal" name="monForm">
		<div class="form-group">
			<div class="col-md-2"></div>
			<div class="col-md-offset-2 col-md-2">
				<button type="submit" name="btPrecedent" value="<?php echo $cpt; ?>" id="btPrecedent" class="btn btn-primary btn-lg btn-block <?php echo $disable2; ?>">Précédent</button>
			</div>
			<div class="col-md-2">
				<button type="submit" name="btSuivant" value="<?php if(count($resultLog) < 15){ echo($nbDepart); $disable="disabled"; }else{ echo $cpt; $disable="";} ?>" id="btSuivant" class="btn btn-primary btn-lg btn-block <?php echo $disable; ?>">Suivant</button>
			</div>
			<div class="col-md-3"></div>
		</div>
	</form>
</div>
<?php
include ("bottom.inc.php");
?>