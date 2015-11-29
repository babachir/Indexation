<?php

// $path = "C:/wamp/www/THYP-1516/herrhilmi";


function exploreDir($path)
{
    $folder = opendir($path);

    while ($entree = readdir($folder)) {
        //on ignore les entrees
        //prevenir la boucle infinie
        //lorsque'on parcours un répertoire on a toujours ces 2 dossiers en premier
        if ($entree != "." && $entree != "..") {
            //on verifie s'il s'agit d'un répertoire
            if (is_dir($path . "/" . $entree)) {
                $sav_path = $path;
                //construction du path vers le nouveau dossier
                $path .= "/" . $entree;
                //echo "dossier = ", $path, "<br>";
                // on parcours le nouveau répertoire
                exploreDir($path);
                $path = $sav_path;
            } else {
                $lastIndexPoint = strrpos($entree, ".");
                $extension = substr($entree, $lastIndexPoint, strlen($entree));

                // fichier html
                if (strstr($extension, "htm") != FALSE) {
                    echo "chemin vers fichier :  ", $path, "/", $entree, "<br>";
                }
            }
        }
    }


}


?>