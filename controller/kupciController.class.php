<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/kupci.class.php';

class KupciController
{
    function index()
    {
        $ss = new SpecerajService();
        $title = 'Popis svih kupaca';
        $kupciList = $ss->getAllKupci();

        require_once __DIR__ . '/../view/kupci_index.php';
    }
}

?>
