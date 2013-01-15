<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function shop_prix_affiche_milieu($flux){
	// affichage du formulaire d'activation désactivation projets
		
	include_spip('inc/config');
    $objets=lire_config('shop_prix/objets_prix',array());
    $e = trouver_objet_exec($flux['args']['exec']);
    $type = $e['type'];
    $id_table_objet = $e['id_table_objet'];   
    $id = intval($flux['args'][$id_table_objet]);
    if(in_array($type,$objets)){
        include_spip('shop_fonctions');   
        if ($page=='article') {
        $id_article = $flux['args']['id_article'];
	   $rubriques_produits=rubrique_produits($id_article);
		if($rubriques_produits){
			$contexte = array('id_objet'=>$id_article,'objet'=>'article');
			$contenu .= recuperer_fond('prive/objets/editer/prix', $contexte,array('ajax'=>true));
                if ($p=strpos($flux['data'],"<!--affiche_milieu-->"))
                 $flux['data'] = substr_replace($flux['data'],$contenu,$p,0);
                else
                    $flux['data'] .= $contenu;
				    }
		  } 
        else{
            $contexte = array('id_objet'=>$id,'objet'=>$type);
            $contenu .= recuperer_fond('prive/objets/editer/prix', $contexte,array('ajax'=>true));
                if ($p=strpos($flux['data'],"<!--affiche_milieu-->"))
                 $flux['data'] = substr_replace($flux['data'],$contenu,$p,0);
                else
                    $flux['data'] .= $contenu;
                    }
            
            }


return $flux;
}
?>
