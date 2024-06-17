<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/proizvodi.class.php';

class ProizvodiController
{
    function index()
    {
        $ss = new SpecerajService();
        $title = 'Popis svih proizvoda';
        $proizvodiList = $ss->getAllProizvodi();

        require_once __DIR__ . '/../view/proizvodi_index.php';
    }
}

?>
