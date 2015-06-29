<?php
/**
*	Fichier de langue - FR
*	@author Fabien Selles
*	@copyright Parc national des Écrins
*	
*/

$lang['titre'] = 'Bouquetins des Écrins';




/* Textes layers Leaflet */
$lang['Google Satellite'] = 'Google Satellite';
$lang['Points'] = 'Points';
$lang['Traces'] = 'Tracés';
$lang['Derniers points'] = 'Derniers points';

/*Menu Pages et Actions*/
$lang['item_a'] = config::get('item_a');
$lang['sous_item_a'] = config::get('sous_item_a');
$lang['sous_item_b'] = config::get('sous_item_b');
$lang['sous_item_c'] = config::get('sous_item_c');
$lang['sous_item_d'] = config::get('sous_item_d');
$lang['Actualites'] = 'Toutes les actualités'; // pas utilisé
$lang['item_b'] = config::get('item_b');
$lang['Outils'] = 'Outils';
$lang['Réinitialiser la vue'] = 'Réinitialiser la vue';
$lang['Légendes de la carte'] = 'Légendes de la carte';
$lang['Aide'] = 'Aide';
$lang['Informations / Mentions légales'] = 'Informations / Mentions légales';
$lang['Contacts'] = 'Contacts';

/* Textes interface */
$lang['Texte indroduction'] = config::get('texte_introduction');
$lang['Entete liste tracked_objects'] = '<strong>Cliquez sur le nom d\'un objet traqué pour voir son parcours</strong> <br /> Pour les';
$lang['Slide derniers jours'] = 'derniers jours.';
$lang['Entete selection periode'] = '<strong>Sélectionnez la période de déplacement à afficher</strong>';
$lang['Fermer'] = 'Fermer';

$lang['Nom'] = 'Nom';
$lang['Date'] = 'Date';
$lang['Altitude'] = 'Altitude (m)';
$lang['Temperature'] = 'Température (°C)';

/*Message erreur*/
$lang['error_10'] = 'Une erreur de cohérence est apparue dans la base de données';
$lang['Page non trouvee'] = '<center><br /><br /><h1><strong>ERREUR 404</strong></h1><br />Nous avons le regret de vous informer que la page demandée n\'a pas été trouvée.</center>';
//$lang['error_data'] = 'La période sélectionnée est inférieure à la position du Bouquetins la plus récente.<br />
//Veuillez réessayer ultérieurement.';
$lang['error_ajax'] = 'Une erreur est survenue pendant le chargement des données.<br />Veuillez essayer de nouveau.<br />
Si le problème persiste merci de nous contacter à partir de notre site Internet : <a href="http://www.ecrins-parcnational.fr">www.ecrins-parcnational.fr</a>';