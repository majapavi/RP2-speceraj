<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/ducani.class.php';

class DucaniController
{
    function index()
    {
        $ss = new SpecerajService();
        $title = 'Popis svih dućana';
        $ducaniList = $ss->getAllDucani();

        require_once __DIR__ . '/../view/ducani_index.php';
    }
}

?>
