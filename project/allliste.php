<?php

include "module_index_head.php";
include "bddconnect.php";


$docs = getDocs();


?>


<html>

<head>
    <meta charset="UTF-8"/>
    <title> indexation </title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>


<div class="wrapper">
    <div class="head">
        <div id="title"> Title</div>
        <div id="link"> Link</div>
        <div id="view"> keyword cloud</div>
    </div>

    <div class="content">

        <?php foreach ($docs as $doc): ?>


            <div class="title">
                <?= $doc['title'] ?>
            </div>
            <div class="link">
                <a href="<?= $doc['adr'] ?>" target="_blank"> Consult the link</a>
            </div>
            <div class="view">
                <a href="cloud.php?id=<?= $doc['id_doc'] ?>" target="_blank"> Consult the cloud</a>
            </div>


        <?php endforeach; ?>
    </div>


</div>


</body>
</html>