<?php

include_once 'connect.php';


function createDoc($data)
{
    global $conn;

    $id_doc = null;


    $sql = "SELECT * from document where adr ='" . $data["adr"] . "'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows) {
        while ($row = $result->fetch_assoc()) {
            $id_doc = $row["id_doc"];
        }

        if ($id_doc != null) {
            return $id_doc;
        }

    } else
        echo "Error: " . $sql . "<br>" . $conn->error . " <br/> ";

    if ($data["adr"] != "" && $data["title"] != "") {
        $sql = "INSERT INTO document (adr, title, description)
	VALUES ('" . $data["adr"] . "', '" . $data["title"] . "','" . $data["description"] . "')";
        //echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "New doc created successfully <br/>";
            $sql = "SELECT MAX(id_doc) last_id from document";
            $id_doc = $conn->query($sql);
            while ($row = $id_doc->fetch_assoc()) {
                return $row["last_id"];
            }

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . " <br/> ";
        }
    }
}


function createMot($data)
{
    global $conn;
    $id_mot = null;

    if ($data["mot"] != "") {

        $sql = "SELECT id_mot from mot where TRIM(mot) ='" . $data["mot"] . "'";
        $id_doc = $conn->query($sql);
        while ($row = $id_doc->fetch_assoc()) {
            $id_mot = $row["id_mot"];
        }


        if ($id_mot == null) {
            /*str_replace(CHR(32),"",$chaine)*/
            $sql = "INSERT INTO mot (mot) VALUES (TRIM('" . str_replace("\t\n\r", "", $data["mot"]) . "'))";


            if ($conn->query($sql) === TRUE) {
                echo "New word created successfully <br/>";
                $sql = "SELECT MAX(id_mot) last_id from mot";
                $id_doc = $conn->query($sql);
                while ($row = $id_doc->fetch_assoc()) {
                    $sql = "INSERT INTO doc_mot (id_doc,id_mot,poids)
					VALUES ('" . $data["id_doc"] . "','" . $row["last_id"] . "','" . $data["poids"] . "')";

                    if ($conn->query($sql) === TRUE) {
                        //echo "New relation mot_doc created successfully <br/>";

                    } else {
                        //  echo "Error: " . $sql . "<br>" . $conn->error . " <br/> ";
                    }


                }

            } else {
                //echo "Error: " . $sql . "<br>" . $conn->error . " <br/> ";
            }


        } else {


            $sql = "INSERT INTO doc_mot (id_doc,id_mot,poids)
					VALUES ('" . $data["id_doc"] . "','" . $id_mot . "','" . $data["poids"] . "')";

            if ($conn->query($sql) === TRUE) {
                echo "New relation mot_doc created successfully 2 <br/>";

            } else {
                //  echo "Error: " . $sql . "<br>" . $conn->error . " <br/> ";
            }


        }


    }
}


function getDocs()
{
    global $conn;
    $tab_returned = array();
    $sql = "SELECT * FROM document ";
    //echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tab_returned[] = $row;


        }

        return $tab_returned;


    } else {
        return false;
    }
}


function getDoc($id)
{
    global $conn;
    $tab_returned = array();
    $sql = "SELECT * FROM document WHERE id_doc=" . $id;
    //echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $address = $row;


        }

        return $address;


    } else {
        return false;
    }
}


function search($word)
{
    global $conn;
    $tab_returned = array();
    $sql = "SELECT id_doc, MAX(poids) FROM `doc_mot`,`mot` WHERE mot.mot ='" . $word . "' AND mot.id_mot=doc_mot.id_mot GROUP BY id_doc";
    //echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tab_id_doc[] = $row['id_doc'];


        }


        $tab_add = array();
        foreach ($tab_id_doc as $id_doc) {
            $tab_add[] = getDoc($id_doc);
        }
        return $tab_add;

    } else {
        return false;
    }
}


/*   $sql = "SELECT mot.mot FROM mot_doc, mot WHERE mot_doc.id_doc ='".$id."' AND mot_doc.id_mot=mot.id_mot";*/


function getWord($id)
{

    global $conn;
    $tab_returned = null;


    $sql = "SELECT mot.mot, doc_mot.poids FROM doc_mot, mot WHERE doc_mot.id_doc ='" . $id . "' AND doc_mot.id_mot=mot.id_mot";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tab_returned[] = $row;

        }
    }

    return $tab_returned;

}


function getAllWord()
{

    global $conn;
    $tab_returned = null;


    $sql = "SELECT * FROM  mot";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tab_returned[] = $row;

        }
    }

    return $tab_returned;

}

function getPoids($id_mot)
{

    global $conn;
    $tab_returned = null;


    $sql = "SELECT sum(poids) FROM `doc_mot` WHERE id_mot=" . $id_mot;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            return $row['sum(poids)'];

        }
    }

    return $tab_returned;

}

?>