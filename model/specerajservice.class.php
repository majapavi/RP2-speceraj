<!-- 
 Ovaj servis sadrzi sljedece funkcionalnosti:

    getAll() funkcije:          getAllKupci(), getAllDucani(), getAllProizvodi(), getAllPonude(), getAllRecenzije()

    getById() funkcije:         getProizvodById( $id_proizvod ), getDucanById( $id_ducan ), getPonudaById( $id_ponuda ),
                                getPonudeByIdProizvod( $id_proizvod ) -> PO IDu DRUGE KLASE

    prepareView() funkcije:     getKosaricaArtiklInfo( $id_ponuda, $kolicina ), getAllArtikliInfo( $kosarica ), getKarticaByIdProizvoda( $id_proizvod ),
                                getAllKartice( $search = '', $sort = '' ), getAllAkcije( $search = '', $sort = '', $ducani_ids = [1,2,3,4,5,6] ), getRecenzijeForView()

    funkcije za Kosaricu:       getNajjeftinijaPonudaProizvoda( $id_proizvod ), getProizvodiFromPonude($ponudeUKosarici), izracunajPotrosnjuUDucanu($ducan_id, $proizvodiUKosarici)

    funkcije za Recenzije:      unesiRecenziju( $user_id, $store_id, $review, $rating ), azurirajProsjek( $id_ducan )

    ostale pomocne funkcije:    postojiLiUser( $ime, $prezime ),  getAllDucaniIds()
-->

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
require_once __DIR__ . '/recenzije2.class.php';
require_once __DIR__ . '/artikl.class.php';


class SpecerajService
{
    //-------------------------------------------------------------------------------------------------------------------------
    // getAll() funkcije
    //-------------------------------------------------------------------------------------------------------------------------
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

        $ducani_ids = [];
        while( $row = $st->fetch() )
        {
            $ducan = new Ducan( $row['ID'], $row['Naziv'], $row['Prosjek'], $row['Link_na_logo'] );
            $ducani_ids[] = $ducan;
        }

        return $ducani_ids;
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

    //-------------------------------------------------------------------------------------------------------------------------
    // getById() funkcije
    //-------------------------------------------------------------------------------------------------------------------------

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

    function getPonudaById( $id_ponuda )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Ponude` WHERE `ID` = :id' );
        $st->bindParam(':id', $id_ponuda, PDO::PARAM_INT);
        $st->execute();

        if( $row = $st->fetch() ) {
            $ponuda = new Ponuda( $row['ID'], $row['ID_Proizvod'], $row['ID_Ducan'], $row['Cijena'], $row['Akcija'] );

            return $ponuda;
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

    //-------------------------------------------------------------------------------------------------------------------------
    // prepareView() funkcije
    //-------------------------------------------------------------------------------------------------------------------------

    function getKosaricaArtiklInfo( $id_ponuda, $kolicina )
    {
        $ponuda = $this->getPonudaById( $id_ponuda );
        $proizvod = $this->getProizvodById( $ponuda->ID_Proizvod );
        $ducan = $this->getDucanById( $ponuda->ID_Ducan );
        //echo "ID ponude: $proizvod->ID, Količina: $kolicina, Naziv: $proizvod->Naziv" . "<br>";

        $artikl = new Artikl( $proizvod->Link, $proizvod->Naziv, $ducan->Link, $kolicina, $ponuda->Cijena, $ponuda->Akcija, $id_ponuda);
        //print_r($artikl); echo '<br>';

        return $artikl;
    }

    function getAllArtikliInfo( $kosarica )
    {
        $artikli = [];
        foreach( $kosarica as $id_ponuda => $kolicina ) {
            // print("$id_ponuda => $kolicina");
            $artikl = $this->getKosaricaArtiklInfo( $id_ponuda, $kolicina );
            $artikli[] = $artikl;
        }

        //print_r($artikli); echo '<br>';
        return $artikli;
    }

    function getKarticaByIdProizvoda( $id_proizvod )
    {
        $ponude = $this->getPonudeByIdProizvod( $id_proizvod );
        $proizvod = $this->getProizvodById( $id_proizvod );

        $ducani_ids = [];
        foreach( $ponude as $ponuda ) {
            $ducan = $this->getDucanById( $ponuda->ID_Ducan );
            if( $ponuda->Akcija === NULL ) {
                $ducan2 = new Ducan2( $ducan->Naziv, $ducan->Link, $ponuda->Cijena, "NE", $ponuda->ID );
                $ducani_ids[] = $ducan2;
            }
            else {
                $ducan2 = new Ducan2( $ducan->Naziv, $ducan->Link, $ponuda->Akcija, "DA", $ponuda->ID );
                $ducani_ids[] = $ducan2;
            }
        }
        $kartica = new Kartica( $proizvod->ID, $proizvod->Naziv, $proizvod->Link, $proizvod->Korak, $ducani_ids );

        return $kartica;
    }

    function getAllKartice( $search = '', $sort = '' )
    {
        $db = DB::getConnection();
        $st = null;
        $query = 'SELECT `ID` FROM `projekt_Proizvodi`';

        if ($search !== '') {
            $query .= ' WHERE `Naziv` LIKE :nesto';
            $query .= ' OR `Opis` LIKE :nesto';
        }
        if ($sort !== '') {
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

    function getAllAkcije( $search = '', $sort = '', $ducani_ids = [1,2,3,4,5,6] )
    {
        $db = DB::getConnection();
        $st = null;
        $ids_str = implode(",", $ducani_ids);
        $query = "SELECT p.ID, p.ID_Proizvod, p.ID_Ducan, p.Cijena, p.Akcija
                  FROM projekt_Ponude p
                  JOIN projekt_Proizvodi pr ON p.ID_Proizvod = pr.ID
                  JOIN projekt_Ducani d ON p.ID_Ducan = d.ID
                  WHERE p.Akcija IS NOT NULL
                  AND d.ID IN ($ids_str)";

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

            # ID se odnosi na ponudu
            $akcija = new Akcija( $row['ID'], $proizvod->Naziv, $proizvod->Link, $proizvod->Korak, $ducan->Naziv, $ducan->Link, $row['Cijena'], $row['Akcija'] );

            $akcije[] = json_encode( $akcija );
        }

        return $akcije;
    }

    function getRecenzijeForView()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT k.Ime AS Ime_Kupca, k.Prezime AS Prezime_Kupca,
                                    d.ID AS ID_Ducana, d.Naziv AS Naziv_Ducana, d.Link_na_logo AS Link_na_logo_Ducana,
                                    r.Ocjena AS Ocjena_Recenzije, r.Tekst AS Tekst_Recenzije
                             FROM projekt_Recenzije r
                             JOIN projekt_Kupci k ON r.ID_User = k.ID
                             JOIN projekt_Ducani d ON r.ID_Ducan = d.ID' );

        $st->execute();

        $recenzije = [];
        while( $row = $st->fetch() ) {
            $recenzija = new Recenzija2( $row['Ime_Kupca'] . ' ' . $row['Prezime_Kupca'], $row['ID_Ducana'], $row['Naziv_Ducana'], $row['Link_na_logo_Ducana'], $row['Ocjena_Recenzije'], $row['Tekst_Recenzije'] );

            $recenzije[] = $recenzija;
        }

        return $recenzije;
    }

    //-------------------------------------------------------------------------------------------------------------------------
    // ostale pomocne funkcije
    //-------------------------------------------------------------------------------------------------------------------------

    function getAllDucaniIds()
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT `ID` FROM `projekt_Ducani`' );
        $st->execute();

        $ducani_ids = [];
        while( $row = $st->fetch() )
        {
            $ducani_ids[] = $row['ID'];
        }

        return $ducani_ids;
    }

    function postojiLiUser( $ime, $prezime )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Kupci` WHERE `Ime` = :ime AND `Prezime` = :prezime' );
        $st->bindParam(':ime', $ime, PDO::PARAM_STR);
        $st->bindParam(':prezime', $prezime, PDO::PARAM_STR);
        $st->execute();

        if( $st->rowCount() === 0 ) {
            return 0;
        }
        else {
            $row = $st->fetch();
            return $row;
        }
    }

    //-------------------------------------------------------------------------------------------------------------------------
    // funkcije za Kosaricu
    //-------------------------------------------------------------------------------------------------------------------------

    function getNajjeftinijaPonudaProizvoda( $id_proizvod )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM `projekt_Ponude`
                            WHERE `ID_Proizvod` = :id
                            AND `Cijena` = 
                                (SELECT MIN(`Cijena`)
                                FROM `projekt_Ponude`
                                WHERE `ID_Proizvod` = :id)'
                            );
        $st->bindParam(':id', $id_proizvod, PDO::PARAM_INT);
        $st->execute();

        if( $row = $st->fetch() ) {
            $ponuda = new Ponuda( $row['ID'], $row['ID_Proizvod'], $row['ID_Ducan'], $row['Cijena'], $row['Akcija'] );

            return $ponuda;
        }
    }

    function getProizvodiFromPonude($ponudeUKosarici)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT ID_Proizvod FROM projekt_Ponude WHERE ID IN (' . implode(',', $ponudeUKosarici) . ')');
        $st->execute();

        $proizvodiUKosarici = [];
        while ($row = $st->fetch()) {
            $proizvodiUKosarici[] = $row['ID_Proizvod'];
        }

        return $proizvodiUKosarici;
    }

    function izracunajPotrosnjuUDucanu($ducan_id, $proizvodiUKosarici)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT SUM(p.Cijena) AS Potrosnja,
                            p.ID AD NovaPonudaID
                            FROM projekt_Ponude p
                            WHERE p.ID_Ducan = :ducan_id
                            AND p.ID_Proizvod IN (' . implode(',', $proizvodiUKosarici) . ')');
        $st->bindParam(':ducan_id', $ducan_id, PDO::PARAM_INT);
        $st->execute();

        $novePonude = [];
        while ($row = $st->fetch()) {
            $novePonude[] = $row['NovaPonudaID'];
        }

        // NEDOVRSENO: TREBA SKUZITI KAKO IZVUCE LISTA S NOVIM PONUDA_IDevima I TO U PORETKU U KOJEM SU BILI I STARI PROIZVODI
        // I TREBA VRATITI TO I SUMU POTROSNJE

        if ($row = $st->fetch()) {
            $potrosnja = $row['Potrosnja'];
        }
    }

    //-------------------------------------------------------------------------------------------------------------------------
    // funkcije za Recenzije
    //-------------------------------------------------------------------------------------------------------------------------

    function unesiRecenziju( $user_id, $store_id, $review, $rating )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT `ID` FROM `projekt_Recenzije` WHERE `ID_Ducan` = :id_ducan AND `ID_User` = :id_user' );
        $st->bindParam( ':id_ducan', $store_id, PDO::PARAM_INT );
        $st->bindParam( ':id_user', $user_id, PDO::PARAM_INT );
        $st->execute();

        $msg = '';

        if( $row = $st->fetch() ) {
            $st = $db->prepare( 'UPDATE `projekt_Recenzije` SET `Ocjena` = :ocjena, `Tekst` = :tekst WHERE `ID` = :id' );
            $st->bindParam( ':ocjena', $rating, PDO::PARAM_INT );
            $st->bindParam( ':tekst', $review, PDO::PARAM_STR );
            $st->bindParam( ':id', $row['ID'], PDO::PARAM_INT );
            $st->execute();

            if( $this->azurirajProsjek( $store_id ) === true ) {
                $msg = 'Vaša recenzija je uspješno ažurirana!';
            }
            else {
                $msg = 'Prosjek nije ažuriran';
            }
        }
        else {
            $st = $db->prepare( 'INSERT INTO `projekt_Recenzije` (ID_Ducan, ID_User, Ocjena, Tekst) VALUES (:id_ducan, :id_user, :ocjena, :tekst)' );
            $st->execute(array('id_ducan' => $store_id, 'id_user' => $user_id, 'ocjena' => $rating, 'tekst' => $review));

            if( $this->azurirajProsjek( $store_id ) === true ) {
                $msg = 'Vaša recenzija je uspješno postavljena!';
            }
            else {
                $msg = 'Prosjek nije ažuriran';
            }
        }

        return $msg;
    }

    function azurirajProsjek( $id_ducan )
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT ROUND(AVG(`Ocjena`), 1) AS ProsjekOcjena FROM `projekt_Recenzije` WHERE ID_Ducan = :id_ducan');
        $st->bindParam(':id_ducan', $id_ducan, PDO::PARAM_INT);
        $st->execute();

        if ($row = $st->fetch()) {
            $prosjekOcjena = $row['ProsjekOcjena'];

            $stUpdate = $db->prepare('UPDATE `projekt_Ducani` SET `Prosjek` = :prosjekOcjena WHERE ID = :id_ducan');
            $stUpdate->bindParam(':prosjekOcjena', $prosjekOcjena, PDO::PARAM_STR);
            $stUpdate->bindParam(':id_ducan', $id_ducan, PDO::PARAM_INT);
            $stUpdate->execute();

            return true;
        }

        return false; // Ako nije pronađen prosjek ocjena ili je došlo do greške
    }
    //-------------------------------------------------------------------------------------------------------------------------
}

?>
