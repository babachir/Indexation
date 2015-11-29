<?php
set_time_limit('10000');

include "module_index_head.php";
include "bddconnect.php";


$words = getAllWord();


?>


<html>

<head>
    <title> cloud </title>
    <link rel="stylesheet" href="style.css"/>
    <meta charset="utf-8">
</head>

<body>


<div class="wrapper">

    <ul class="cloud" style="list-style-type : none;">

        <?php
        foreach ($words as $key => $value) {
            $poids = getPoids($value['id_mot']);
            if ($poids > 1) {
                ?>

                <a style="text-decoration:none;" href="index.php?word=<?php echo utf8_encode($value["mot"]); ?>">
                    <li class="link<?php echo $poids % 7 ?>"
                        style="font-size:<?php echo 10 + (0.9 * $poids); ?>px;"><?php echo utf8_encode($value["mot"]); ?> </li>
                </a>

                <?php
            }
        }


        ?>


        <!--

    -->
    </ul>


</div>


</body>
</html>