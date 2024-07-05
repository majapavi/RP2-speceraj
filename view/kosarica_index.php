<?php require_once __DIR__ . '/_header.php'; ?>

<div id="kosarica"></div>

<script>
<?php
if( count($kosaricaZaView) == 0 ){
    ?>
    $('#kosarica').append(`<p>Vaša košarica je prazna.</p>`)
    <?php
    print("console.log('Vaša košarica je prazna.')");
}
else{
    foreach( $kosaricaZaView as $artiklZaView ) {
        ?>
        console.log(stvori_karticu_artikla($artiklZaView));
        $('#kosarica').append( stvori_karticu_artikla($artiklZaView) );
        <?php
    }
    print("console.log('Košarica je popunjena.')");
}
?>
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>