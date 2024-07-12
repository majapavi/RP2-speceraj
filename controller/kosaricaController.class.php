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

    function stvoriNovuKosaricu()
    {
        $_COOKIE['kosarica'][$_SESSION["ID"]] = array();
    }

    function maxGlobalnaUsteda()
    {
        // zove getNajjeftinijaPonudaProizvoda iz specerajservice
        $ss = new SpecerajService();
        print_r($_COOKIE['kosarica'][$_SESSION["ID"]]);
        foreach ($_COOKIE['kosarica'][$_SESSION["ID"]] as $ponudaId => $kolicina)
        {
            $ponuda = $ss->getPonudaById($ponudaId);

            $proizvod_id = $ponuda->ID_Proizvod;
            $najjeftinijaPonuda = $ss->getNajjeftinijaPonudaProizvoda($proizvod_id);

            if ($najjeftinijaPonuda != $ponuda)
            {
                unset($_COOKIE['kosarica'][$_SESSION["ID"]][$ponudaId]);
                $_COOKIE['kosarica'][$_SESSION["ID"]][$najjeftinijaPonuda->ID] = $kolicina;
            }
        }

        $kosaricaZaView = $ss->getAllArtikliInfo($_COOKIE['kosarica'][$_SESSION["ID"]]);
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