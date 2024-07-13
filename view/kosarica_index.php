<?php require_once __DIR__ . '/_header.php'; ?>

<div id="kosarica"></div>

<form action="index.php?rt=kosarica/maxGlobalnaUsteda" method="post">
    <button type="submit">Maksimalna ušteda</button>
</form>

<button id="isprazni">Isprazni košaricu</button>

<script>
    
        let kosaricaZaView = <?php echo json_encode($kosaricaZaView); ?>;
        let userID = <?php echo $_SESSION["ID"]; ?>;
        
        if( kosaricaZaView.length == 0 ){
            $('#kosarica').append(`<p>Vaša košarica je prazna.</p>`)
        }
        else{
            kosaricaZaView.forEach( artiklZaView => {
                $('#kosarica').append( stvori_karticu_artikla(artiklZaView, userID) );
            });
        }

        $('#isprazni').on('click', function() {
            document.cookie ='kosarica' + userID + '=null; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            location.reload();
        });
    
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>

<!-- // Za svaki artikl u kosarici nadi gumb koji ce slati id ponude i id  -->