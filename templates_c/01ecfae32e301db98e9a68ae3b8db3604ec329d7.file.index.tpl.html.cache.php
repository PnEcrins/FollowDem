<?php /* Smarty version Smarty-3.1.14, created on 2015-06-09 15:46:54
         compiled from "./templates/index.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:8534371245576ee4eaef193-89796758%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01ecfae32e301db98e9a68ae3b8db3604ec329d7' => 
    array (
      0 => './templates/index.tpl.html',
      1 => 1433835077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8534371245576ee4eaef193-89796758',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'periode_valeurs' => 0,
    'periodes' => 0,
    'periode_min' => 0,
    'objets' => 0,
    'tracked_objects' => 0,
    'propcouleur' => 0,
    'propfilcolor' => 0,
    'color' => 0,
    'filcolor' => 0,
    'annee' => 0,
    'anneebouquetin' => 0,
    'age' => 0,
    'leaflet_gmap' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5576ee4eb7a219_86014356',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5576ee4eb7a219_86014356')) {function content_5576ee4eb7a219_86014356($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/bouquetins-dev/classes/Smarty/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="fr">
  <?php echo $_smarty_tpl->getSubTemplate ("head.inc.tpl.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>


  <body>

    <?php echo $_smarty_tpl->getSubTemplate ("nav.inc.tpl.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>


    <div class="row" id="container">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4" id="sidebar">
            <img src="images/logo.png" alt="Parc national des Ecrins" class="pull-left" />
			<p><?php echo traduction::t('Texte indroduction');?>
</p>
			<p>&nbsp;</p>
		   <div class="panel panel-success">
			   
				 <div class="panel-heading"><?php echo traduction::t('Entete liste tracked_objects');?>
 
					<select id='periode'>
					<?php  $_smarty_tpl->tpl_vars['periodes'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['periodes']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['periode_valeurs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['periodes']->key => $_smarty_tpl->tpl_vars['periodes']->value){
$_smarty_tpl->tpl_vars['periodes']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['periodes']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['periodes']->value==$_smarty_tpl->tpl_vars['periode_min']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['periodes']->value;?>
</option>
					<?php } ?>
					</select> <?php echo traduction::t('Slide derniers jours');?>

				
				
				 
				 </div>
				 <div class="panel-body" style="padding: 0px 15px;">
				   <?php  $_smarty_tpl->tpl_vars['tracked_objects'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tracked_objects']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['objets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tracked_objects']->key => $_smarty_tpl->tpl_vars['tracked_objects']->value){
$_smarty_tpl->tpl_vars['tracked_objects']->_loop = true;
?>
					<div id="<?php echo $_smarty_tpl->tpl_vars['tracked_objects']->value->get_id();?>
" class="tracked_objects">
					<?php if ($_smarty_tpl->tpl_vars['propcouleur']->value!=''){?>
						<div class="color">
							
								<?php $_smarty_tpl->tpl_vars["color"] = new Smarty_variable($_smarty_tpl->tpl_vars['tracked_objects']->value->get_object_feature($_smarty_tpl->tpl_vars['propcouleur']->value), null, 0);?>
								<?php $_smarty_tpl->tpl_vars["filcolor"] = new Smarty_variable($_smarty_tpl->tpl_vars['tracked_objects']->value->get_object_feature($_smarty_tpl->tpl_vars['propfilcolor']->value), null, 0);?>
								
								
								<div style="background-color:<?php echo $_smarty_tpl->tpl_vars['color']->value;?>
">
									<div style="background-color:<?php echo $_smarty_tpl->tpl_vars['filcolor']->value;?>
;padding:6px;"></div>
								</div>
							
						</div>
					<?php }?>
						<h3><?php if ($_smarty_tpl->tpl_vars['tracked_objects']->value->get_object_feature('sexe')){?><img src="images/<?php if ($_smarty_tpl->tpl_vars['tracked_objects']->value->get_object_feature('sexe')=='M'){?>male<?php }else{ ?>women<?php }?>.png" width="18" height="18" />&nbsp;&nbsp;<?php }?><?php echo $_smarty_tpl->tpl_vars['tracked_objects']->value->get_nom();?>
</h3>
						<div><?php if ($_smarty_tpl->tpl_vars['tracked_objects']->value->get_object_feature('naissance')){?><?php $_smarty_tpl->tpl_vars["annee"] = new Smarty_variable(smarty_modifier_date_format(time(),"%Y"), null, 0);?><?php $_smarty_tpl->tpl_vars["anneebouquetin"] = new Smarty_variable($_smarty_tpl->tpl_vars['tracked_objects']->value->get_object_feature('naissance'), null, 0);?><?php $_smarty_tpl->tpl_vars["age"] = new Smarty_variable($_smarty_tpl->tpl_vars['annee']->value-$_smarty_tpl->tpl_vars['anneebouquetin']->value, null, 0);?><strong><small><?php echo $_smarty_tpl->tpl_vars['age']->value;?>
 ans</small></strong><?php }?></div>
					</div>
				<?php } ?>
				</div>
			</div>
        </div>
        <div id="map" class="col-xs-12 col-sm-12 col-md-7 col-lg-8" >
            <div id="loading" style="display: block;">
                <div class="loading-indicator">
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-info" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#" type="button" rel="tooltip" class="toggle btn btn-default" data-toggle="tooltip" data-placement="right" title="Cacher/Montrer la liste"><i class="icon-chevron-left"></i></a>
	<div class="modal fade" id="modalepage" data-refresh="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

	<div class="modal fade" id="error">
		<div class="modal-dialog">
			
			 <div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Erreur !</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger"><p><?php echo traduction::t('error_ajax');?>
</p></div>
					<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button></div>
				</div>
			</div>
		</div>
	</div><script type="text/javascript" src="js/leaflet/leaflet.js"></script>
	<script type="text/javascript" src="js/leaflet/leaflet.polylineDecorator.min.js"></script>
	<?php if ($_smarty_tpl->tpl_vars['leaflet_gmap']->value){?>
		<script src="http://maps.google.com/maps/api/js?v=3.2&sensor=false"></script>
		<script src="js/leaflet/Google.js"></script>
	<?php }?>
	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
<?php echo $_smarty_tpl->getSubTemplate ("bottom.inc.tpl.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

	<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-7988554-6']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

	</script>
	
</body>
</html>
<?php }} ?>