<?php
include ("head.inc.php");
include ("nav.inc.php");
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");
$db=db::get();

// Suppression
if(isset($_GET['btSupprimer'])){
	$reqSupprObj = $db->prepare('DELETE FROM '.config::get('db_prefixe').'tracked_objects where id = :id');
	$reqSupprObj->execute(array('id' => $_GET['btSupprimer']));
}

$reqObj = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'tracked_objects');
$reqObj->execute();
$resultObj = $reqObj->fetchAll();
?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			<h3>Contenu de la table tracked_objects</h3>
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
		<tr><th></th><th></th><th></th><th>id</th><th>nom</th><th>date_creation</th><th>active</th></tr>
		<?php foreach($resultObj as $row){ ?>
			<tr>
				<td>
					<form name="formSuppr" action="listeObj.inc.php" method="GET"><button type="submit" class="btn btn-default" name="btSupprimer" value="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash"></span></button></form>
				</td>
				<td>
					<form name="formModif" action="saisieObj.php" method="GET"><button type="submit" class="btn btn-default" name="btModifier" value="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></button></form>			
				</td>
				<td>	
					<form name="formDetail" action="detailObj.php" method="GET"><button type="submit" class="btn btn-default" name="btDetails" value="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-info-sign"></span></button></form>
				</td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['nom']; ?></td>
				<td><?php echo $row['date_creation']; ?></td>
				<td><?php echo $row['active']; ?></td>
			</tr>
		<?php } ?>
	</table>
	</div>
	<div class="col-md-1"></div>
</div>
<?php
include ("bottom.inc.php");
?>