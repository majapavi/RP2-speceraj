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
            Ime VARCHAR(50) NOT NULL,
            Prezime VARCHAR(50) NOT NULL,
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
            Link_na_sliku VARCHAR(255) NOT NULL,
            Korak NUMERIC DEFAULT 1.0
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
    $st = $db->prepare('INSERT INTO projekt_Kupci (Ime, Prezime, Password_Hash) VALUES (:ime, :prez, :pass)');

    $st->execute(array('ime' => 'Bruno', 'prez' => 'Polančec', 'pass' => password_hash('bruninasifra', PASSWORD_DEFAULT)));
    $st->execute(array('ime' => 'Josip', 'prez' => 'Plazanić', 'pass' => password_hash('josipovasifra', PASSWORD_DEFAULT)));
}
catch( PDOException $e ) { exit( "PDO error [insert projekt_Kupci]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_Kupci.<br />";


// Insert examples into Ducani
try {
    $st = $db->prepare('INSERT INTO projekt_Ducani (Naziv, Prosjek, Link_na_logo) VALUES (:naziv, :prosjek, :logo)');

    $st->execute(array('naziv' => 'Konzum', 'prosjek' => 4.5, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/konzum.png'));
    $st->execute(array('naziv' => 'Spar', 'prosjek' => 3.8, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/spar.png'));
    $st->execute(array('naziv' => 'Lidl', 'prosjek' => 4.2, 'logo' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/lidl.png'));
}
catch( PDOException $e ) { exit( "PDO error [projekt_Ducani]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_Ducani.<br />";


// Insert examples into Proizvodi
try {
    $st = $db->prepare('INSERT INTO projekt_Proizvodi (Naziv, Link_na_sliku, Korak) VALUES (:naziv, :link, :korak)');

    $st->execute(array('naziv' => 'Sir', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/sir.png', 'korak' => 0.1));
    $st->execute(array('naziv' => 'Krumpir', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/krumpir.png', 'korak' => 0.1));
    $st->execute(array('naziv' => 'Mrkva', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mrkva.png', 'korak' => 0.1));
    $st->execute(array('naziv' => 'Palenta', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/palenta.png', 'korak' => 1.0));
    $st->execute(array('naziv' => 'Mlijeko', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/mlijeko.png', 'korak' => 1.0));
    $st->execute(array('naziv' => 'Kruh', 'link' => 'https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/kruh.png', 'korak' => 0.5));
}
catch( PDOException $e ) { exit( "PDO error [projekt_Proizvodi]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_Proizvodi.<br />";


// Insert examples into Ponude
try {
    $st = $db->prepare('INSERT INTO projekt_Ponude (ID_Proizvod, ID_Ducan, Cijena, Akcija) VALUES (:id_proizvod, :id_ducan, :cijena, :akcija)');

    $st->execute(array('id_proizvod' => 1, 'id_ducan' => 1, 'cijena' => 9.99, 'akcija' => 6.99));
    $st->execute(array('id_proizvod' => 2, 'id_ducan' => 1, 'cijena' => 1.99, 'akcija' => NULL));
    $st->execute(array('id_proizvod' => 3, 'id_ducan' => 2, 'cijena' => 1.39, 'akcija' => NULL));
    $st->execute(array('id_proizvod' => 4, 'id_ducan' => 3, 'cijena' => 1.99, 'akcija' => 1.09));
    $st->execute(array('id_proizvod' => 4, 'id_ducan' => 2, 'cijena' => 1.89, 'akcija' => NULL));
    $st->execute(array('id_proizvod' => 5, 'id_ducan' => 3, 'cijena' => 1.07, 'akcija' => NULL));
    $st->execute(array('id_proizvod' => 6, 'id_ducan' => 1, 'cijena' => 0.89, 'akcija' => NULL));
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
