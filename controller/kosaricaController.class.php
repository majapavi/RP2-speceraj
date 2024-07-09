<?php
require_once __DIR__ . '/../model/specerajservice.class.php';

class KosaricaController
{
    function index()
    {
        $kosarica = isset($_COOKIE['kosarica'][1]) ? $_COOKIE['kosarica'][1] : array();
        //$kosarica = array(6 => 2, 9 => 3, 3 => 1);

        $specerajService = new SpecerajService();
        $kosaricaZaView = $specerajService->getAllArtikliInfo($kosarica);
        foreach ($kosaricaZaView as $proizvod) {
            echo $proizvod->id . '<br>';
        }

        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function stvoriNovuKosaricu($ID_kupca)
    {
        $_COOKIE['kosarica'][$_SESSION["ID"]] = array();

        require_once __DIR__ . '/../view/kosarica_index.php';
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

    function najjeftinijaPonuda()
    {
        $ss = new SpecerajService();
        $ponuda_id = $_POST['ponuda_id'];

        $msg = $ss->obrisiProizvodIzKosarice( $ponuda_id );
        $proizvodiList = $ss->getProizvodiFromKosarica();

        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function naruci()
    {
        $ss = new SpecerajService();
        $msg = $ss->naruciProizvode();
        $proizvodiList = $ss->getProizvodiFromKosarica();

        require_once __DIR__ . '/../view/kosarica_index.php';
    }
}

?>