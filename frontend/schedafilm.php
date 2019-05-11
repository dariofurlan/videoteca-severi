<html>
<head>
    <title>Scheda Film </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .col-md-1 {
            padding-top: 50px;
        }

        .col-md-4 {

            padding-top: 50px;
        }

        .col-md-6 {
            padding-top: 50px;
        }

        img {
            border: 2px solid #000;
        }

        h1 {
            font-size: 3em;
        }

        p {
            font-size: 1.3em;
        }
    </style>
</head>

<body>
<?php
require "conn.php";
?>
<div class="row">

    <div class="col-md-1"></div>


    <div class="col-md-4">
        <?php
        $sql = "SELECT Link_Trailer FROM DVD WHERE Inventario='12516';";
        $sql1 = "SELECT Cover FROM DVD WHERE Inventario='12516'";
        //$sql="SELECT Link_Trailer FROM DVD WHERE Inventario = '$inventario';";

        if (!($result = $conn->query($sql))) {
            echo "Errore query trailer";
        }
        $conta = $result->num_rows;

        if (!($result1 = $conn->query($sql1))) {
            echo "Errore query copertina";
        }
        $conta1 = $result1->num_rows;

        if ($conta == 0) {
            echo "ATTENZIONE! Il trailer non è presente!";
        }
        if ($conta1 == 0) {
            echo "ATTENZIONE! La copertina non è presente!";
        } else {
            while ($row = $result1->fetch_array(MYSQLI_ASSOC)) {
                $url = $row['Cover'];
            }
            echo "<p><center><img src='$url' width='60%' height='auto' \></center></p>";
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $url = $row['Link_Trailer'];
            }
            echo "<center><iframe width='auto' height='auto' src='$url' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></center>";
        }
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $sqlTit = "SELECT Titolo FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlTit))) {
            echo "Errore query titolo";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Titolo'];
        }
        echo "<h1>" . $url . "</h1>";
        echo "<hr />";

        $sqlReg = "SELECT Regia FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlReg))) {
            echo "Errore query regista";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Regia'];
        }
        echo "<p>Regista: " . $url . "</p>";

        $sqlGen = "SELECT Nome_Genere FROM DVD INNER JOIN GENERE ON Genere = Id_Genere WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlGen))) {
            echo "Errore query genere";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Nome_Genere'];
        }
        echo "<p>Genere: " . $url . "</p>";

        $sqlAnno = "SELECT Anno FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlAnno))) {
            echo "Errore query anno";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Anno'];
        }
        echo "<p>Anno: " . $url . "</p>";

        $sqlLing = "SELECT Lingua_Originale FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlLing))) {
            echo "Errore query lingua";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Lingua_Originale'];
        }
        echo "<p>Lingua originale: " . $url . "</p>";

        $sqlLing = "SELECT Nome_Lingua FROM DVD INNER JOIN SOTTOTITOLATO_IN ON DVD.Inventario = SOTTOTITOLATO_IN.Inventario WHERE DVD.Inventario='12516';";
        if (!($result = $conn->query($sqlLing))) {
            echo "Errore query lingua";
        }
        echo "<p> Lingua sottotitoli: ";
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Nome_Lingua'];
            echo "- " . $url . " ";
        }
        echo "</p>";

        $sqlD = "SELECT Durata FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlD))) {
            echo "Errore query durata";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Durata'];
            echo "<p>Durata: " . $url . " minuti</p>";
        }

        $sqlDisp = "SELECT Disponibilita FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlDisp))) {
            echo "Errore query disponibilità";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Disponibilita'];
            echo "<p>Disponibilit&agrave: " . $url . "</p>";
        }

        $sqlRat = "SELECT Rating FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlRat))) {
            echo "Errore query valutazioni";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Rating'];
            echo "<p>Valutazione: " . $url . "</p>";
        }

        $sqlIMDB = "SELECT Link_IMDB_altro FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlIMDB))) {
            echo "Errore query IMDB";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Link_IMDB_altro'];
        }
        echo "<p>Link sito: <a href='$url'>IMDb</a></p>";

        $sqlTemi = "SELECT Nome_Tema FROM DVD INNER JOIN INCLUDE ON DVD.Inventario = INCLUDE.Inventario WHERE DVD.Inventario='12516';";
        if (!($result = $conn->query($sqlTemi))) {
            echo "Errore query temi";
        }
        echo "<p> Temi sviluppati: ";
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Nome_Tema'];
            echo "- " . $url . " ";
        }
        echo "</p>";

        $sqlS = "SELECT Sinossi FROM DVD WHERE Inventario='12516';";
        if (!($result = $conn->query($sqlS))) {
            echo "Errore query sinossi";
        }

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $url = $row['Sinossi'];
        }
        echo "<p>Sinossi: " . $url . "</p>";
        echo "<hr />";
        ?>
    </div>
    <div class="col-md-1"></div>
</div>


</body>

</html>
