<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function shop_prix_affiche_milieu($flux){
	// affichage du formulaire d'activation désactivation projets
		
	

    if ($flux['args']['exec']=='article') {
    include_spip('shop_fonctions');    
	$id_article = $flux['args']['id_article'];
	$rubriques_produits=rubrique_produits($id_article);
		if($rubriques_produits){
		    include_spip('inc/layer');
			$deplie=false;
            $en_cours = trouver_objet_exec($flux['args']['exec']);
            $type = $en_cours['type'];
            $id_table_objet = $en_cours['id_table_objet'];
            $id = intval($flux['args'][$id_table_objet]);
			if(_request('formulaire_action')=='prix' OR _request('retour_action')) $deplie=true;
			$contexte = array('id_article'=>$id_article);
			$contenu .= recuperer_fond('prive/objets/editer/prix', $contexte,array('ajax'=>true));
			$res .= cadre_depliable('',_T('shop:info_prix'),$deplie,$contenu,'edition_prix');   
        	
                if ($p=strpos($flux['data'],"<!--affiche_milieu-->"))
                 $flux['data'] = substr_replace($flux['data'],$res,$p,0);
                else
                    $flux['data'] .= $res;
				    }
		}
return $flux;
}
?>
