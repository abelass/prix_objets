<?php

/* Le prix HT  Existe-t-il une fonction précise pour le prix HT de ce type d'objet : prix_ht_<objet>() dans prix/<objet>.php
        if ($fonction_ht = charger_fonction('ht', "prix/$type_objet", true)){
            On passe la ligne SQL en paramètre pour ne pas refaire la requête
            $prix_ht = $fonction_ht($id_objet, $ligne);*/
            
function prix_prix_objet_ht($id_objet,$les_prix){

    if($les_prix['prix_ht']!='0.00')$prix_ht=$les_prix['prix_ht'];
    else{
        include_spip('inc_config');
        $taxes=lire_config('shop/taxes');
        if($prix>0)$prix_ht = $les_prix['prix']/($taxes/100);
        }
    
    return $prix_ht;
}

// Le prix TTC 
function prix_prix_objet_dist($id_objet){
    
    
    $les_prix=sql_fetsel('prix,prix_ht','spip_prix_objets','id_prix_objet='.$id_objet);
    
    if($les_prix['prix']!='0.00')$prix=$les_prix['prix'];
    else{
        include_spip('inc_config');
        $taxes=lire_config('shop/taxes');
        if($prix>0)$prix=$les_prix['prix_ht']+($les_prix['prix_ht']/100*$taxes);
        }
   

    return $prix;
}

?>