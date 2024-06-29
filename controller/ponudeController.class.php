<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/ponude.class.php';

class PonudeController
{
    function index()
    {
        $ss = new SpecerajService();
        $title = 'Popis svih ponuda';
        $ponudeList = $ss->getAllPonude();
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        require_once __DIR__ . '/../view/ponude_index.php';
    }

    function test()
    {
        $ss = new SpecerajService();
        $title = "Ponuda";
        $kartice = $ss->getAllKartice();
        $akcije = $ss->getAllAkcije( 'mli', 'Naziv ASC');
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        require_once __DIR__ . '/../view/test_index.php';
    }
}

?>
