<?php /* Smarty version Smarty-3.1.14, created on 2015-06-09 15:46:54
         compiled from "./templates/nav.inc.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:18856805725576ee4eb879e2-34517080%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf5fa311d97735ecb131ab4c36004c82f69d17f8' => 
    array (
      0 => './templates/nav.inc.tpl.html',
      1 => 1422360391,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18856805725576ee4eb879e2-34517080',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'titre_application' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5576ee4ebc0908_12372135',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5576ee4ebc0908_12372135')) {function content_5576ee4ebc0908_12372135($_smarty_tpl) {?><div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo config::get('url');?>
"><?php echo $_smarty_tpl->tpl_vars['titre_application']->value;?>
</a>
	</div>
	<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a id="infos" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-camera-retro icon-large" style="color: #FFF"></i>&nbsp;&nbsp;<?php echo traduction::t('Informations');?>
 <b class="caret"></b></a>
				 <ul class="dropdown-menu">
					 <li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/bouquetinsalpes.html" data-target="#modalepage"><i class="icon-eye-open icon-large" style="color: #CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Bouquetin des Alpes');?>
</a></li>
					   <li class="divider"></li>
					 <li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/bouquetins.html" data-target="#modalepage"><i class="icon-eye-open icon-large" style="color: #CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Capture Bouquetins');?>
</a></li>
					   <li class="divider"></li>
					 <li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/faune.html" data-target="#modalepage"><i class="icon-eye-open icon-large" style="color: #CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Faune sauvage');?>
</a></li>
					  <li class="divider"></li>
					 <li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/diego.html" data-target="#modalepage"><i class="icon-location-arrow icon-large" style="color: #CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Diego');?>
</a></li>
					 <!--  Bloc Actualités (récupérant un flux depuis le site WEB) masqué
					  <li class="divider"></li>
					 <li><a data-toggle="modal" href="/controler/get_info" data-target="#modalepage"><i class="icon-list icon-large" style="color: #CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Actualites');?>
</a></li>
					-->
				</ul>
			</li>
			<li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/parc.html" data-target="#modalepage"><i class="icon-leaf icon-large icon-rotate-180" style="color: #FFF"></i>&nbsp;&nbsp;<?php echo traduction::t('Parc national des Ecrins');?>
</a></li>
			<li class="dropdown">
				<a id="toolsDrop" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-map-marker icon-large" style="color: #FFF"></i>&nbsp;&nbsp;<?php echo traduction::t('Outils');?>
<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#" onclick="map.setView(latlng,<?php echo config::get('leaflet_zoom_initial');?>
); return false;"><i class="icon-fullscreen icon-large"  style="color:#CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Réinitialiser la vue');?>
</a></li>
					<li class="divider"></li>
					<li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/legende.html" data-target="#modalepage"><i class="icon-picture icon-large"  style="color:#CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Légendes de la carte');?>
</a></li>
					<li class="divider"></li>
					<li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/aide.html" data-target="#modalepage"><i class="icon-question icon-large" style="color:#CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Aide');?>
</a></li>
					<li class="divider"></li>
					<li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/informations.html" data-target="#modalepage"><i class="icon-user icon-large"  style="color:#CEDC00"></i>&nbsp;&nbsp;<?php echo traduction::t('Informations / Mentions légales');?>
</a></li>
				</ul>
			</li>
			<li><a data-toggle="modal" href="/<?php echo traduction::get_langue();?>
/pages/contact.html" data-target="#modalepage"><i class="icon-comments icon-large" style="color: #FFF"></i>&nbsp;&nbsp;<?php echo traduction::t('Contacts');?>
</a></li>

			
		</ul>
	</div><!--/.navbar-collapse -->
</div><?php }} ?>