<?php

require_once __DIR__ . '/../controller/loginController.class.php';

$tst = new LoginController();
if( isset( $_POST['btn_registracija'] ) )
{
    $tst->registrirajSe();
}
elseif ( isset( $_POST['btn_login_page'] ) ) {
    $tst->index();
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
        <br>
        <form action="index.php?rt=login/registracija" method="post">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime">
            <label for="prezime">Prezime:</label>
            <input type="text" id="prezime" name="prezime">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <label for="potvrdi_password">Potvrdi password:</label>
            <input type="password" id="potvrdi_password" name="potvrdi_password">
            <div class="button-container">
                <input type="submit" value="Registriraj se!" name="btn_registracija">
                <input type="submit" value="Povratak na login" name="btn_login_page">
            </div>
        </form>
    </div>

    <?php

    require_once __DIR__ . '/_footer.php';
}
?>
