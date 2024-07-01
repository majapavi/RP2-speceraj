<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/ponude.class.php';

class PonudeController
{
    function index2()
    {
        $ss = new SpecerajService();
        $title = 'Popis svih ponuda';
        $ponudeList = $ss->getAllPonude();
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        require_once __DIR__ . '/../view/ponude_index2.php';
    }

    function index()
    {
        $ss = new SpecerajService();
        $title = "Ponuda";

        $pretrazivanje = '';
        if( isset($_POST['pretrazivanje']) ){
            $pretrazivanje = $_POST['pretrazivanje'];
        }
        $sortiranje = '';
        if( isset($_POST['sortiranje']) ){
            $sortiranje = $_POST['sortiranje'];
        }

        $kartice = $ss->getAllKartice( $pretrazivanje, $sortiranje );
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        require_once __DIR__ . '/../view/ponude_index.php';
    }
}

?>
