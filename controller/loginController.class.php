<?php

require_once __DIR__ . '/../model/specerajservice.class.php';
require_once __DIR__ . '/../controller/kosaricaController.class.php';

class LoginController
{
    function index( $poruka = '' )
    {
        require_once __DIR__ . '/../view/login_index.php';
    }

    function registracija()
    {
        require_once __DIR__ . '/../view/registration_index.php';
    }

    function registrirajSe()
    {
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $password = $_POST['password'];
        $potvrdi_password = $_POST['potvrdi_password'];
    
        if( $password !== $potvrdi_password )
        {
            $msg = 'Password i potvrda passworda nisu bili isti, molim Vas pokušajte ponovo!';
            registracija( $msg );
        }
        else
        {
            $ss = new SpecerajService();
            $korisnici = $ss->getAllKupci();
    
            $postoji = false;
            foreach($korisnici as $korisnik )
            {
                if( $ime === $korisnik->Ime && $prezime === $korisnik->Prezime )
                {
                    $postoji = true;
                    break;
                }
            }
    
            if( $postoji )
            {
                $msg = 'Korisnik s imenom ' . $ime . ' ' . $prezime . ' već postoji!<br>Vratite se na stranicu za ulogiravanje.';
                registracija( $msg );
            }
            else
            {
                $db = DB::getConnection();
                $st = $db->prepare('INSERT INTO projekt_Kupci (Ime, Prezime, Password_Hash) VALUES (:ime, :prez, :pass)');
                $st->execute(array('ime' => $ime, 'prez' => $prezime, 'pass' => password_hash($password, PASSWORD_DEFAULT)));
                $ID_novogKupca = $db->lastInsertId();

                # Kreiranje nove košarice za novog usera
                $kc = new KosaricaController();
                $kc.stvoriNovuKosaricu($ID_novogKupca);
    
                $msg = 'Korisnički račun uspješno kreiran!<br>Molimo Vas ulogirajte se kako biste mogli koristiti aplikaciju.';
                registracija( $msg );
            }
        }
    }
}
?>
