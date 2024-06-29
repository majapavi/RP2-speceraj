<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/kupci.class.php';
require_once __DIR__ . '/ducani.class.php';
require_once __DIR__ . '/proizvodi.class.php';
require_once __DIR__ . '/ponude.class.php';
require_once __DIR__ . '/recenzije.class.php';
require_once __DIR__ . '/kartica.class.php';
require_once __DIR__ . '/ducani2.class.php';
require_once __DIR__ . '/akcija.class.php';

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
            $proizvod = new Proizvod( $row['ID'], $row['Naziv'], $row['Opis'], $row['Link_na_sliku'], $row['Korak'] );
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
        $st = $db->prepare( 'SELECT * FROM `projekt_Proizvodi` WHERE `ID` = :id' );
        $st->bindParam(':id', $id_proizvod, PDO::PARAM_INT);
        $st->execute();

        if( $row = $st->fetch() ) {
            $proizvod = new Proizvod( $row['ID'], $row['Naziv'], $row['Opis'], $row['Link_na_sliku'], $row['Korak'] );

            return $proizvod;
        }
    }

    function getDucanById( $id_ducan )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Ducani` WHERE `ID` = :id' );
        $st->bindParam(':id', $id_ducan, PDO::PARAM_INT);
        $st->execute();

        if( $row = $st->fetch() ) {
            $ducan = new Ducan( $row['ID'], $row['Naziv'], $row['Prosjek'], $row['Link_na_logo'] );

            return $ducan;
        }
    }

    function getPonudeByIdProizvod( $id_proizvod )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Ponude` WHERE `ID_Proizvod` = :id' );
        $st->bindParam(':id', $id_proizvod, PDO::PARAM_INT);
        $st->execute();

        $ponude = [];
        while( $row = $st->fetch() )
        {
            $ponuda = new Ponuda( $row['ID'], $row['ID_Proizvod'], $row['ID_Ducan'], $row['Cijena'], $row['Akcija'] );
            $ponude[] = $ponuda;
        }

        return $ponude;
    }

    function getKarticaByIdProizvoda( $id_proizvod )
    {
        $ponude = $this->getPonudeByIdProizvod( $id_proizvod );
        $proizvod = $this->getProizvodById( $id_proizvod );

        $ducani = [];
        foreach( $ponude as $ponuda ) {
            $ducan = $this->getDucanById( $ponuda->ID_Ducan );
            if( $ponuda->Akcija === NULL ) {
                $ducan2 = new Ducan2( $ducan->Naziv, $ducan->Link, $ponuda->Cijena, "NE" );
                $ducani[] = $ducan2;
            }
            else {
                $ducan2 = new Ducan2( $ducan->Naziv, $ducan->Link, $ponuda->Akcija, "DA" );
                $ducani[] = $ducan2;
            }
        }
        $kartica = new Kartica( $proizvod->ID, $proizvod->Naziv, $proizvod->Link, $proizvod->Korak, $ducani );

        return $kartica;
    }

    function getAllKartice( $search = '', $sort = '' )
    {
        $db = DB::getConnection();
        $st = null;
        $query = 'SELECT `ID` FROM `projekt_Proizvodi`';

        if ($search !== '' && $sort !== '') {
            $query .= ' WHERE `Naziv` LIKE :nesto ORDER BY ' . $sort;
        } else if ($search !== '') {
            $query .= ' WHERE `Naziv` LIKE :nesto';
        } else if ($sort !== '') {
            $query .= ' ORDER BY ' . $sort;
        }

        $st = $db->prepare($query);

        if ($search !== '') {
            $search = '%' . $search . '%';
            $st->bindParam(':nesto', $search, PDO::PARAM_STR);
        }

        $st->execute();

        $indexi = [];
        while ($row = $st->fetch()) {
            $indexi[] = (int) $row['ID'];
        }

        $sve_kartice = [];
        foreach ($indexi as $i) {
            $kartica = $this->getKarticaByIdProizvoda( $i );
            $sve_kartice[] = $kartica;
        }

        return $sve_kartice;
    }

    function getAllAkcije( $search = '', $sort = '' )
    {
        $db = DB::getConnection();
        $st = null;
        $query = 'SELECT p.ID, p.ID_Proizvod, p.ID_Ducan, p.Cijena, p.Akcija
                  FROM projekt_Ponude p
                  JOIN projekt_Proizvodi pr ON p.ID_Proizvod = pr.ID
                  JOIN projekt_Ducani d ON p.ID_Ducan = d.ID
                  WHERE p.Akcija IS NOT NULL';

        if ($search !== '') {
            $query .= ' AND (pr.Naziv LIKE :search OR pr.Opis LIKE :search)';
        }

        if ($sort !== '') {
            if (strpos($sort, 'A') === 0) {
                $query .= ' ORDER BY ' . $sort;
            } elseif (strpos($sort, 'N') === 0) {
                $query .= ' ORDER BY pr.' . $sort;
            } else {
                // Default sort order if invalid sort is provided
                $query .= ' ORDER BY p.ID ASC';
            }
        }

        $st = $db->prepare($query);

        if ($search !== '') {
            $searchParam = '%' . $search . '%';
            $st->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }

        $st->execute();

        $akcije = [];
        while( $row = $st->fetch() ) {
            $proizvod = $this->getProizvodById($row['ID_Proizvod']);
            $ducan = $this->getDucanById($row['ID_Ducan']);

            $akcija = new Akcija( $row['ID'], $proizvod->Naziv, $proizvod->Link, $ducan->Naziv, $ducan->Link, $row['Cijena'], $row['Akcija'] );

            $akcije[] = json_encode( $akcija );
        }

        return $akcije;
    }
}

?>
