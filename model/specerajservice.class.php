<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/kupci.class.php';
require_once __DIR__ . '/ducani.class.php';
require_once __DIR__ . '/proizvodi.class.php';
require_once __DIR__ . '/ponude.class.php';
require_once __DIR__ . '/recenzije.class.php';

class SpecerajService
{
    function getAllKupci()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM projekt_Kupci' );
        $st->execute();

        $kupci = [];
        while( $row = $st->fetch() )
        {
            $kupac = new Kupac( $row['ID'], $row['Ime'], $row['Prezime'], $row['Password_Hash'] );
            $kupci[] = $kupac;
        }

        return $kupci;
    }

    function getAllDucani()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM projekt_Ducani' );
        $st->execute();

        $ducani = [];
        while( $row = $st->fetch() )
        {
            $ducan = new Ducan( $row['ID'], $row['Naziv'], $row['Prosjek'] );
            $ducani[] = $ducan;
        }

        return $ducani;
    }

    function getAllProizvodi()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM projekt_Proizvodi' );
        $st->execute();

        $proizvodi = [];
        while( $row = $st->fetch() )
        {
            $proizvod = new Proizvod( $row['ID'], $row['Naziv'], $row['Link_na_sliku'] );
            $proizvodi[] = $proizvod;
        }

        return $proizvodi;
    }

    function getAllPonude()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM projekt_Ponude' );
        $st->execute();

        $ponude = [];
        while( $row = $st->fetch() )
        {
            $ponuda = new Ponuda( $row['ID'], $row['ID_Proizvod'], $row['ID_Ducan'], $row['Cijena'], $row['Akcija'] );
            $ponude[] = $ponuda;
        }

        return $ponude;
    }

    function getAllRecenzije()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM projekt_Recenzije' );
        $st->execute();

        $recenzije = [];
        while( $row = $st->fetch() )
        {
            $recenzija = new Recenzija( $row['ID'], $row['ID_Ducan'], $row['ID_User'], $row['Ocjena'], $row['Tekst'] );
            $recenzije[] = $recenzija;
        }

        return $recenzije;
    }
}

?>
