<?php

include "module_index_head.php";
include "bddconnect.php";



$words = getWord($_GET["id"]);



?>


<html>

<head>
        <title> cloud </title>
        <link rel="stylesheet" href="style.css" />
		<meta charset="utf-8">
</head>

<body>


	<div class="wrapper">

	<ul class="cloud" style="list-style-type : none;">
		<?php foreach ($words as $word):?>

			<li class="link<?php echo $word['poids']%7?>" style="font-size:<?php echo 6+(10*$word['poids']);?>px;"><?php echo utf8_encode($word["mot"]);?> </li>

		<?php endforeach; ?>
	</ul>

		

	

	</div>





</body>
</html>