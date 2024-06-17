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

        require_once __DIR__ . '/../view/ponude_index.php';
    }
}

?>
