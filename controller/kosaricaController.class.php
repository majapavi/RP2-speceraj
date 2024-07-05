<?php
require_once __DIR__ . '/../model/specerajservice.class.php';

class KosaricaController
{
    function index()
    {
        $kosarica = isset($_COOKIE['kosarica'][1]) ? $_COOKIE['kosarica'][1] : array();

        $kosaricaZaView = array();
        foreach ($kosarica as $ponuda_id => $kolicina) {
            $artikl = SpecerajService::getKosaricaArtiklInfo($ponuda_id, $kolicina);
            $kosaricaZaView[] = $artikl;
        }

        // Print for debugging
        echo "<pre>";
        print_r($kosaricaZaView);
        echo "</pre>";

        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function stvoriNovuKosaricu($ID_kupca)
    {
        $_COOKIE['kosarica'][$_SESSION["ID"]] = array();

        require_once __DIR__ . '/../view/kosarica_index.php';
    }

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

    

    /*
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
    */
}

?>