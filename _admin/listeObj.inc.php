<?php
include ("head.inc.php");
include ("nav.inc.php");
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
	<table class="table table-striped table-bordered">
		<tr><th></th><th>id</th><th>nom</th><th>date_creation</th><th>date_maj</th><th>active</th></tr>
		<tr><td><input type="checkbox"></td><td>4179</td><td>Object_1</td><td>NULL</td><td>2015-06-01 11:00:00</td><td>1</td></tr>
		<tr><td><input type="checkbox"></td><td>4278</td><td>Object_2</td><td>2015-05-23 00:00:00</td><td>2015-06-01 07:00:00</td><td>1</td></tr>
		<tr><td><input type="checkbox"></td><td>4273</td><td>Object_3</td><td>2015-05-07 11:00:00</td><td>2015-06-01 07:00:00</td><td>1</td></tr>
		<tr><td><input type="checkbox"></td><td>5191</td><td>Object_4</td><td>2015-06-01 11:00:00</td><td>2015-06-01 11:06:10</td><td>1</td></tr>
	</table>
	</div>
	<div class="col-md-1"></div>	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-2">
			<button type="button" class="btn btn-primary btn-lg btn-block" id="btModifier">Modifier</button>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-primary btn-lg btn-block" id="btDetail">Details</button>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-primary btn-lg btn-block" id="btSupprimer">Supprimer</button>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
<?php
include ("bottom.inc.php");
?>