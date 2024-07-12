<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta developer="Maja Pavičić">
    <meta developer="Josip Plazanić">
    <meta developer="Bruno Polančec">
    <title>Špeceraj</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="assets/js/cookies.js"></script>
    <script src="assets/js/kartice.js"></script>
    <!-- <link rel="stylesheet" href="https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/view/stil.css"> -->
    <link rel="stylesheet" href="assets/css/kartice.css">
    <link rel="stylesheet" href="assets/css/basic.css">
    <link rel="stylesheet" href="assets/css/recenzije.css">
</head>
<body>
    <header>
        <div class="header-row">
            <h1 class="left-title">Špeceraj</h1>
            <div class="right-title-2">
                <div class="user-info">
                    <?php $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime']; ?>
                    <div class="user-greeting">
                        <span>Bok, <?php echo $loginUser ?>!</span>
                    </div>
                    <form action="index.php" method="post">
                        <input type="submit" value="Odjavite se" name="btn_logout" class="logout">
                    </form>
                </div>
            </div>
        </div>
        <ul class="navbar">
            <li><a href="index.php?rt=ponude/index">Ponude</a></li>
            <li><a href="index.php?rt=akcije/index">Akcije</a></li>
            <li><a href="index.php?rt=recenzije/index">Recenzije</a></li>
            <li><a href="index.php?rt=kosarica/index">Moja košarica</a></li>
        </ul>
    </header>
    <main>
    <div class="header-row">
        <h3 class="left-title"><?php echo $title; ?></h3>
        <h3 class="right-title"><?php if(isset($title2)) {echo $title2; echo "<strong class='ocjena_ducana'></strong> :";} ?></h3>
    </div>
