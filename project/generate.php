<?php
include "module_index_head.php";
include "bddconnect.php";
$file_mot_vide = "mot_vide.txt";

$tab_mot_vide = chargerDICO($file_mot_vide);


//indexer("../technique informatique et web/source.html", $tab_mot_vide);

$path = "..";
explorerDir($path, $tab_mot_vide);


function explorerDir($path, $tab_mot_vide)
{
    $folder = opendir($path);
    while ($entree = readdir($folder)) {
        //On ignore les entrées

        if ($entree != "." && $entree != "..") {
            // On vérifie si il s'agit d'un répertoire
            if (is_dir($path . "/" . $entree)) {
                $sav_path = $path;
                // Construction du path jusqu'au nouveau répertoire
                $path .= "/" . $entree;
                //echo "DOSSIER = ", $path, "<BR>";
                // On parcours le nouveau répertoire
                explorerDir($path, $tab_mot_vide);
                $path = $sav_path;
            } else {
                //C'est un fichier html ou pas
                $path_source = $path . "/" . $entree;

                if (stripos($path_source, '.htm')) {
                    //echo 'On appelle le module indexation <br>';
                    //echo $path_source, '<br>';
                    indexer($path_source, $tab_mot_vide);

                }
                //Si c'est un .html
                //On appelle la fonction d'indexation
                //Dans le module_indexation.php
                //Par un include
            }
        }
    }
    closedir($folder);
}

?>