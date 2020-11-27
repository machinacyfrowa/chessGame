<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body onload="prepareBoard()">
    <?php
    require('class/GameManager.class.php');

    session_start();

    if(isset($_SESSION['gm'])) {
        $gm = $_SESSION['gm'];
    } else {
        $gm = new GameManager();
        $_SESSION['gm'] = $gm;
    }
    

    
    ?>




    <form action="#" id="moveForm" method="POST">
        <input type="hidden" name="source" id="source">
        <input type="hidden" name="target" id="target">
        <!--<input type="submit" value="Przesuń figurę"><br>-->
    </form>

    <?php

    if (isset($_REQUEST['source']) && isset($_REQUEST['target'])) {
        $source = $_REQUEST['source'];
        $target = $_REQUEST['target'];
        echo "<h3>Przesuwam pionek z pola $source na pole $target</h3>";
        $gm->movePiece($source, $target);
    }


        echo $gm->getBoardHTML();
    ?>
    <script>
        function prepareBoard() {
            let container = document.getElementById('grid-container');
            container.childNodes.forEach(function(element) {
                element.addEventListener("click", fieldClick);
            });

        }

        function fieldClick(e) {
            let source = document.getElementById('source');
            let target = document.getElementById('target');

            if (source.value) { //jeżeli podano źródło
                target.value = e.currentTarget.id;
                document.getElementById('moveForm').submit();
            } else { //jeżeli jeszcze nie ma źródła
                source.value = e.currentTarget.id;
            }
        }
    </script>

</body>

</html>