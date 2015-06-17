<?php
include ("head.inc.php");
include ("nav.inc.php");
?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<h3>Liste des Proprietes</h3>
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
		<tr><th></th><th>id_tracked_objects</th><th>nom_prop</th><th>valeur_prop</th></tr>
		<tr><td><input type="checkbox"></td><td>4179</td><td>couleurD</td><td>#000000</td></tr>
		<tr><td><input type="checkbox"></td><td>4179</td><td>couleurG</td><td>#000000</td></tr>
		<tr><td><input type="checkbox"></td><td>4179</td><td>sexe</td><td>F</td></tr>
		<tr><td><input type="checkbox"></td><td>4179</td><td>naissance</td><td>2008</td></tr>
		<tr><td><input type="checkbox"></td><td>4278</td><td>couleurD</td><td>#000000</td></tr>
		<tr><td><input type="checkbox"></td><td>4278</td><td>couleurG</td><td>#ffcc00</td></tr>
		<tr><td><input type="checkbox"></td><td>4278</td><td>sexe</td><td>M</td></tr>
		<tr><td><input type="checkbox"></td><td>4278</td><td>naissance</td><td>2008</td></tr>
		<tr><td><input type="checkbox"></td><td>4273</td><td>couleurD</td><td>#80b127</td></tr>
		<tr><td><input type="checkbox"></td><td>4273</td><td>couleurG</td><td>#A60000</td></tr>
		<tr><td><input type="checkbox"></td><td>4273</td><td>sexe</td><td>F</td></tr>
		<tr><td><input type="checkbox"></td><td>4273</td><td>naissance</td><td>2008</td></tr>
		<tr><td><input type="checkbox"></td><td>5191</td><td>couleurD</td><td>#ffffff</td></tr>
		<tr><td><input type="checkbox"></td><td>5191</td><td>couleurG</td><td>#006699</td></tr>
		<tr><td><input type="checkbox"></td><td>5191</td><td>sexe</td><td>M</td></tr>
		<tr><td><input type="checkbox"></td><td>5191</td><td>naissance</td><td>2006</td></tr>
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