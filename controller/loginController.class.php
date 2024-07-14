<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../controller/ponudeController.class.php';
require_once __DIR__ . '/../controller/kosaricaController.class.php';

class LoginController
{
    //----------------------------- Login ---------------------------------------------------

    function index()
    {
        if( isset( $_POST['btn_register_page'] ) || isset( $_POST['btn_registracija'] ) )
        {
            $this->registracija();
        }
        else
        {
            if( isset( $_POST['btn_logout'] ) )
            {
                session_unset();
                session_destroy();
                $this->logiranje();
            }
            else
            {
                if( isset( $_POST['btn_login'] ) )
                {
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $ss = new SpecerajService();
                    $user = $ss->postojiLiUser( $username );

                    if( $user === 0 )
                    {
                        $msg = 'Korisnik ' . $username . ' ne postoji!';
                        $this->logiranje( $msg );
                    }
                    else
                    {
                        $password_hash = $user['Password_Hash'];

                        if( password_verify( $password, $password_hash ) )
                        {
                            $_SESSION['username'] = $username;
                            $_SESSION['ID'] = $user['ID'];

                            # Kreiranje nove košarice za novog usera
                            if( !isset( $_COOKIE['kosarica'][$_SESSION["ID"]] ) )
                                $_COOKIE['kosarica'][$_SESSION["ID"]] = array();

                            $this->otvori_aplikaciju();
                        }
                        else
                        {
                            $msg = 'Neispravan password!';
                            $this->logiranje( $msg );
                        }
                    }
                }
                else
                {
                    $this->logiranje();
                }
            }
        }
    }

    function logiranje( $msg = '' )
    {
        require_once __DIR__ . '/../view/login_index.php';
    }

    function otvori_aplikaciju()
    {
        $tst = new PonudeController();
        $tst->index();
    }

    //---------------- Registracija ---------------------------------------------------

    function registracija()
    {
        require_once __DIR__ . '/../view/registration_index.php';
    }

    function registrirajSe()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $potvrdi_password = $_POST['potvrdi_password'];

        if( $password !== $potvrdi_password )
        {
            $msg = 'Password i potvrda passworda nisu bili isti, molim Vas pokušajte ponovo!';
            registracija( $msg );
        }
        else if( empty($username) || empty($password)) {
            $msg = 'Niti jedno polje ne smije ostati prazno!';
            registracija( $msg );
        }
        else
        {
            $ss = new SpecerajService();
            $korisnici = $ss->getAllKupci();

            $postoji = false;
            foreach($korisnici as $korisnik )
            {
                if( $username === $korisnik->Username )
                {
                    $postoji = true;
                    break;
                }
            }

            if( $postoji )
            {
                $msg = 'Korisnik s usernameom ' . $username . ' već postoji!<br>Vratite se na stranicu za ulogiravanje.';
                registracija( $msg );
            }
            else
            {
                $msg = $ss->registrirajKorisnika( $username, $password );
                registracija( $msg );
            }
        }
    }
}
?>
