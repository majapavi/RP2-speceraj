<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/ponude.class.php';

class PonudeController
{
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

        require_once __DIR__ . '/../view/ponude_index.php';
    }
}

?>
