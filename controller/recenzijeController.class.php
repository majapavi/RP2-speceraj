<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/recenzije.class.php';

class RecenzijeController
{
    function index()
    {
        $ss = new SpecerajService();
        $title = 'Popis svih recenzija';
        $recenzijeList = $ss->getAllRecenzije();

        require_once __DIR__ . '/../view/recenzije_index.php';
    }
}

?>
