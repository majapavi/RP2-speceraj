<?php
require_once __DIR__ . '/../model/specerajservice.class.php';

class KosaricaController
{
    function index()
    {
        $kosarica = isset($_COOKIE['kosarica'][$_SESSION["ID"]]) ? $_COOKIE['kosarica'][$_SESSION["ID"]] : array();
        $kosarica = array(6 => 2, 9 => 3, 3 => 1);
        //print_r($kosarica); echo '<br>';

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

/*  ne koristi se, implementirano u javascriptu

    function dodajArtikl($ponudaId, $kolicina)
    {
        $_COOKIE['kosarica'][$_SESSION["ID"]][$ponudaId] = $kolicina;
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function obrisiArtikl($ponuda_id)
    {
        unset($_COOKIE['kosarica'][$_SESSION["ID"]][$ponudaId]);
        require_once __DIR__ . '/../view/kosarica_index.php';
    }
*/    

    function maxGlobalnaUsteda()
    {
        $ss = new SpecerajService();
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

    function najjeftinijaPonuda()
    {
        $ss = new SpecerajService();
        $ponuda_id = $_POST['ponuda_id'];

        $msg = $ss->obrisiProizvodIzKosarice( $ponuda_id );
        $proizvodiList = $ss->getProizvodiFromKosarica();

        require_once __DIR__ . '/../view/kosarica_index.php';
    }
};

?>