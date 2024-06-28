<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/../controller/loginController.class.php';

if( isset( $_POST['btn_registracija'] ) )
{
    registrirajSe();
}
else
{
    registracija();
}


//--------------------------------------------------------------------------------------------

function registracija( $msg = '' )
{
    require_once __DIR__ . '/_header2.php';

    ?>

    <h3>Registriraj se</h3>
    <br>
    <?php echo '<strong>' . $msg . '</strong>'; ?>
    <br>
    <br><br>
    <form action="index.php" method="post">
        Ime:
        <input type="text" name="ime">
        <br>
        Prezime:
        <input type="text" name="prezime">
        <br>
        Password:
        <input type="password" name="password">
        <br>
        Potvrdi password:
        <input type="password" name="potvrdi_password">
        <br>
        <input type="submit" value="Registriraj se" name="btn_registracija">
    </form>

    <?php

    require_once __DIR__ . '/_footer.php';
}

function ulogiraj_se()
{
    $tst = new LoginController();
    $tst->index( 'Korisnički račun uspješno kreiran! Molimo Vas ulogirajte se kako biste mogli koristiti aplikaciju.' );
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

            ulogiraj_se();
        }
    }
}

?>
