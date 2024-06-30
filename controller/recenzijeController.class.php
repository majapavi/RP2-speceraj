<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../model/recenzije.class.php';

class RecenzijeController
{
    function index()
    {
        $ss = new SpecerajService();

        $msg = '';

        $title = 'Popis svih recenzija';
        $recenzijeList = $ss->getAllRecenzije();
        $ducani = $ss->getAllDucani();
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        require_once __DIR__ . '/../view/recenzije_index.php';
    }

    function posalji()
    {
        $ss = new SpecerajService();

        $user_id = $_SESSION['ID'];
        $store_id = $_POST['store'];
        $review = $_POST['review'];
        $rating = $_POST['rating'];

        if( (int)$rating === 0 ) {
            $msg = 'Niste odabrali ocjenu, molim Vas odaberite ocjenu koju želite za odabrani dućan.';
        }
        else {
            $msg = $ss->unesiRecenziju( $user_id, $store_id, $review, $rating );
        }

        $title = 'Popis recenzija';
        $recenzijeList = $ss->getAllRecenzije();
        $ducani = $ss->getAllDucani();
        $loginUser = $_SESSION['ime'] . ' ' . $_SESSION['prezime'];

        require_once __DIR__ . '/../view/recenzije_index.php';
    }
}

?>
