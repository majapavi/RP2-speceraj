<?php

require_once __DIR__ . '/../model/specerajservice.class.php';

class LoginController
{
    function index( $poruka = '' )
    {
        require_once __DIR__ . '/../view/login_index.php';
    }

    function registriracija()
    {
        require_once __DIR__ . '/../view/registration_index.php';
    }
}

?>
