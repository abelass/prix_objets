<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('base/abstract_sql');


function devises(){
    $devises=array(
    
        //A
        'AUD'=>'AUD',   
             
        //B 
        'BRL'=>'Real',               
             
        //C          
        'CAD'=>'CAD',        
        'CHF'=>'CHF',    
        'CNY'=>'Yuan',
        'CSD'=>'CSD',                        
        'CZK'=>'CZK',
                 
        //D     
        'DKK'=>'DKK', 
             
        //E     
        'EUR'=>'€',
             
        //G          
        'GBP'=>'£',
             
        //H 
        'HKD'=>'HKD',        
        'HUF'=>'HUF',
                 
        //I              
        'IDR'=>'IDR',                
        'ILS'=>'Shekel',
        'IQD'=>'IQD',       
        'IRR'=>'IRR',       
        'ISK'=>'ISK',   
            
        //J         
        'JEP'=>'JEP',   
        'JOD'=>'JOD',                       
        'JMD'=>'JMD',                
        'JPY'=>'¥',
        
        //K     
        'KES'=>'KES',   
        'KGS'=>'KGS',
        'KWD'=>'KWD',           
        'KZT'=>'Tenge',                         
        
        //L     
        'LAK'=>'Kip',   
        'LBP'=>'LBP',   
        'LKR'=>'LKR',                           
        'LRD'=>'LRD',    
        'LTL'=>'Litas', 
        'LVL'=>'Lat',                               
                            
        //M     
        'MAD'=>'Dirham',     
        'MDL'=>'MDL',                   
        'MGA'=>'Ariary',    
        'MKD'=>'MKD',           
        'MNT'=>'Tughrik',           
        'MRO'=>'Ouguiya',   
        'MUR'=>'MUR',
        'MVR'=>'Rufiyaa',                           
        'MWK'=>'MWK',                    
        'MXN'=>'MXN',
        'MYR'=>'Ringgit',       
        'MZN'=>'Metical',       
        
        //N     
        'NAD'=>'NAD',
        'NGN'=>'Naira',
        'NIO'=>'Cordoba',           
        'NPR'=>'NPR',                                    
        'NOK'=>'NOK',        
        'NZD'=>'NZD',
        
        //O     
        'OMR'=>'OMR',
                
        'QAR'=>'Riyal',             
        
        //P     
        'PGK'=>'Kina',
        'PHP'=>'PHP',   
        'PKR'=>'PKR',                                
        'PLN'=>'Zloty',  
            
        
        'RON'=>'RON',       
        'RUB'=>'Rouble',            
        'RWF'=>'RWF',
        
        //S     
        'SCR'=>'SCR',           
        'SDD'=>'SDD',                            
        'SEK'=>'SEK',        
        'SGD'=>'SGD',
        'SOS'=>'SOS',       
        'SLL'=>'Leone',         
        'SRD'=>'SRD',       
        'STD'=>'Dobra',
        'SVC'=>'Colon',
        'SYP'=>'SYP',                           
                
        //T 
        'THB'=>'Baht',              
        'TJS'=>'Somoni',                    
        'TND'=>'TND',   
        'TMM'=>'TMM',                   
        'TRY'=>'Lirasi',
        'TTD'=>'TTD',       
        'TWD'=>'TWD',
        'TZS'=>'TZS',       
            
            
        //U     
        'UAH'=>'Hryvna',    
        'UGX'=>'UGX',                                                    
        'USD'=>'USD',
        'UZS'=>'UZS',       
        
        //V     
        'VND'=>'Dong',
        
        //X     
        'XAF'=>'XAF',
        'XOF'=>'XOF',   
        
        //Y     
        'YER'=>'Rial',          
        
        //Z     
        'ZMK'=>'ZMK',                               
        'ZWN'=>'ZWN',       
        );

    return $devises;
}

// traduit le nom de la devise
function traduire_devise($code_devise){
	include_spip('inc/devises');
    
	$devises =devises();
	$trad= $devises[$code_devise];

	return $trad;
}

function prix_defaut($id_objet,$objet='article'){

	if($_COOKIE['spip_devise'])$devise_defaut=$_COOKIE['spip_devise'];
	elseif(lire_config('shop_prix/devise_default'))$devise_defaut=lire_config('shop_prix/devise_default');
	else 	$devise_defaut='EUR';

	$req=sql_select('code_devise,prix','spip_prix_objets','id_objet='.$id_objet.' AND objet='.sql_quote($objet));

	while($row=sql_fetch($req)){
	
		$prix= $row['prix'].' '.traduire_devise($row['code_devise']);
	
		if($row['code_devise']==$devise_defaut) $defaut = $row['prix'].' '.traduire_devise($row['code_devise']);
	}	
		
	if($defaut)$defaut=$defaut;
	else $defaut=$prix;

	return $defaut;
}

function devise_defaut_prix($prix='',$traduire=true){

    if($_COOKIE['spip_devise'])$devise_defaut=$_COOKIE['spip_devise'];
    elseif(lire_config('shop_prix/devise_default'))$devise_defaut=lire_config('shop_prix/devise_default');
    else    $devise_defaut='EUR';
    $devise_defaut=traduire_devise($devise_defaut);
    if($prix)$devise_defaut= $prix.' '.$devise_defaut;

    return $devise_defaut;
}



function devise_defaut($id_objet,$objet='article'){

	if($_COOKIE['spip_devise'])$devise_defaut=$_COOKIE['spip_devise'];
	elseif(lire_config('shop_prix/devise_default'))$devise_defaut=lire_config('shop_prix/devise_default');
	else 	$devise_defaut='EUR';

	$req=sql_select('code_devise,prix','spip_prix_objets','id_objet='.$id_objet.' AND objet='.sql_quote($objet));

	while($row=sql_fetch($req)){
	
		$prix= $row['prix'].' '.traduire_devise($row['code_devise']);
	
		if($row['code_devise']==$devise_defaut) $defaut = $row['code_devise'];
	}	
		
	if($defaut)$defaut=$defaut;
	else $defaut=$prix;

	return $defaut;
}

function traduire_code_devise($code_devise,$id_objet,$objet='article',$option=""){

	$prix=sql_fetsel('prix','spip_prix_objets','id_objet='.$id_objet.' AND objet='.sql_quote($objet).' AND code_devise ='.sql_quote($code_devise));

	$return =$prix['prix'].' '. traduire_devise($code_devise);
	
	if($option=='prix') $return =$prix['prix'];
	
	
	return $return;
}

function rubrique_prix($id='',$objet='article',$sousrubriques=false){
        include_spip('inc/config');
        include_spip('prive/formulaires/selecteur/generique_fonctions');

        $rubrique_produit=picker_selected(lire_config('shop_prix/rubrique_prix',array()),'rubrique');

        if($rubrique_produit){
        $id_parent=$rubrique_produit;

        if(!$sousrubriques){
            $rubriques=$id_parent;
            }
        else $rubriques=array();

        $rubriques=rubriques_enfant($id_parent,$rubriques);
        if($id){
            $retour=sql_getfetsel('id_'.$objet, 'spip_'.$objet.'s', 'id_'.$objet.'='.$id.' AND id_rubrique IN ('.implode(',',$rubriques).')');
            }
        else $retour=$rubriques;
       }
    else echo '<div class="erreur">veuillez configurer une rubrique produit</div>';
return $retour;
} 


function rubriques_enfant($id_parent,$rubriques=array()){

$id_p='';
    if (is_array($id_parent))$id_parent=implode(',',$id_parent);


    if($id_parent)$sql=sql_select('id_rubrique','spip_rubriques','id_parent IN ('.$id_parent.')');
    
    $id_p=array();
    while($row=sql_fetch($sql)){
        $id_p[]=$row['id_rubrique'];
        $rubriques[]=$row['id_rubrique'];
        }

    if(count($id_p)>0)$rubriques=rubriques_enfant($id_p,$rubriques);
return $rubriques;
}


?>
