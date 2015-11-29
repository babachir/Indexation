<?php

//recuperer les keywords
function get_meta_keywords($file)
{
	$tab_metas = get_meta_tags($file);
	if(isset($tab_metas['keywords']))
	{
	if ($tab_metas['keywords'] != null) return $tab_metas['keywords'];
		else return '';
	}
	else return '';
	
}

//recuperer la description
function get_meta_description($file)
{
	$tab_metas = get_meta_tags($file);

	if(isset($tab_metas['description']))
	{
		if ($tab_metas['description'] != null) return $tab_metas['description'];
		else return '';
	}

	else return '';
	
}

//transfomer un fichier en chaine de caracteres 
function file2chaine($file)
{
	$tab_lignes=file($file);
	$chaine= implode ($tab_lignes , ' ');
	return $chaine;
}


//recuperer les mots cles 
function explodeBIS($separateurs , $chaine)
{
	$tab_mots = array();
	$tok = strtok($chaine , $separateurs);
	if(strlen($tok) >2)  $tab_mots[] = $tok;

	while ($tok != false)
	{
		$tok=strtok($separateurs);
		/*test si le mot est vide ou pas ici */
		
		if(strlen($tok) >2)  $tab_mots[] = trim ($tok,"\t\n\r\0\x0B" );
	}
	return $tab_mots;
}

// afficher contenu du tableau
function print_tab ($tab)
{
	foreach ($tab as $indice => $mot )
	{
		echo"$indice = $mot <br>"; 
	}
}


// recuperer title on utilisant DOM
function get_title($file)
{
	$dom = new DOMDocument;
	$dom->loadHTML(file2chaine($file));
	$title = $dom->getElementsByTagName('title');

	return $title->item(0)->nodeValue;
}

// title on utilisant une ER
function get_title_With_ER($file){
	
	$modele = '/<title>(.*)<\/title>/i';
	
	// return type boolean
	preg_match($modele,file2chaine($file), $title);
	

	if(isset($title[1]))
	return $title[1];
}


//retourne l'encodage d'une chaien de caractère 

function detectEncodage($chaine)
{

 if(mb_detect_encoding($chaine, "iso-8859-1")!=false)
 {
 	return "iso-8859-1";
 }
 else if(mb_detect_encoding($chaine, "iso-8859-15")!=false)
 {
 	return "iso-8859-15";

 }
 else if (mb_detect_encoding($chaine, "UTF-8")!=false)

 {
 	return "UTF-8";
 }

 else 
 	return false;

}




// remplacer les cars html par leurs vraie présentation
function entitesHTML2Caracts($chaine_html_entites)
{	
	
	$chaine_html_entites = str_replace("&nbsp;", ")", $chaine_html_entites);

	//var_dump($chaine_html_entites);

	$table_caracts_html   = get_html_translation_table(HTML_ENTITIES);	
	$tableau_html_caracts = array_flip ( $table_caracts_html );
	$chaine_html_caracts  = strtr ($chaine_html_entites, $tableau_html_caracts );



	if(detectEncodage($chaine_html_caracts))
	{
	$encodage_chaine_entrer = detectEncodage($chaine_html_caracts); 
	$chaine_html_caracts = mb_convert_encoding($chaine_html_caracts,$encodage_chaine_entrer,'UTF-8');
	


	}

	
   
	return $chaine_html_caracts;
}

// body on utilisant DOM
function get_Body_textContent($file)
{
	$dom = new DOMDocument;
	$dom->loadHTML(file2chaine($file));
	$body = $dom->getElementsByTagName('body');

	return $body->item(0)->textContent;
}

// body on utilisant une ER
function get_Body($file){
	$chaine = file2chaine($file);
	$modele =  '/<body[^>]*>(.*)<\/body>/is';
	
	if( preg_match($modele, $chaine, $body)){
		
		return $body[1];
	}
	else return " ";
}


// suppression des scripts dans le body
function strip_scripts($chaine){
	$modele = '/<script[^>]*?>.*?<\/script>/is';
	$html = preg_replace($modele, '',$chaine);
	return $html;
}

//transsformer les occurences en poids 
function occ2poids($tab , $coff){
	foreach( $tab as $mot=>$occ){
		$tab[$mot] = $occ * $coff;
	}
	return $tab;
}

//fusionner les mots cles du head et du body
function fusion_tabH_tabB($tab , $tab2)
{
	if( count($tab>$tab2)){
		$tab_court=$tab2;
		$tab_long=$tab;
	}
	else
	{
		$tab_long=$tab2;
		$tab_court = $tab;
	}
	
	foreach( $tab_court as $mot=>$occ)
	{
		
		if(array_key_exists ($mot ,$tab_long))
		{
				$tab_long[$mot] += $occ;
		}
		else
			{
				$tab_long[$mot] = $occ;
		}
		
	}
	
	return $tab_long;
}


function fusion_tabH_tabB_tabV($tab , $tab2, $mot_vides)
{

	
	if( count($tab>$tab2)){
		$tab_court=$tab2;
		$tab_long=$tab;
	}
	else
	{
		$tab_long=$tab2;
		$tab_court = $tab;
	}
	
	foreach( $tab_court as $mot=>$occ)
	{
		
		if(!in_array(utf8_encode($mot), $mot_vides)){
			if(array_key_exists ($mot ,$tab_long))
			{
					$tab_long[$mot] += $occ;
			}
			else
				{
					$tab_long[$mot] = $occ;
			}
		}
	}
	
	return $tab_long;
}

function get_mot_vides($file)
{
	$chaine = file2chaine($file);

	//les separateurs pour decouper le texte en mots
	$separateurs=" \n";
	$mot_vide = utf8_decode(entitesHTML2Caracts($chaine));
	$empty_word=explodeBIS ($separateurs , $mot_vide);

	return $empty_word;	
}



function chargerDICO($file)
{
	$fp = fopen($file, 'r');
	
	while( ! feof($fp))
	{
		$tab_mot_vides[] = trim(fgets($fp, 4096));
	}
	
	fclose($fp);
	
	return $tab_mot_vides;
}


function cleanChaine($mystring)
{


	
	if(preg_match( "#[?/\&><]#", $mystring )==1)
	{
		return true;
	}






	
return false;

}



?>