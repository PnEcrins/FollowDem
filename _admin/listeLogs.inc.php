<?php
include ("verification.inc.php");
include ("head.inc.php");
include ("nav.inc.php");
// include ("../config/config.php");
// include ("../classes/db.class.php");
// include ("../classes/config.class.php");
$db=db::get();
$reqLog = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'logs');
$reqLog->execute();
$resultLog = $reqLog->fetchAll();

?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<h3>Contenu de la table logs</h3>
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
		<tr><th>id</th><th>date</th><th>log</th></tr>
		<?php foreach($resultLog as $row){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['date']; ?></td>
				<td><?php echo $row['log']; ?></td>
			</tr>
		<?php } ?>
	</table>
	</div>
	<div class="col-md-1"></div>
</div>
<?php
include ("bottom.inc.php");
?>