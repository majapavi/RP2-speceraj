<?php

logiranje( $msg );

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
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
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

?>
