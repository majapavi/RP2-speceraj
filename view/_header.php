<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Špeceraj</title>

    <style>
        table, th, td { border: solid 1px black; }
    </style>
</head>
<body>
    <h1>Špeceraj</h1>

    <ul>
        <li><a href="index.php?rt=kupci/index">Popis svih kupaca</a></li>
        <li><a href="index.php?rt=ducani/index">Popis svih dućana</a></li>
        <li><a href="index.php?rt=proizvodi/index">Popis svih proizvoda</a></li>
        <li><a href="index.php?rt=ponude/index">Popis svih ponuda</a></li>
        <li><a href="index.php?rt=recenzije/index">Popis svih recenzija</a></li>
    </ul>

    <h3> <?php echo $title; ?> </h3>
