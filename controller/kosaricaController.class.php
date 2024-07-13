<?php
require_once __DIR__ . '/../model/specerajservice.class.php';

class KosaricaController
{
    function index()
    {
        if (isset($_SESSION["ID"])) {
            // $_COOKIE['kosarica' . $_SESSION["ID"]] = array(6 => 2, 9 => 3, 3 => 1);
            $kosarica = isset($_COOKIE['kosarica' . $_SESSION["ID"]]) ? json_decode($_COOKIE['kosarica' . $_SESSION["ID"]]) : array();
        } else {
            throw new Exception("User session not set.");
        }
        //$kosarica = array(6 => 2, 9 => 3, 3 => 1);
        // print_r($_COOKIE['kosarica' . $_SESSION["ID"]]); echo '<hr>';
        print("Kosarica za userID = $_SESSION[ID]:  "); print_r($kosarica); echo '<br>';

        $specerajService = new SpecerajService();
        $kosaricaZaView = $specerajService->getAllArtikliInfo($kosarica);
        //print_r($kosaricaZaView); echo '<br>';

        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function stvoriNovuKosaricu()
    {
        $_COOKIE['kosarica'][$_SESSION["ID"]] = array();
    }

    function maxGlobalnaUsteda()
    {
        // zove getNajjeftinijaPonudaProizvoda iz specerajservice
        $ss = new SpecerajService();
        $poz = "kosarica" . $_SESSION["ID"];

        // Provjera postojanja cookiea
        if (isset($_COOKIE[$poz])) {
            $kosarica = json_decode($_COOKIE[$poz], true);

            foreach ($kosarica as $ponudaId => $kolicina) {
                $ponuda = $ss->getPonudaById($ponudaId);

                $proizvod_id = $ponuda->ID_Proizvod;
                $najjeftinijaPonuda = $ss->getNajjeftinijaPonudaProizvoda($proizvod_id);

                if ($najjeftinijaPonuda->ID != $ponuda->ID) {
                    // Ažuriraj košaricu
                    unset($kosarica[$ponudaId]);
                    $kosarica[$najjeftinijaPonuda->ID] = $kolicina;
                }
            }
            //
            // // Pretvaranje košarice u JSON za pohranu u cookie
            // $kosaricaJson = json_encode($kosarica);
            //
            // // Postavljanje cookiea s ažuriranom košaricom
            // setcookie($poz, $kosaricaJson, time() + (86400 * 7), "/"); // Cookie traje 7 dana

            $jsonValue = json_encode($kosarica);

            // Construct the Set-Cookie header
            $cookieName = 'kosarica' . $_SESSION['ID'];
            $cookieValue = $jsonValue;
            $cookieExpire = time() + (86400 * 7);  // Cookie lasts for 7 days
            $cookiePath = '/';
            $setCookieHeader = sprintf(
                'Set-Cookie: %s=%s; expires=%s; path=%s',
                $cookieName,
                $cookieValue,
                gmdate('D, d-M-Y H:i:s T', $cookieExpire),
                $cookiePath
            );

            // Send the header
            header($setCookieHeader);
        }
<<<<<<< HEAD

=======
        else{
            // ovo samo ako je kosarica prazna (isset($_COOKIE[$poz]) == false)
            $kosarica = [];
        }
    
>>>>>>> 739840fc75fab949584aaf85e169c3b383c3dfcc
        // Dohvaćanje artikala za prikaz
        $kosaricaZaView = $ss->getAllArtikliInfo($kosarica);
        $title = 'Moja košarica (nakon optimizacije 1)';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function ustedaUJednomDucanu()
    {
        $ss = new SpecerajService();
        $ducani_ids = $ss->getAllDucaniIds();
        $this->debug();
        $ponudeUKosarici = json_decode($_COOKIE[ 'kosarica' . $_SESSION['ID'] ]);
        print_r( $ponudeUKosarici );
        print(count($ponudeUKosarici));

        $polje = [];
        foreach( $ducani_ids as $ducan_id ){
            $polje[] = $ss->izracunajPotrosnjuUDucanu($ducan_id, $ponudeUKosarici);
        }
        // echo '<pre>';
        // echo '$polje = '; print_r( $polje );
        // echo '</pre>';
        $pamti = NULL;
        foreach ($polje as $ducan) {
            if($pamti == NULL) $pamti = $ducan;
            else if( $pamti['Potrosnja'] > $ducan['Potrosnja'] && $ducan['Potrosnja'] !== -1 ) $pamti = $ducan;
        }
        echo '<pre>';
        echo '$pamti[\'NovePonude\'] = '; print_r( $pamti['NovePonude'] );
        echo '</pre>';

        $jsonValue = json_encode($pamti['NovePonude']);

        // Construct the Set-Cookie header
        $cookieName = 'kosarica' . $_SESSION['ID'];
        $cookieValue = $jsonValue;
        $cookieExpire = time() + (86400 * 7);  // Cookie lasts for 7 days
        $cookiePath = '/';
        $setCookieHeader = sprintf(
            'Set-Cookie: %s=%s; expires=%s; path=%s',
            $cookieName,
            $cookieValue,
            gmdate('D, d-M-Y H:i:s T', $cookieExpire),
            $cookiePath
        );

        // Send the header
        header($setCookieHeader);

        // Dohvaćanje artikala za prikaz
        $kosaricaZaView = $ss->getAllArtikliInfo($pamti['NovePonude']);
        $title = 'Moja košarica (nakon optimizacije 2)';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function enkodiraj($novePonude)
    {
        $returnString = "{";
        $prvi = true;
        foreach ($novePonude as $key => $value) {
            if( !$prvi ) {
                $returnString .= ",";
            }
            $returnString .= "\"" . $key . "\":" . $value;
            if( $prvi ) $prvi = false;
        }
        $returnString .= "}";

        return $returnString;
    }

    function debug() {
        echo '<pre>';
        echo '$_COOKIE = '; print_r( $_COOKIE );
        echo '$_POST = '; print_r( $_POST );
        echo '$_SESSION = '; print_r( $_SESSION );
        // echo '$_SERVER = '; print_r( $_SERVER );
        echo '</pre>';
    }
};

?>
