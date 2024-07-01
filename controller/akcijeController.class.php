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
        $izbor_ducana = [1,2,3,4,5,6];
        if( isset($_POST['ducani']) ){
            $izbor_ducana = $_POST['ducani'];
        }

        $akcije = $ss->getAllAkcije( $pretrazivanje, $sortiranje, $izbor_ducana );
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        $ducani = $ss->getAllDucani();

        require_once __DIR__ . '/../view/akcije_index.php';
    }
}

?>
