<?php require_once __DIR__ . '/_header.php'; ?>

<?php

if( count($kosarica) == 0 ){
    ?>
    $('#kosarica').append(`<p>Vaša košarica je prazna.</p>`)
    <?php
}
else{
    foreach( $kosarica as $artikl ) {
        ?>
        $('#kosarica').append( stvori_karticu_artikla($artikl) );
        <?php
    }
}
?>

<?php require_once __DIR__ . '/_footer.php'; ?>
