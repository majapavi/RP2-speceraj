<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/ponude.class.php';

class AkcijeController
{
    function index()
    {
        $ss = new SpecerajService();
        $title = "Akcije";

        $pretrazivanje = '';
        if( isset($_POST['pretrazivanje']) ){
            $pretrazivanje = $_POST['pretrazivanje'];
        }
        $sortiranje = '';
        if( isset($_POST['sortiranje']) ){
            $sortiranje = $_POST['sortiranje'];
        }

        $akcije = $ss->getAllAkcije( $pretrazivanje, $sortiranje );
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        require_once __DIR__ . '/../view/akcije_index.php';
    }
}

?>
