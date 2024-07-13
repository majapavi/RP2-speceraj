<?php
require_once __DIR__ . '/../model/specerajservice.class.php';

class KosaricaController
{
    function index()
    {
        if (isset($_SESSION["ID"])) {
            // $_COOKIE['kosarica' . $_SESSION["ID"]] = array(6 => 2, 9 => 3, 3 => 1);
            $kosarica = isset($_COOKIE['kosarica' . $_SESSION["ID"]]) ? json_decode($_COOKIE['kosarica' . $_SESSION["ID"]]) : array();
        } else {
            throw new Exception("User session not set.");
        }
        //$kosarica = array(6 => 2, 9 => 3, 3 => 1);
        // print_r($_COOKIE['kosarica' . $_SESSION["ID"]]); echo '<hr>';
        print("Kosarica za userID = $_SESSION[ID]:  "); print_r($kosarica); echo '<br>';

        $specerajService = new SpecerajService();
        $kosaricaZaView = $specerajService->getAllArtikliInfo($kosarica);
        //print_r($kosaricaZaView); echo '<br>';

        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function maxGlobalnaUsteda()
    {
        // zove getNajjeftinijaPonudaProizvoda iz specerajservice
        $ss = new SpecerajService();
        $poz = "kosarica" . $_SESSION["ID"];
        
        // Provjera postojanja cookiea
        if (isset($_COOKIE[$poz])) {
            $kosarica = json_decode($_COOKIE[$poz], true);
    
            foreach ($kosarica as $ponudaId => $kolicina) {
                $ponuda = $ss->getPonudaById($ponudaId);
    
                $proizvod_id = $ponuda->ID_Proizvod;
                $najjeftinijaPonuda = $ss->getNajjeftinijaPonudaProizvoda($proizvod_id);
    
                if ($najjeftinijaPonuda->ID != $ponuda->ID) {
                    // Ažuriraj košaricu
                    unset($kosarica[$ponudaId]);
                    $kosarica[$najjeftinijaPonuda->ID] = $kolicina;
                }
            }
    
            // Pretvaranje košarice u JSON za pohranu u cookie
            $kosaricaJson = json_encode($kosarica);
    
            // Postavljanje cookiea s ažuriranom košaricom
            setcookie($poz, $kosaricaJson, time() + (86400 * 7), "/"); // Cookie traje 7 dana
        }
        else{
            // ovo samo ako je kosarica prazna (isset($_COOKIE[$poz]) == false)
            $kosarica = [];
        }
    
        // Dohvaćanje artikala za prikaz
        $kosaricaZaView = $ss->getAllArtikliInfo($kosarica);
        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }
    
    function ustedaUJednomDucanu()
    {
        $ss = new SpecerajService();
        $ducani_ids = $ss->getAllDucaniIds();
        $ponudeUKosarici = array_keys($_COOKIE['kosarica'][$_SESSION["ID"]]);
        $proizvodiUKosarici = $ss->getProizvodiFromPonude($ponudeUKosarici);

        // Jos treba dodati da se zapamti najjeftinije potrosnja po ducanu i da se nove ponude spreme u cookie
        foreach( $ducani_ids as $ducan_id ){
            $ss->izracunajPotrosnjuUDucanu($ducan_id, $proizvodiUKosarici);
        }

        $kosaricaZaView = $ss->getAllArtikliInfo($_COOKIE['kosarica'][$_SESSION["ID"]]);
        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

};

?>