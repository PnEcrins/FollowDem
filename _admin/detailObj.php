<?php
include("./head.inc.php");
include("./nav.inc.php");
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");

// Récupération de l'id
$id = $_GET['btDetails'];

// Récupération de l'objet
$db=db::get();
$reqObj = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'tracked_objects where id = :id ');
$reqObj->execute(array('id' => $id));
$resultObj = $reqObj->fetchAll();

// Récupération de ses propriétés
$reqProp = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'objects_features where id_tracked_objects = :id ');
$reqProp->execute(array('id' => $id));
$resultProp = $reqProp->fetchAll();
?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			<h3>Details d'un Objet</h3>
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
		<tr><th>id</th><th>nom</th><th>date_creation</th><th>date_maj</th><th>active</th></tr>
		<?php foreach($resultObj as $rowObj){ ?>
			<tr>
				<td><?php echo $rowObj['id']; ?></td>
				<td><?php echo $rowObj['nom']; ?></td>
				<td><?php echo $rowObj['date_creation']; ?></td>
				<td><?php echo $rowObj['date_maj']; ?></td>
				<td><?php echo $rowObj['active']; ?></td>
			</tr>
		<?php } ?>
		<tr><th>id_tracked_objects</th><th>nom_prop</th><th>valeur_prop</th></tr>
		<?php foreach($resultProp as $rowProp){ ?>
			<tr>
				<td><?php echo $rowProp['id_tracked_objects']; ?></td>
				<td><?php echo $rowProp['nom_prop']; ?></td>
				<td><?php echo $rowProp['valeur_prop']; ?></td>
			</tr>
		<?php } ?>
	</table>
	</div>
	<div class="col-md-1"></div>
</div>
<?php
include("./bottom.inc.php");
?>