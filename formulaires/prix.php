<?php

if (!defined("_ECRIRE_INC_VERSION")) return;


function formulaires_prix_charger_dist($id_objet,$objet='article'){
    include_spip('inc/config');

    
	$devises_dispos =lire_config('shop/devises');
	$taxes_inclus=lire_config('shop/taxes_inclus');
    
	
	// Devise par défaut si rien configuré
	if(!$devises_dispos)$devises_dispos=array('0'=>'EUR');
	$devises_choisis =array();	
	$prix_choisis =array();	

	$d=sql_select('*','spip_prix_objets','id_objet='.$id_objet.' AND objet ='.sql_quote($objet));
	
	//établit les devises diponible moins ceux déjà utilisés
		
	while($row=sql_fetch($d)){
		//$devises_choisis[$row['code_devise']] = $row['code_devise'];

		$prix_choisis[]=$row;
			
		}
		
	
		
	$devises = array_diff($devises_dispos,$devises_choisis);
	
	
	$valeurs = array(
		'prix_choisis'=>$prix_choisis,
	    'taxes_inclus'=>'',   
		'devises'=>$devises,	
		'code_devise'=>'',
		'objet'=>$objet,
		'id_objet'=>$id_objet,		
		'prix_ht'=>$taxes_inclus,
		'objet_titre'	=>'',
        'id_objet_titre'   =>'',								
		);
    if(test_plugin_actif('shop_declinaisons'))$valeurs['id_declinaison']='';
    $valeurs['_hidden'].='<input type="hidden" name="taxes_inclus" value="'.$taxes_inclus.'">';
    $valeurs['_hidden'].='<input type="hidden" name="objet" value="'.$objet.'">';  
    $valeurs['_hidden'].='<input type="hidden" name="id_objet" value="'.$id_objet.'">';       
    $valeurs['_hidden'].='<input type="hidden" name="objet_titre" value="'.$objet.'">';   
    $valeurs['_hidden'].='<input type="hidden" name="id_objet_titre" value="'.$id_objet.'">';       
	return $valeurs;			
}


function formulaires_prix_verifier_dist($id_objet,$objet='article'){

	foreach(array('prix','code_devise') as $obligatoire)
	
	if (!_request($obligatoire)) $erreurs[$obligatoire] =_T('info_obligatoire');	
		
    return $erreurs; // si c'est vide, traiter sera appele, sinon le formulaire sera resoumis
}

/*Elimination de la base de donées */
function formulaires_prix_traiter_dist($id_objet,$objet='article'){
    
    $prix=_request('prix');
    
    //Génération du titre
    $$titre=$titre=generer_info_entite(_request('id_objet'),_request('objet'), 'titre', '*');
    $titre_secondaire=generer_info_entite(_request('id_objet_titre'),_request('objet_titre'), 'titre', '*');
   if($titre_secondaire)$titre= $titre.' - '.$titre_secondaire;
   
   //On inscrit dans la bd
	$valeurs=array(
		'id_objet'=>$id_objet,
		'objet'=>$objet,	
		'code_devise' => _request('code_devise'),
		'prix'=>'',
		'prix_ht'=>'',	
		'titre'=>$titre
		);
        
    if($ttc=_request('taxes_inclus'))$valeurs['prix'] = _request('prix');
    else $valeurs['prix_ht'] = _request('prix');
    
    if($id_declinaison=_request('id_declinaison'))$valeurs['id_declinaison'] =$id_declinaison;
        
	sql_insertq('spip_prix_objets', $valeurs);
    
    //Ivalider le cache
    include_spip('inc/invalideur');
    suivre_invalideur("id='id_prix_objet/$id_prix_objet'");
    
    return;
}

?>