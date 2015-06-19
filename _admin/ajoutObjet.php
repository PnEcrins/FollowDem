<?php
include ("head.inc.php");
include ("nav.inc.php");
?>
<form name="monForm" action="listeObj.inc.php" method="POST">
<div class="jumbotron">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="form-group col-md-4">
			<label for="idLogin">id</label>
			<input class="form-control input-lg" type="text" placeholder="id de l'objet" id="idLogin">
		</div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="form-group col-md-4">
			<label for="idPwd">nom</label>
			<input class="form-control input-lg" type="text" placeholder="nom de l'objet" id="idPwd">
		</div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="form-group col-md-4">
			<label for="idPwd">date_creation</label>
			<input class="form-control input-lg" type="date" placeholder="date de creation" id="idPwd">
			<input  hidden class="form-control input-lg" type="text" placeholder="date_maj" id="idPwd">
		</div>
		<div class="col-md-4"></div>
	</div>			
	<div class="row">
		<div class="col-md-4"></div>
		<div class="form-group col-md-4">
			<label for="idPwd">active</label>
			<checkbox>
		</div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<a type="button" class="btn btn-primary btn-lg btn-block" name="btConnect" href="./traitement.php">Ajouter objet</a>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
</form>
<?php
include ("bottom.inc.php");
?>