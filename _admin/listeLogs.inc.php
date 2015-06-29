<?php
include ("verification.inc.php");
include ("head.inc.php");
include ("nav.inc.php");

$cpt = 0;
if (isset($_GET['btSuivant'])){
	$nbDepart = 15;
	$nbDepart = $_GET['btSuivant'];
	$cpt = $nbDepart + 15;
	$db=db::get();
	$reqLog = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'logs LIMIT '.$cpt.',15');
	$reqLog->execute();
	$resultLog = $reqLog->fetchAll();
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
	$reqLog = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'logs LIMIT '.$cpt.',15');
	$reqLog->execute();
	$resultLog = $reqLog->fetchAll();
	}
	else{
		$db=db::get();
		$reqLog = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'logs LIMIT 0,15');
		$reqLog->execute();
		$resultLog = $reqLog->fetchAll();
	}
}
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
		<?php }	?>
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
				<button type="submit" name="btSuivant" value="<?php if(count($resultLog) < 15){ echo($nbDepart); $disable="disabled"; }else{ echo $cpt; $disable=""; } ?>" id="btSuivant" class="btn btn-primary btn-lg btn-block <?php echo $disable; ?>">Suivant</button>
			</div>
			<div class="col-md-3"></div>
		</div>
	</form>
</div>
<?php
include ("bottom.inc.php");
?>