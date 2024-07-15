<?php
require_once __DIR__ . '/../model/specerajservice.class.php';

class KosaricaController
{
    function index()
    {
        if (isset($_SESSION["ID"])) {
            $kosarica = isset($_COOKIE['kosarica' . $_SESSION["ID"]]) ? json_decode($_COOKIE['kosarica' . $_SESSION["ID"]]) : array();
        } else {
            throw new Exception("User session not set.");
        }

        $specerajService = new SpecerajService();
        $kosaricaZaView = $specerajService->getAllArtikliInfo($kosarica);

        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function sparajNaJednomArtiklu()
   {
        $ponudaId = $_POST['id_ponuda'];

        $ss = new SpecerajService();
        $proizvod_id = $ss->getPonudaById($ponudaId)->ID_Proizvod;
        $najjeftinijaPonudaId = $ss->getNajjeftinijaPonudaProizvoda($proizvod_id)->ID;
        //echo $ponudaId . " " . $najjeftinijaPonudaId;

        if (isset($_COOKIE["kosarica" . $_SESSION["ID"]]) && $ponudaId!= $najjeftinijaPonudaId) {
            $kosarica = json_decode($_COOKIE["kosarica" . $_SESSION["ID"]], true);
            if( isset($kosarica[$ponudaId]) ){
                if( isset($kosarica[$najjeftinijaPonudaId]) ){
                    $kosarica[$najjeftinijaPonudaId] += $kosarica[$ponudaId];
                }
                else{
                    $kosarica[$najjeftinijaPonudaId] = $kosarica[$ponudaId];
                }
                unset($kosarica[$ponudaId]);

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
                header($setCookieHeader);
                }

        }
        else{
            $kosarica = [];
        }

        // Dohvaćanje artikala za prikaz
        $kosaricaZaView = $ss->getAllArtikliInfo($kosarica);
        $title = 'Moja košarica (nakon optimizacije 1)';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function maxGlobalnaUsteda()
    {
        // zove getNajjeftinijaPonudaProizvoda iz specerajservice
        $ss = new SpecerajService();
        $poz = "kosarica" . $_SESSION["ID"];

        // Provjera postojanja cookiea
        if (isset($_COOKIE[$poz])) {
            $kosarica = json_decode($_COOKIE[$poz], true);
            if(count($kosarica) > 0){

                foreach ($kosarica as $ponudaId => $kolicina) {
                    $ponuda = $ss->getPonudaById($ponudaId);

                    $proizvod_id = $ponuda->ID_Proizvod;
                    $najjeftinijaPonuda = $ss->getNajjeftinijaPonudaProizvoda($proizvod_id);

                    if ($najjeftinijaPonuda->ID != $ponuda->ID) {
                        // Ažuriraj košaricu
                        unset($kosarica[$ponudaId]);
                        if( isset($kosarica[$najjeftinijaPonuda->ID]) ) $kosarica[$najjeftinijaPonuda->ID] += $kolicina;
                        else                                            $kosarica[$najjeftinijaPonuda->ID]  = $kolicina;
                    }
                }
                ksort($kosarica);
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
        }
        else{
            // ovo samo ako je kosarica prazna (isset($_COOKIE[$poz]) == false)
            $kosarica = [];
        }

        // Dohvaćanje artikala za prikaz
        $kosaricaZaView = $ss->getAllArtikliInfo($kosarica);
        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function ustedaUJednomDucanu()
    {
        $ss = new SpecerajService();
        $ducani_ids = $ss->getAllDucaniIds();
        // $this->debug();
        $kosarica = NULL;
        if(isset($_COOKIE[ 'kosarica' . $_SESSION['ID'] ])) {
            $ponudeUKosarici = json_decode($_COOKIE[ 'kosarica' . $_SESSION['ID'] ]);


            $polje = [];
            foreach( $ducani_ids as $ducan_id ){
                $polje[] = $ss->izracunajPotrosnjuUDucanu($ducan_id, $ponudeUKosarici);
            }

            $pamti = NULL;
            foreach ($polje as $ducan) {
                if($pamti == NULL) $pamti = $ducan;
                else if( ($pamti['Potrosnja'] > $ducan['Potrosnja'] || $pamti['Potrosnja'] === -1) && $ducan['Potrosnja'] !== -1 ) $pamti = $ducan;
            }

            if( $pamti['Potrosnja'] !== -1 ) {
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
            }

            $kosarica = $pamti['NovePonude'];
        }
        else {
            $kosarica = [];
        }
        // Dohvaćanje artikala za prikaz
        $kosaricaZaView = $ss->getAllArtikliInfo($kosarica);
        $title = 'Moja košarica';
        require_once __DIR__ . '/../view/kosarica_index.php';
    }

    function ispisiPopisZaKupnju()
    {
        if (isset($_COOKIE['kosarica' . $_SESSION["ID"]])) {
    
            $kosarica = json_decode($_COOKIE['kosarica' . $_SESSION["ID"]], true);
    
            $ss = new SpecerajService();
            $popisZaIspis = $ss->getAllStavke($kosarica);

            // Create and write to the file
            $filePath = __DIR__ . '/../popis/Popis.txt';
            if (!file_exists($filePath)) {
                touch($filePath); // Create the file if it doesn't exist
                echo "File created: " . $filePath . "<br>";
            }
            file_put_contents($filePath, $popisZaIspis);
                
            ob_clean();
    
            // Generate download headers and serve the file
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="Popis.txt"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit; // Ensure no further code is executed
        }
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
