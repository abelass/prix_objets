<?php
/**
 * Plugin Signaler des abus
 * (c) 2012 My Chacra
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Fonction d'installation du plugin et de mise à jour.
 * Vous pouvez :
 * - créer la structure SQL,
 * - insérer du pre-contenu,
 * - installer des valeurs de configuration,
 * - mettre à jour la structure SQL 
**/
function shop_prix_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();
	$maj['create'] = array(array('maj_tables', array('spip_prix_objets')));
    $maj['1.1.0']  = array(  
        array('sql_alter','TABLE spip_shop_prix RENAME TO spip_prix_objets')
        );
    $maj['1.1.2']  = array(  
        array('sql_alter','TABLE spip_prix_objets CHANGE prix prix_ht float (38,2) NOT NULL'),
        array('maj_tables', array('spip_prix_objets')),
        );  
    $maj['1.1.3']  = array(  
        array('sql_alter','TABLE spip_prix_objets CHANGE prix prix float (38,2) NOT NULL'),
        ); 
    $maj['1.1.4']  = array(  
        array('sql_alter','TABLE spip_prix_objets CHANGE id_prix id_prix_objet bigint(21) NOT NULL'),
        ); 
     $maj['1.1.5'] = array(array('maj_tables', array('spip_prix_objets')));    
                           
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin.
 * Vous devez :
 * - nettoyer toutes les données ajoutées par le plugin et son utilisation
 * - supprimer les tables et les champs créés par le plugin. 
**/
function shop_prix_vider_tables($nom_meta_base_version) {

    sql_drop_table("spip_prix_objets");

	effacer_meta($nom_meta_base_version);
}

?>
