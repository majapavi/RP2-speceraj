<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/kupci.class.php';
require_once __DIR__ . '/ducani.class.php';
require_once __DIR__ . '/proizvodi.class.php';
require_once __DIR__ . '/ponude.class.php';
require_once __DIR__ . '/recenzije.class.php';
require_once __DIR__ . '/kartica.class.php';
require_once __DIR__ . '/ducani2.class.php';

class SpecerajService
{
    function getAllKupci()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Kupci`' );
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
        $st = $db->prepare( 'SELECT * FROM `projekt_Ducani`' );
        $st->execute();

        $ducani = [];
        while( $row = $st->fetch() )
        {
            $ducan = new Ducan( $row['ID'], $row['Naziv'], $row['Prosjek'], $row['Link_na_logo'] );
            $ducani[] = $ducan;
        }

        return $ducani;
    }

    function getAllProizvodi()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Proizvodi`' );
        $st->execute();

        $proizvodi = [];
        while( $row = $st->fetch() )
        {
            $proizvod = new Proizvod( $row['ID'], $row['Naziv'], $row['Link_na_sliku'], $row['Korak'] );
            $proizvodi[] = $proizvod;
        }

        return $proizvodi;
    }

    function getAllPonude()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Ponude`' );
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
        $st = $db->prepare( 'SELECT * FROM `projekt_Recenzije`' );
        $st->execute();

        $recenzije = [];
        while( $row = $st->fetch() )
        {
            $recenzija = new Recenzija( $row['ID'], $row['ID_Ducan'], $row['ID_User'], $row['Ocjena'], $row['Tekst'] );
            $recenzije[] = $recenzija;
        }

        return $recenzije;
    }

    function getProizvodById( $id_proizvod )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Proizvodi` WHERE `id` = :id' );
        $st->bindParam(':id', $id_proizvod, PDO::PARAM_INT);
        $st->execute();

        if( $row = $st->fetch() ) {
            $proizvod = new Proizvod( $row['ID'], $row['Naziv'], $row['Link_na_sliku'], $row['Korak'] );

            return $proizvod;
        }
    }

    function getDucanById( $id_ducan )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Ducani` WHERE `id` = :id' );
        $st->bindParam(':id', $id_ducan, PDO::PARAM_INT);
        $st->execute();

        if( $row = $st->fetch() ) {
            $ducan = new Ducan( $row['ID'], $row['Naziv'], $row['Prosjek'], $row['Link_na_logo'] );

            return $ducan;
        }
    }

    function getKarticaByIdProizvoda( $id_proizvod )
    {
        $ponude = $this->getAllPonude();
        $proizvod = $this->getProizvodById( $id_proizvod );

        $ducani = [];
        foreach( $ponude as $ponuda ) {
            if( (int)$ponuda->ID_Proizvod === $id_proizvod ) {
                $ducan = $this->getDucanById( $ponuda->ID_Ducan );
                if( $ponuda->Akcija === NULL ) {
                    $ducan2 = new Ducan2( $ducan->Logo, $ponuda->Cijena, "NE" );
                    $ducani[] = $ducan2;
                }
                else {
                    $ducan2 = new Ducan2( $ducan->Logo, $ponuda->Akcija, "DA" );
                    $ducani[] = $ducan2;
                }
            }
        }
        $kartica = new Kartica( $proizvod->ID, $proizvod->Naziv, $proizvod->Link, $ducani );

        return $kartica;
    }
}

?>
