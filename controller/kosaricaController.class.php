<?php
require_once __DIR__ . '/../model/specerajservice.class.php';

class KosaricaController
{
    function index()
    {
        $kosarica = isset($_COOKIE['kosarica'][1]) ? $_COOKIE['kosarica'][1] : array();
        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function stvoriNovuKosaricu($ID_kupca)
    {
        $_COOKIE['kosarica'] = array();
        $_COOKIE['kosarica'][0] = $ID_kupca;
        $_COOKIE['kosarica'][1] = array();

        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function dodajArtikl($ponuda)
    {
        $_COOKIE['kosarica'][1].push($ponuda);

        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function obrisiArtikl($ponuda_id)
    {
        $_COOKIE['kosarica'][1] = array_filter($_COOKIE['kosarica'][1], function($ponuda) use ($ponuda_id) {
            return $ponuda->ID !== $ponuda_id;
        });

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