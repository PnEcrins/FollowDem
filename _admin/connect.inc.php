<form name="monForm" action="./traitement.php" method="POST">
<div class="jumbotron">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="form-group col-md-4">
			<label for="idLogin">Login</label>
			<input class="form-control input-lg" type="text" placeholder="login" id="idLogin">
		</div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="form-group col-md-4">
			<label for="idPwd">Password</label>
			<input class="form-control input-lg" type="password" placeholder="password" id="idPwd">
		</div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<a type="button" class="btn btn-primary btn-lg btn-block" name="btConnect" href="./traitement.php">Se connecter</a>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
</form>