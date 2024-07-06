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

    // artikl = {ArtiklID, ArtiklSlika, ArtiklaNaziv, DucanSlika, Kolicina, Cijena, Akcija}
    function stvori_karticu_artikla(artiklZaView) {
    const sadrzaj = document.createElement('div');
    sadrzaj.classList.add('kartica_artikla');

    const slika_proizvoda = document.createElement('img');
    slika_proizvoda.src = artiklZaView.ArtiklSlika;
    sadrzaj.appendChild(slika_proizvoda);

    const ime_proizvoda = document.createElement('h4');
    ime_proizvoda.textContent = artiklZaView.ArtiklaNaziv;
    sadrzaj.appendChild(ime_proizvoda);

    const slika_ducana = document.createElement('img');
    slika_ducana.src = artiklZaView.DucanSlika;
    sadrzaj.appendChild(slika_ducana);

    // Količina
    const kolicina = document.createElement('div');
    kolicina.textContent = `Količina: ${artiklZaView.Kolicina}`;
    sadrzaj.appendChild(kolicina);

    // Cijena
    const cijena = document.createElement('div');
    cijena.textContent = `Cijena: ${artiklZaView.Cijena}`;
    sadrzaj.appendChild(cijena);

    const gumb = document.createElement('button');
    gumb.classList.add('removeBtn');
    gumb.textContent = 'Ukloni iz košarice';
    gumb.style.marginLeft = 'auto';
    sadrzaj.appendChild(gumb);

    gumb.addEventListener('click', function() {
        const kosaricaController = new KosaricaController();
        kosaricaController.obrisiArtikl(artiklZaView.ArtiklID, document.querySelector('.kolicina').value);
    });

    return sadrzaj;
}
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>