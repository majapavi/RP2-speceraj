<?php

// Manualno inicijaliziramo bazu ako već nije.
require_once 'db.class.php';

$db = DB::getConnection();

$has_tables = false;

try
{
    $st = $db->prepare(
        'SHOW TABLES LIKE :tblname'
    );

    $st->execute( array( 'tblname' => 'projekt_Kupci' ) );
    if( $st->rowCount() > 0 )
        $has_tables = true;

    $st->execute( array( 'tblname' => 'projekt_Ducani' ) );
    if( $st->rowCount() > 0 )
        $has_tables = true;

    $st->execute( array( 'tblname' => 'projekt_Proizvodi' ) );
    if( $st->rowCount() > 0 )
        $has_tables = true;

    $st->execute( array( 'tblname' => 'projekt_Ponude' ) );
    if( $st->rowCount() > 0 )
        $has_tables = true;

    $st->execute( array( 'tblname' => 'projekt_Recenzije' ) );
    if( $st->rowCount() > 0 )
        $has_tables = true;

}
catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }


if( $has_tables )
{
    exit( 'Tablice projekt_Kupci / projekt_Ducani / projekt_Proizvodi / projekt_Ponude / projekt_Recenzije već postoje. Obrišite ih pa probajte ponovno.' );
}


try {
    $st = $db->prepare("
        CREATE TABLE IF NOT EXISTS projekt_Kupci (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(15) NOT NULL,
            Password_Hash VARCHAR(255) NOT NULL
        )
    ");
    $st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create projekt_Kupci]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_Kupci.<br />";

try {
    $st = $db->prepare("
        CREATE TABLE IF NOT EXISTS projekt_Ducani (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            Naziv VARCHAR(100) NOT NULL,
            Prosjek FLOAT NOT NULL,
            Link_na_logo VARCHAR(255) NOT NULL
        )
    ");
    $st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create projekt_Ducani]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_Ducani.<br />";

try {
    $st = $db->prepare("
        CREATE TABLE IF NOT EXISTS projekt_Proizvodi (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            Naziv VARCHAR(100) NOT NULL,
            Opis VARCHAR(255),
            Link_na_sliku VARCHAR(255) NOT NULL,
            Korak DECIMAL(3,2) DEFAULT 1.0
        )
    ");
    $st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create projekt_Proizvodi]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_Proizvodi.<br />";

try {
    $st = $db->prepare("
        CREATE TABLE IF NOT EXISTS projekt_Ponude (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            ID_Proizvod INT NOT NULL,
            ID_Ducan INT NOT NULL,
            Cijena DECIMAL(10, 2) NOT NULL,
            Akcija DECIMAL(10, 2) DEFAULT NULL
        )
    ");
    $st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create projekt_Ponude]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_Ponude.<br />";

try {
    $st = $db->prepare("
        CREATE TABLE IF NOT EXISTS projekt_Recenzije (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            ID_Ducan INT NOT NULL,
            ID_User INT NOT NULL,
            Ocjena INT NOT NULL,
            Tekst TEXT NOT NULL
        )
    ");
    $st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create projekt_Recenzije]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_Recenzije.<br />";


// slijedi ubacivanje nekih početnih


// Insert examples into Kupci
try {
    $st = $db->prepare('INSERT INTO projekt_Kupci (Username, Password_Hash) VALUES (:username, :pass)');

    $st->execute(array('username' => 'BrunoPol', 'pass' => password_hash('bruninasifra', PASSWORD_DEFAULT)));
    $st->execute(array('username' => 'JosipPlaz', 'pass' => password_hash('josipovasifra', PASSWORD_DEFAULT)));
    $st->execute(array('username' => '', 'pass' => password_hash('', PASSWORD_DEFAULT)));
}
catch( PDOException $e ) { exit( "PDO error [insert projekt_Kupci]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_Kupci.<br />";


// Insert examples into Ducani
try {
    $st = $db->prepare('INSERT INTO projekt_Ducani (Naziv, Prosjek, Link_na_logo) VALUES (:naziv, :prosjek, :logo)');

    $st->execute(array('naziv' => 'Konzum', 'prosjek' => 4.5, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/konzum.png'));
    $st->execute(array('naziv' => 'Spar', 'prosjek' => 3.8, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/spar.png'));
    $st->execute(array('naziv' => 'Lidl', 'prosjek' => 4.1, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/lidl.png'));
    $st->execute(array('naziv' => 'Studenac', 'prosjek' => 3.5, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/studenac.png'));
    $st->execute(array('naziv' => 'Robin', 'prosjek' => 4.7, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/robin.png'));
    $st->execute(array('naziv' => 'Bio&Bio', 'prosjek' => 4.2, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/biobio.png'));
}
catch( PDOException $e ) { exit( "PDO error [projekt_Ducani]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_Ducani.<br />";


// Insert examples into Proizvodi
try {
    $st = $db->prepare('INSERT INTO projekt_Proizvodi (Naziv, Opis, Link_na_sliku, Korak) VALUES (:naziv, :opis, :link, :korak)');

    $products = [
        ['naziv' => 'Mlijeko', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mlijeko.png', 'korak' => 1.0],
        ['naziv' => 'Jogurt', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/jogurt.png', 'korak' => 1.0],
        ['naziv' => 'Kiselo vrhnje', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kiselo_vrhnje.png', 'korak' => 1.0],
        ['naziv' => 'Maslac', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/maslac.png', 'korak' => 1.0],
        ['naziv' => 'Vrhnje za kuhanje', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/vrhnje_za_kuhanje.png', 'korak' => 1.0],
        ['naziv' => 'Svježi sir', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi, sir', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/svjezi_sir.png', 'korak' => 1.0],
        ['naziv' => 'Gauda', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi, narezak, naresci, sir', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/gauda.png', 'korak' => 0.1],
        ['naziv' => 'Škripavac', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi, narezak, naresci, sir', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/skripavac.png', 'korak' => 0.1],
        ['naziv' => 'Mozzarella', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi, sir', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mozzarella.png', 'korak' => 1.0],
        ['naziv' => 'Feta sir', 'opis' => 'Mliječni proizvodi, Mlijecni proizvodi, sir', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/feta_sir.png', 'korak' => 1.0],
        ['naziv' => 'Bijeli kruh', 'opis' => 'Kruh, peciva, pecivo', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/bijeli_kruh.png', 'korak' => 0.5],
        ['naziv' => 'Crni kruh', 'opis' => 'Kruh, peciva, pecivo', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/crni_kruh.png', 'korak' => 0.5],
        ['naziv' => 'Integralni kruh', 'opis' => 'Kruh, peciva, pecivo', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/integralni_kruh.png', 'korak' => 0.5],
        ['naziv' => 'Kukuruzni kruh', 'opis' => 'Kruh, peciva, pecivo', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kukuruzni_kruh.png', 'korak' => 0.5],
        ['naziv' => 'Pšenični kruh', 'opis' => 'Kruh, peciva, pecivo', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/psenicni_kruh.png', 'korak' => 0.5],
        ['naziv' => 'Pogača', 'opis' => 'Kruh, peciva, pecivo', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/pogaca.png', 'korak' => 1.0],
        ['naziv' => 'Baget', 'opis' => 'Kruh, peciva, pecivo', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/baget.png', 'korak' => 1.0],
        ['naziv' => 'Pileća prsa', 'opis' => 'Meso, piletina', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/pileca_prsa.png', 'korak' => 0.1],
        ['naziv' => 'Pileća krilca', 'opis' => 'Meso, piletina', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/pileca_krilca.png', 'korak' => 0.1],
        ['naziv' => 'Svinjski kotlet', 'opis' => 'Meso, svinjetina', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/svinjski_kotlet.png', 'korak' => 0.1],
        ['naziv' => 'Svinjski but', 'opis' => 'Meso, svinjetina', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/svinjski_but.png', 'korak' => 0.1],
        ['naziv' => 'Goveđi odrezak', 'opis' => 'Meso, govedina', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/govedji_odrezak.png', 'korak' => 0.1],
        ['naziv' => 'Junetina za gulaš', 'opis' => 'Meso, junetina', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/junetina_za_gulas.png', 'korak' => 0.1],
        ['naziv' => 'Janjetina', 'opis' => 'Meso, janjetina', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/janjetina.png', 'korak' => 0.1],
        ['naziv' => 'Kranjske kobasice', 'opis' => 'Meso, kobasica, kobasice', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kranjske_kobasice.png', 'korak' => 1.0],
        ['naziv' => 'Roštilj kobasice', 'opis' => 'Meso, kobasica, kobasice', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/rostilj_kobasice.png', 'korak' => 1.0],
        ['naziv' => 'Špageti', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/spageti.png', 'korak' => 1.0],
        ['naziv' => 'Penne', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/penne.png', 'korak' => 1.0],
        ['naziv' => 'Fusilli', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/fusilli.png', 'korak' => 1.0],
        ['naziv' => 'Tagliatelle', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/tagliatelle.png', 'korak' => 1.0],
        ['naziv' => 'Lasagne', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/lasagne.png', 'korak' => 1.0],
        ['naziv' => 'Rigatoni', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/rigatoni.png', 'korak' => 1.0],
        ['naziv' => 'Farfalle', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/farfalle.png', 'korak' => 1.0],
        ['naziv' => 'Tortellini', 'opis' => 'Tjestenina, pasta, pašta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/tortellini.png', 'korak' => 1.0],
        ['naziv' => 'Zobene pahuljice', 'opis' => 'Žitarice, zitarice, sjemenke, pahuljice', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/zobene_pahuljice.png', 'korak' => 1.0],
        ['naziv' => 'Kukuruzne pahuljice', 'opis' => 'Žitarice, zitarice, sjemenke, pahuljice', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kukuruzne_pahuljice.png', 'korak' => 1.0],
        ['naziv' => 'Ječam', 'opis' => 'Žitarice, zitarice, sjemenke', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/jecam.png', 'korak' => 1.0],
        ['naziv' => 'Proso', 'opis' => 'Žitarice, zitarice, sjemenke', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/proso.png', 'korak' => 1.0],
        ['naziv' => 'Ražene pahuljice', 'opis' => 'Žitarice, zitarice, sjemenke, pahuljice', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/razene_pahuljice.png', 'korak' => 1.0],
        ['naziv' => 'Quinoa', 'opis' => 'Žitarice, zitarice, sjemenke', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/quinoa.png', 'korak' => 1.0],
        ['naziv' => 'Chia sjemenke', 'opis' => 'Žitarice, zitarice, sjemenke', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/chia_sjemenke.png', 'korak' => 1.0],
        ['naziv' => 'Šunka', 'opis' => 'Naresci, narezak, salama', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/sunka.png', 'korak' => 0.1],
        ['naziv' => 'Pršut', 'opis' => 'Naresci, narezak, salama', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/prsut.png', 'korak' => 0.1],
        ['naziv' => 'Kulen', 'opis' => 'Naresci, narezak, salama', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kulen.png', 'korak' => 0.1],
        ['naziv' => 'Mortadela', 'opis' => 'Naresci, narezak, salama', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mortadela.png', 'korak' => 0.1],
        ['naziv' => 'Salama', 'opis' => 'Naresci, narezak, salama', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/salama.png', 'korak' => 0.1],
        ['naziv' => 'Buđola', 'opis' => 'Naresci, narezak, salama', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/budola.png', 'korak' => 0.1],
        ['naziv' => 'Jabuke', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/jabuke.png', 'korak' => 0.1],
        ['naziv' => 'Banane', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/banane.png', 'korak' => 0.1],
        ['naziv' => 'Naranče', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/narance.png', 'korak' => 0.1],
        ['naziv' => 'Mandarine', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mandarine.png', 'korak' => 0.1],
        ['naziv' => 'Jagode', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/jagode.png', 'korak' => 0.1],
        ['naziv' => 'Grožđe', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/grozde.png', 'korak' => 0.1],
        ['naziv' => 'Lubenica', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/lubenica.png', 'korak' => 0.1],
        ['naziv' => 'Kivi', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kivi.png', 'korak' => 0.1],
        ['naziv' => 'Rajčice', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/rajcice.png', 'korak' => 0.1],
        ['naziv' => 'Krastavci', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/krastavci.png', 'korak' => 0.1],
        ['naziv' => 'Paprike', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/paprike.png', 'korak' => 0.1],
        ['naziv' => 'Luk', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/luk.png', 'korak' => 0.1],
        ['naziv' => 'Krumpir', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/krumpir.png', 'korak' => 0.1],
        ['naziv' => 'Mrkva', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mrkva.png', 'korak' => 0.1],
        ['naziv' => 'Salata', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/salata.png', 'korak' => 1.0],
        ['naziv' => 'Brokula', 'opis' => 'Voće i Povrće, voce i povrce', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/brokula.png', 'korak' => 0.1],
        ['naziv' => 'Bomboni', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/bomboni.png', 'korak' => 1.0],
        ['naziv' => 'Keksi', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/keksi.png', 'korak' => 1.0],
        ['naziv' => 'Medenjaci', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/medenjaci.png', 'korak' => 1.0],
        ['naziv' => 'Krafne', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/krafne.png', 'korak' => 1.0],
        ['naziv' => 'Kolači', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kolaci.png', 'korak' => 1.0],
        ['naziv' => 'Pita', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/pita.png', 'korak' => 1.0],
        ['naziv' => 'Čips', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/cips.png', 'korak' => 1.0],
        ['naziv' => 'Kokice', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kokice.png', 'korak' => 1.0],
        ['naziv' => 'Kikiriki', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kikiriki.png', 'korak' => 1.0],
        ['naziv' => 'Slani štapići', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/slani_stapici.png', 'korak' => 1.0],
        ['naziv' => 'Krekeri', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/krekeri.png', 'korak' => 1.0],
        ['naziv' => 'Mliječna čokolada', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mlijecna_cokolada.png', 'korak' => 1.0],
        ['naziv' => 'Tamna čokolada', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/tamna_cokolada.png', 'korak' => 1.0],
        ['naziv' => 'Bijela čokolada', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/bijela_cokolada.png', 'korak' => 1.0],
        ['naziv' => 'Čokolada s lješnjacima', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/cokolada_s_ljesnjacima.png', 'korak' => 1.0],
        ['naziv' => 'Čokolada s rižom', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/cokolada_s_rizom.png', 'korak' => 1.0],
        ['naziv' => 'Čokolada s narančom', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/cokolada_s_narancom.png', 'korak' => 1.0],
        ['naziv' => 'Čokolada s keksom', 'opis' => 'Grickalice, slatkiši, slatkisi, cokolada, čokolada', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/cokolada_s_keksom.png', 'korak' => 1.0],
    ];

    foreach ($products as $product) {
        $st->execute($product);
    }
}
catch( PDOException $e ) { exit( "PDO error [projekt_Proizvodi]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_Proizvodi.<br />";


// Insert examples into Ponude
try {
    $st = $db->prepare('INSERT INTO projekt_Ponude (ID_Proizvod, ID_Ducan, Cijena, Akcija) VALUES (:id_proizvod, :id_ducan, :cijena, :akcija)');

    $normalna_cijena = [1.50, 0.70, 0.90, 3.00, 2.50,
                        2.00, 5.50, 18.04, 2.50, 4.00,
                        1.50, 2.00, 2.30, 1.59, 2.49,
                        0.30, 0.70, 7.30, 5.31, 6.70,
                        7.10, 13.00, 11.49, 12.00, 3.50,
                        3.50, 1.70, 1.95, 1.95, 3.00,
                        3.00, 2.59, 2.00, 2.20, 1.00,
                        3.50, 2.10, 2.50, 1.70, 4.00,
                        1.50, 9.00, 30.00, 25.00, 8.00,
                        3.00, 17.00, 1.40, 1.44, 1.30,
                        1.59, 5.00, 3.00, 1.20, 4.00,
                        2.50, 2.96, 3.50, 1.10, 1.10,
                        0.90, 0.69, 3.00, 2.45, 2.65,
                        3.00, 0.69, 1.20, 4.00, 1.75,
                        1.40, 2.70, 0.85, 0.99, 3.50,
                        3.90, 3.60, 3.50, 2.80, 3.90, 
                        3.90
                        ];

    $offers = [];
    for( $id_proizvod = 1 ; $id_proizvod < 82 ; $id_proizvod++ ){
        for( $id_ducan = 1 ; $id_ducan < 7 ; $id_ducan++){

            // ~5% šanse da proizvoda nema u nekom ducanu
            if( rand(1, 100) < 6 ){
                continue;
            }

            // Varijacija u cijeni među dućanima
            $cijena = round( $normalna_cijena[ $id_proizvod - 1 ] * rand(70, 130) / 100 , 2 );
            
            // ~12% šansa da je proizvod na akciji
            $akcija = NULL;
            if( rand(1,100) < 13){
                // 10-50% akcija
                $akcija = round($cijena * rand(50,90) / 100, 2 );
            }

            // Punimo offers
            $offers[] = [
                'id_proizvod' => $id_proizvod,
                'id_ducan' => $id_ducan,
                'cijena' => $cijena,
                'akcija' => $akcija,
            ];

        }
    }

    // Punimo DB
    foreach ($offers as $offer) {
        $st->execute($offer);
    }
    
}
catch( PDOException $e ) { exit( "PDO error [projekt_Ponude]: " . $e->getMessage() ); }
    
echo "Ubacio u tablicu projekt_Ponude.<br />";


// Insert examples into Recenzije
try {
    $st = $db->prepare('INSERT INTO projekt_Recenzije (ID_Ducan, ID_User, Ocjena, Tekst) VALUES (:id_ducan, :id_user, :ocjena, :tekst)');

    $st->execute(array('id_ducan' => 1, 'id_user' => 1, 'ocjena' => 5, 'tekst' => 'Odlična usluga!'));
    $st->execute(array('id_ducan' => 2, 'id_user' => 2, 'ocjena' => 4, 'tekst' => 'Dobar izbor proizvoda.'));
    $st->execute(array('id_ducan' => 3, 'id_user' => 1, 'ocjena' => 3, 'tekst' => 'Moglo bi biti bolje.'));
}
catch( PDOException $e ) { exit( "PDO error [projekt_Recenzije]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_Recenzije.<br />";

?>
