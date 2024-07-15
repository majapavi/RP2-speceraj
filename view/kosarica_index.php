<?php require_once __DIR__ . '/_header.php'; ?>

<div id="gumbi">
    <div id="ukupna_cijena"></div>
    <form id="max_usteda" action="index.php?rt=kosarica/maxGlobalnaUsteda" method="post">
        <button type="submit">Maksimalna ušteda</button>
    </form>

    <form id="jeftini_ducan" action="index.php?rt=kosarica/ustedaUJednomDucanu" method="post">
        <button type="submit">Obavi kupnju u jednom dućanu</button>
    </form>

    <button id="isprazni">Isprazni košaricu</button>

    
    <form action="index.php?rt=kosarica/ispisiPopisZaKupnju" method="post">
        <button type="submit">Popis za kupnju</button>
    </form>
    
</div>

<div id="kosarica"></div>

<script>
    let kosaricaZaView = <?php echo json_encode($kosaricaZaView); ?>;
    let userID = <?php echo $_SESSION["ID"]; ?>;
    let ukupna_cijena = 0;

    if( kosaricaZaView.length == 0 ){
        $('#kosarica').append(`<p style="margin-left:20px">Vaša košarica je prazna.</p>`);
        $('#gumbi').hide();
    }
    else{
        // Punimo kosaricu artiklima (u css-u im je height i opacity 0)
        kosaricaZaView.forEach( artiklZaView => {
            $('#kosarica').append( stvori_karticu_artikla(artiklZaView, userID) );
            // Paralelno racunamo cijenu
            if(artiklZaView.Akcija == null){
                ukupna_cijena += Math.round(artiklZaView.Cijena*artiklZaView.Kolicina*100)/100;
            }
            else{
                ukupna_cijena += Math.round(artiklZaView.Akcija*artiklZaView.Kolicina*100)/100;
            }
        });

        // Kartice se polako pojavljuju jedna po jedna
        $('.kartica_artikla').each(function(index){
            setTimeout(() => {
                $(this).addClass('fade-in');
            }, 100*(index+1));
        });
    }
    // Zapisujemo cijenu
    $('#ukupna_cijena').html(`Ukupna cijena: `).append(`<label id="broj">${Math.round(ukupna_cijena*100)/100}</label> €`);

    // Praznjenje kosarice
    $('#isprazni').on('click', function() {
        // Kartice polako nestaju
        var sve_kartice = $('.kartica_artikla');
        for (var i = sve_kartice.length - 1; i >= 0; i--) {
            (function(index) {
                setTimeout(function() {
                    $(sve_kartice[index]).removeClass('fade-in');
                }, (sve_kartice.length - 1 - index) * 100);
            })(i);
        }
        // Micemo gumbe
        $('#gumbi').addClass('fade-out');
        const poruka = $(`<p style="margin-left:20px">Vaša košarica je prazna.</p>`);
        poruka.hide();
        $('#kosarica').append(poruka);
        poruka.fadeIn(500);
        document.cookie ='kosarica' + userID + '=null; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        // location.reload();
    });

    // Gumb max usteda:
    $('#max_usteda').on('submit', function(event){
        event.preventDefault();
        // Kartice polako nestaju
        var sve_kartice = $('.kartica_artikla');
        for (var i = sve_kartice.length - 1; i >= 0; i--) {
            (function(index) {
                setTimeout(function() {
                    $(sve_kartice[index]).removeClass('fade-in');
                }, (sve_kartice.length - 1 - index) * 100);
            })(i);
        }

        setTimeout(() => {
            this.submit();
        }, (sve_kartice.length+2)*100);
    });

    // Gumb max usteda:
    $('#jeftini_ducan').on('submit', function(event){
        event.preventDefault();
        // Kartice polako nestaju
        var sve_kartice = $('.kartica_artikla');
        for (var i = sve_kartice.length - 1; i >= 0; i--) {
            (function(index) {
                setTimeout(function() {
                    $(sve_kartice[index]).removeClass('fade-in');
                }, (sve_kartice.length - 1 - index) * 100);
            })(i);
        }

        setTimeout(() => {
            this.submit();
        }, (sve_kartice.length+2)*100);
    });





    // Pamćenje scroll pozicije
    //  --> Koristi se u slučaju individualne optimizacije artikla
    const scrollPosition = localStorage.getItem('scrollPosition');
    if (scrollPosition) {
        // AKo je postavljena pozicija scrolla, vratimo se gdi smo bili
        window.scrollTo(0, parseInt(scrollPosition, 10));
        localStorage.removeItem('scrollPosition'); // Clean up
    }
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>

<!-- // Za svaki artikl u kosarici nadi gumb koji ce slati id ponude i id  -->
