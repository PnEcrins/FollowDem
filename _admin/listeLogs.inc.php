<?php
include ("head.inc.php");
include ("nav.inc.php");
?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<h3>Liste des Logs</h3>
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
		<tr><th></th><th>id</th><th>date</th><th>log</th></tr>
		<tr><td><input type="checkbox"></td><td>1</td><td>2015-06-16 10:06:25</td><td>update objet id=4179--</td></tr>
		<tr><td><input type="checkbox"></td><td>2</td><td>2015-06-16 10:06:25</td><td>Ajout donnee id=4179 - id_objet :4179</td></tr>
		<tr><td><input type="checkbox"></td><td>3</td><td>2015-06-16 10:06:25</td><td>Donnees objet maj/ajoutée id=4179--</td></tr>
		<tr><td><input type="checkbox"></td><td>4</td><td>2015-06-16 10:06:25</td><td>update objet id=4179--</td></tr>
		<tr><td><input type="checkbox"></td><td>5</td><td>2015-06-16 10:06:25</td><td>Ajout donnee id=4179 - id_objet :4179</td></tr>
		<tr><td><input type="checkbox"></td><td>6</td><td>2015-06-16 10:06:25</td><td>Donnees objet maj/ajoutée id=4179--</td></tr>
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