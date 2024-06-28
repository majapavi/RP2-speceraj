<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/../controller/kupciController.class.php';
require_once __DIR__ . '/../controller/loginController.class.php';

if( isset( $_POST['btn_register'] ) )
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
            $st = $db->prepare( 'SELECT * FROM `projekt_Kupci` WHERE `Ime` = :ime AND `Prezime` = :prezime' );
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

    <h3>Ulogiraj se ili registriraj</h3>
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
        <input type="submit" value="Ulogiraj se" name="btn_login">
        <input type="submit" value="Registriraj se" name="btn_register">
    </form>

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
