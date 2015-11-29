<?php

include "module_index_head.php";
include "bddconnect.php";


?>

<html>

<head>
    <meta charset="UTF-8"/>
    <title> indexation </title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>

<div class="wrapper">

    <div>
        <img class="logoindex" src="img/logo.png"/>


    </div>

    <form method="post" action="index.php" id="form1">
        <p><input id="barsearhc" type="text" name="word"

                <?php if (isset($_POST['word']) || isset($_GET['word'])): ?>

                    value="<?php
                    if (isset($_POST['word']))
                        echo $_POST['word'];
                    if (isset($_GET['word']))
                        echo $_GET['word']; ?>"
                <?php endif; ?>

                /></p>

        <div style="width: 191px;margin: auto;">
            <input class="btindex" type="submit" form="form1" value="Search"/>
            <a class="btindex aBtIndex" value="Cloud" href="#"> Cloud </a>
        </div>
    </form>

    <?php if (isset($_POST['word']) || isset($_GET['word'])): ?>


        <?php

        if (isset($_POST['word']))
            $docs = search($_POST['word']);
        if (isset($_GET['word']))
            $docs = search($_GET['word']);

        ?>
        <div class="result">

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

    <?php endif; ?>

</div>


</body>

</html>