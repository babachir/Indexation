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

        //var_dump($docs);
        ?>
        <div class="result">

            <div class="head">
                <div id="title" style="    width: 792px;">Number of results (<?php if($docs!=false) {echo count($docs);} else echo 0; ?>) </div>
                <div id="view"> keyword cloud</div>
            </div>

            <div class="content">
                
                <?php if($docs!=false):?>
                    <?php foreach ($docs as $doc): ?>

                        <a href="<?= $doc['adr'] ?>" target="_blank">
                            <div  style="height: 95px;width: 799px;line-height: 19px;" class="title">
                                <?= $doc['title'] ?><br/>
                                 <p style="font-style: italic; color:black;">description : <?php if($doc['description']!='')  {echo $doc['description'];} else {echo "no description";}?></p>
                            </div>
                        </a>
                        <div class="view" style="    height: 95px;">
                            <a href="cloud.php?id=<?= $doc['id_doc'] ?>" target="_blank"> Consult the cloud</a>
                        
                        </div>


                    <?php endforeach; ?>
                <?php else:?>
                    
                        
                            <div  style="width: 799px;" class="title">
                                No result 
                            </div>
                      
                        <div class="view">
                            
                        </div>                

                <?php endif;?>
            </div>


        </div>

    <?php endif; ?>

</div>


</body>

</html>