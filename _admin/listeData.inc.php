<?php
include ("head.inc.php");
include ("nav.inc.php");
?>
<div id="decale">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<h3>Liste des Donnees</h3>
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
		<tr><th></th><th>id</th><th>id_tracked_objects</th><th>dateheure</th><th>latitude</th><th>longitude</th><th>temperature</th><th>nb_satellites</th><th>altitude</th></tr>
		<tr><td><input type="checkbox"></td><td>1</td><td>4179</td><td>2015-06-16 00:00:00</td><td>45.0289817</td><td>6.47533</td><td>23</td><td>6</td><td>2451</td></tr>
		<tr><td><input type="checkbox"></td><td>2</td><td>4179</td><td>2015-06-16 06:00:00</td><td>44.7886</td><td>6.40452</td><td>25</td><td>7</td><td>2678</td></tr>
		<tr><td><input type="checkbox"></td><td>3</td><td>4179</td><td>2015-06-16 12:00:00</td><td>45.57852</td><td>6.04045</td><td>17</td><td>4</td><td>1800</td></tr>
		<tr><td><input type="checkbox"></td><td>4</td><td>4179</td><td>2015-06-16 18:00:00</td><td>44.2782</td><td>6.0452</td><td>14</td><td>5</td><td>1965</td></tr>
		<tr><td><input type="checkbox"></td><td>5</td><td>4179</td><td>2015-06-17 00:00:00</td><td>45.278</td><td>6.0357</td><td>12</td><td>8</td><td>3247</td></tr>
		<tr><td><input type="checkbox"></td><td>6</td><td>4278</td><td>2015-06-16 00:00:00</td><td>44.475</td><td>6.035789</td><td>14</td><td>8</td><td>3854</td></tr>
		<tr><td><input type="checkbox"></td><td>7</td><td>4278</td><td>2015-06-16 06:00:00</td><td>45.87962</td><td>6.0127</td><td>23</td><td>4</td><td>7854</td></tr>
		<tr><td><input type="checkbox"></td><td>8</td><td>4278</td><td>2015-06-16 12:00:00</td><td>44.7861</td><td>6.2347</td><td>25</td><td>5</td><td>1235</td></tr>
		<tr><td><input type="checkbox"></td><td>9</td><td>4278</td><td>2015-06-16 18:00:00</td><td>45.71</td><td>6.1145</td><td>32</td><td>4</td><td>1452</td></tr>
		<tr><td><input type="checkbox"></td><td>10</td><td>4278</td><td>2015-06-17 00:00:00</td><td>44.02080</td><td>6.14557</td><td>52</td><td>8</td><td>2365</td></tr>
		<tr><td><input type="checkbox"></td><td>11</td><td>4273</td><td>2015-06-16 00:00:00</td><td>45.0870</td><td>6.27852</td><td>12</td><td>5</td><td>2458</td></tr>
		<tr><td><input type="checkbox"></td><td>12</td><td>4273</td><td>2015-06-16 06:00:00</td><td>44.07808</td><td>6.3873783</td><td>0</td><td>6</td><td>3214</td></tr>
		<tr><td><input type="checkbox"></td><td>13</td><td>4273</td><td>2015-06-16 12:00:00</td><td>45.07860</td><td>6.35412</td><td>2</td><td>7</td><td>3625</td></tr>
		<tr><td><input type="checkbox"></td><td>14</td><td>4273</td><td>2015-06-16 18:00:00</td><td>44.078600</td><td>6.1235</td><td>3</td><td>8</td><td>3120</td></tr>
		<tr><td><input type="checkbox"></td><td>15</td><td>4273</td><td>2015-06-17 00:00:00</td><td>45.0780755</td><td>6.1352</td><td>7</td><td>7</td><td>3002</td></tr>
		<tr><td><input type="checkbox"></td><td>16</td><td>5191</td><td>2015-06-16 00:00:00</td><td>44.0780</td><td>6.24556</td><td>14</td><td>6</td><td>2800</td></tr>
		<tr><td><input type="checkbox"></td><td>17</td><td>5191</td><td>2015-06-16 06:00:00</td><td>45.7852</td><td>6.245</td><td>25</td><td>5</td><td>2478</td></tr>
		<tr><td><input type="checkbox"></td><td>18</td><td>5191</td><td>2015-06-16 12:00:00</td><td>44.654</td><td>6.0144</td><td>36</td><td>5</td><td>2654</td></tr>
		<tr><td><input type="checkbox"></td><td>19</td><td>5191</td><td>2015-06-16 18:00:00</td><td>45.45285</td><td>6.0237</td><td>3</td><td>6</td><td>2378</td></tr>
		<tr><td><input type="checkbox"></td><td>20</td><td>5191</td><td>2015-06-17 00:00:00</td><td>44.3827</td><td>6.07892</td><td>4</td><td>7</td><td>2698</td></tr>	
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