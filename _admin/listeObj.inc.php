<?php
include ("head.inc.php");
include ("nav.inc.php");
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");
$db=db::get();
$requete = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'tracked_objects');
$requete->execute();
$results = $requete->fetchAll();

// Suppression
if(isset($_POST['btSupprimer'])){
	$requete = $db->prepare('DELETE FROM '.config::get('db_prefixe').'tracked_objects where id = :id');
	$requete->execute(array('id' => $_GET['id']));
}

// Modification
/* if(isset($_POST['btModifier'])){
	$requete = $db->prepare('UPDATE'.config::get('db_prefixe').'tracked_objects SET nom=?,date_maj=?,active=? WHERE id=?');
	$requete->execute(array());
} */
?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<h3>Liste des Objets</h3>
		</div>
		<div class="col-md-2"></div>
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
		<tr><th></th><th>id</th><th>nom</th><th>date_creation</th><th>active</th></tr>
		<?php foreach($results as $row){ ?>
			<tr>
				<td>
					<form name="formSuppr" action="listeObj.inc.php?action=delete&id=<?php echo $row['id']; ?>" method="GET"><button type="submit" class="btn btn-default" name="btSupprimer"><span class="glyphicon glyphicon-trash"></span></button></form>
					<form name="formModif" action="objet.php?action=update&id=<?php echo $row['id']; ?>" method="GET"><button type="submit" class="btn btn-default" name="btModifier"><span class="glyphicon glyphicon-pencil"></span></button></form>			
					<form name="formDetail" action="listeObj.inc.php?action=show&id=<?php echo $row['id']; ?>" method="GET"><button type="submit" class="btn btn-default" name="btDetails"><span class="glyphicon glyphicon-info-sign"></span></button></form>
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