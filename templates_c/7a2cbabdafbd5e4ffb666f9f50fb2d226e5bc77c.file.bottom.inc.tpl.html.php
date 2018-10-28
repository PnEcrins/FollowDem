<?php /* Smarty version Smarty-3.1.14, created on 2018-10-28 22:08:14
         compiled from "./templates/bottom.inc.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2351529885bd6334ee22a22-16915537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a2cbabdafbd5e4ffb666f9f50fb2d226e5bc77c' => 
    array (
      0 => './templates/bottom.inc.tpl.html',
      1 => 1540454027,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2351529885bd6334ee22a22-16915537',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5bd6334ee2a982_68668722',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5bd6334ee2a982_68668722')) {function content_5bd6334ee2a982_68668722($_smarty_tpl) {?><script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/simple-slider.min.js"></script>
<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="js/bottom.js"></script>


<?php if (config::get('active_tracking_stats')){?>
  <?php echo config::get('tracking_stats');?>

<?php }?><?php }} ?>