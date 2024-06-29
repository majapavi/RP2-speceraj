<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/../controller/loginController.class.php';

if( isset( $_POST['btn_registracija'] ) )
{
    registrirajSe();
}
elseif ( isset( $_POST['btn_login_page'] ) ) {
    odiNaLogin();
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

    <div class="registration-container">
        <h3>Registriraj se</h3>
        <br>
        <?php echo '<strong>' . $msg . '</strong>'; ?>
        <br><br>
        <form action="index.php?rt=login/registracija" method="post">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime">
            <br>
            <label for="prezime">Prezime:</label>
            <input type="text" id="prezime" name="prezime">
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <br>
            <label for="potvrdi_password">Potvrdi password:</label>
            <input type="password" id="potvrdi_password" name="potvrdi_password">
            <br>
            <div class="button-container">
                <input type="submit" value="Registriraj se!" name="btn_registracija">
                <input type="submit" value="Povratak na login" name="btn_login_page">
            </div>
        </form>
    </div>

    <?php

    require_once __DIR__ . '/_footer.php';
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

            $msg = 'Korisnički račun uspješno kreiran!<br>Molimo Vas ulogirajte se kako biste mogli koristiti aplikaciju.';
            registracija( $msg );
        }
    }
}

function odiNaLogin()
{
    $tst = new LoginController();
    $tst->index();
}

?>
