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
    <script src="assets/js/kartice.js"></script>
    <!-- <link rel="stylesheet" href="https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/view/stil.css"> -->
    <link rel="stylesheet" href="assets/css/kartice.css">
    <link rel="stylesheet" href="assets/css/basic.css">

</head>
<body>
    <header>
        <h1>Špeceraj</h1>
        <div class="user-info">
            <span>Hello, <?php echo $loginUser ?>!</span>
            <br>
            <form action="index.php" method="post">
                <input type="submit" value="Logout" name="btn_logout" class="logout">
            </form>
        </div>
        <ul class="navbar">
            <li><a href="index.php?rt=kupci/index">Popis svih kupaca</a></li>
            <li><a href="index.php?rt=ducani/index">Popis svih dućana</a></li>
            <li><a href="index.php?rt=proizvodi/index">Popis svih proizvoda</a></li>
            <li><a href="index.php?rt=ponude/index">Popis svih ponuda</a></li>
            <li><a href="index.php?rt=recenzije/index">Popis svih recenzija</a></li>

            <!-- Za maknut kasnije -->
            <li><a href="index.php?rt=ponude/test">TEST</a></li>
            <!-- .. -->
        </ul>
    </header>
    <main>
    <h3> <?php echo $title; ?> </h3>
