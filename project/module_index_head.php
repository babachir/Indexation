

<?php
include "bibliotheque.inc.php";
include_once 'connect.php';


 

function indexer($file, $tab_mot_vide)
{
	global $conn;

	//______________________ traitement head________________________
	$title = get_title_With_ER($file);
	$keywords = get_meta_keywords($file);
	$description = get_meta_description($file);
	$chaine_head = $keywords . " " . $description . " ";

	// conversion entites html ascii
	$chaine_head = entitesHTML2Caracts($chaine_head);

	//minuscule
	$chaine=strtolower($chaine_head);

	//les separateurs pour decouper le texte en mots
	$separateurs=" {}[])(-_;,:.'’»«$";

	//decoupage du texte en elements/mots
	$tab_mots_head=explodeBIS ($separateurs , $chaine);

	//affichage des mots
	//print_tab($tab_mots);
	//echo "<br><br>";


	//calcul de la frequence des mots 
	//suppression des doublons
	$tab_mots_occurrences_head = array_count_values($tab_mots_head);
	//print_tab($tab_mots_occurrences);

	// calcul du poids des mots
	$tab_mots_poids_head = occ2poids($tab_mots_occurrences_head, 2);
	//print_tab($tab_mots_poids_head);

	//______________________ Fin traitement head________________________


	//______________________ traitement body________________________
	 
	 
	$body = get_Body($file);


	// body sans balises scripts
	$body_sans_scripts = strip_scripts($body);

	// suppression des balises html
	$clean_body = strip_tags($body_sans_scripts);

	// conversion entites html ascii


	$clean_body = entitesHTML2Caracts($clean_body);
	 
	

	 //minuscule
	$clean_body=strtolower($clean_body);


	//les separateurs pour decouper le texte en mots
	$separateurs=" {}[])(-_;,:.'’»«$!?\"";

	//decoupage du texte en elements/mots
	$tab_mots_body=explodeBIS ($separateurs , $clean_body);


	//affichage des mots
	//print_tab($tab_mots);
	//echo "<br><br>";


	//calcul de la frequence des mots 
	//suppression des doublons
	$tab_mots_occurrences_body = array_count_values($tab_mots_body);

	//print_tab($tab_mots_occurrences);

	// calcul du poids des mots
	$tab_mots_poids_body = $tab_mots_occurrences_body;
	//print_tab($tab_mots_poids_body);

	//________________________ fin traitement body ______________________


	// fusion des deux tableaux
	$tab_mots_poids = fusion_tabH_tabB_tabV($tab_mots_poids_head, $tab_mots_poids_body, $tab_mot_vide );
	//print_tab($tab_mots_poids);


	//création du doccument dans la BDD


	$data = array('adr' =>mysqli_real_escape_string($conn, $file),
				  'title' => mysqli_real_escape_string($conn, $title),
				  'description' => mysqli_real_escape_string($conn, $description) );
	$id_doc = createDoc($data);



	foreach ($tab_mots_poids as $mot => $poids)
	{

		if(!cleanChaine($mot))
		{

		$data = array('id_doc' =>mysqli_real_escape_string($conn, $id_doc),
					  'mot' => mysqli_real_escape_string($conn,trim($mot)),
					  'poids' => mysqli_real_escape_string($conn, $poids) );

		createMot($data);
		}
	}
	 
}


?>
