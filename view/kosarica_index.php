<?php require_once __DIR__ . '/_header.php'; ?>

<div id="kosarica"></div>

<div id="gumbi">
    <div id="ukupna_cijena"></div>
    <form action="index.php?rt=kosarica/maxGlobalnaUsteda" method="post">
        <button type="submit">Maksimalna ušteda</button>
    </form>

    <form action="index.php?rt=kosarica/ustedaUJednomDucanu" method="post">
        <button type="submit">Obavi kupnju u jednom dućanu</button>
    </form>

    <button id="isprazni">Isprazni košaricu</button>
</div>
<script>
    let kosaricaZaView = <?php echo json_encode($kosaricaZaView); ?>;
    let userID = <?php echo $_SESSION["ID"]; ?>;
    let ukupna_cijena = 0;

    if( kosaricaZaView.length == 0 ){
        $('#kosarica').append(`<p>Vaša košarica je prazna.</p>`)
    }
    else{
        kosaricaZaView.forEach( artiklZaView => {
            $('#kosarica').append( stvori_karticu_artikla(artiklZaView, userID) );
            if(artiklZaView.Akcija == null){
                ukupna_cijena += Math.round(artiklZaView.Cijena*artiklZaView.Kolicina*100)/100;
            }
            else{
                ukupna_cijena += Math.round(artiklZaView.Akcija*artiklZaView.Kolicina*100)/100;
            }
        });
    }
    $('#ukupna_cijena').html(`Ukupna cijena: ${Math.round(ukupna_cijena*100)/100} €`);

    $('#isprazni').on('click', function() {
        document.cookie ='kosarica' + userID + '=null; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        location.reload();
    });
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>

<!-- // Za svaki artikl u kosarici nadi gumb koji ce slati id ponude i id  -->
