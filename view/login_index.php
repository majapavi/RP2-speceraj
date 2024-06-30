<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/../controller/kupciController.class.php';
require_once __DIR__ . '/../controller/loginController.class.php';

if( isset( $_POST['btn_register_page'] ) || isset( $_POST['btn_registracija'] ) )
{
    registriraj_se();
}
else
{
    if( isset( $_POST['btn_logout'] ) )
    {
        session_unset();
        session_destroy();
        logiranje();
    }
    else
    {
        if( isset( $_POST['btn_login'] ) )
        {
            $ime = $_POST['ime'];
            $prezime = $_POST['prezime'];
            $password = $_POST['password'];

            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM projekt_Kupci WHERE Ime = :ime AND Prezime = :prezime' );
            $st->bindParam(':ime', $ime, PDO::PARAM_STR);
            $st->bindParam(':prezime', $prezime, PDO::PARAM_STR);
            $st->execute();

            if( $st->rowCount() === 0 )
            {
                $msg = 'Korisnik ' . $ime . ' ' . $prezime . ' ne postoji!';
                logiranje( $msg );
            }
            else
            {
                $row = $st->fetch();
                $password_hash = $row['Password_Hash'];

                if( password_verify( $password, $password_hash ) )
                {
                    $_SESSION['ime'] = $ime;
                    $_SESSION['prezime'] = $prezime;
                    $_SESSION['ID'] = $row['ID'];
                    otvori_aplikaciju();
                }
                else
                {
                    $msg = 'Neispravan password!';
                    logiranje( $msg );
                }
            }
        }
        else
        {
            logiranje( $poruka );
        }
    }
}


//--------------------------------------------------------------------------------------------

function logiranje( $msg = '' )
{
    require_once __DIR__ . '/_header2.php';

    ?>

    <div class="login-container">
        <h3>Ulogiraj se ili registriraj</h3>
        <br>
        <?php echo '<strong>' . $msg . '</strong>'; ?>
        <br>
        <form action="index.php?rt=login/index" method="post">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime">
            <label for="prezime">Prezime:</label>
            <input type="text" id="prezime" name="prezime">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <div class="button-container">
                <input type="submit" value="Ulogiraj se" name="btn_login">
                <input type="submit" value="Odi na registraciju" name="btn_register_page">
            </div>
        </form>
    </div>

    <?php

    require_once __DIR__ . '/_footer.php';
}

function otvori_aplikaciju()
{
    $tst = new KupciController();
    $tst->index();
}

function registriraj_se()
{
    $tst = new LoginController();
    $tst->registracija();
}

?>
