<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta developer="Josip Plazanić">
    <meta developer="Bruno Polančec">
    <title>Špeceraj</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <style>
        table, th, td { border: solid 1px black; }

        /* css za proizvod */
        .objekt{
            display: flex;
            background-color: #F0D09C;
            border: 2px solid black;
            border-radius: 15px;
            padding: 10px;
            width: 600px;
            height: 250px;
            margin: 10px;
            align-items: center;
            /* justify-content: center; */
        }
        /* Opis je slika i ime proizvoda */
        .objekt .opis{
            height: 100%;
            width: 150px;
            float: left;
            padding: 10px;
        }
        .objekt img {
            border-radius: 15px;
            padding: 10px;
            width: 100px;
            height: 100px;
            margin: 10px;
        }
        .objekt h4 {
            text-align: center;
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }
        /* Ducani su svi ducani koji imaju taj proizvod (logo, cijena, gumb) */
        .objekt .ducani{
            height: 100%;
            float: right;
            padding: 10px;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }
        .objekt .ducani .jedan_ducan{
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        /* logo ducana */
        .ducani img {
            border-radius: 15px;
            padding: 10px;
            width: 70px;
            height: 70px;
            margin: 10px;
        }
        .ducani button{
            margin: 5px;
            width: 70px;
        }
        .akcija{
            background-color: #F0A49C;
        }
        .kolicina{
            width: 100px;
            padding: 5px;
        }
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
        
        <!-- Za maknut kasnije -->
        <li><a href="test_index.php">TEST</a></li>
        <!-- .. -->
    </ul>

    <h3> <?php echo $title; ?> </h3>
