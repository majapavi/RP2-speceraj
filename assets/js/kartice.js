// ovaj javaScript sadrži:
//     - funkciju za stvaranje kartice proizvoda (korištenu u ponude_index)
//     - funkciju za stvaranje kartice akcije (korištenu u akcije_index)
//     - funkciju za stvaranje kartice artikla (korištenu u kosarica_index)

function stvori_karticu_proizvoda(input)
{
    const objekt = document.createElement('div');
    objekt.classList.add('kartica_proizvoda');

    // Slika i ime
    const opis = document.createElement('div');
    opis.classList.add('opis');

    const slika = document.createElement('img');
    slika.src = input.Proizvod_Link;
    opis.appendChild(slika);
    opis.appendChild(document.createElement('br'));

    const ime = document.createElement('h4');
    ime.textContent = input.Proizvod_Naziv;
    opis.appendChild(ime);

    objekt.appendChild(opis);

    // Količina
    const kolicina = document.createElement('p');
    kolicina.innerHTML = 'Količina:<br>';

    let korak = input.Proizvod_Korak;
    if (korak == 1) {
        korak = parseInt(korak);
    }
    const unos = document.createElement('input');
    unos.classList.add('kolicina');
    unos.type = 'number';
    unos.min = input.Proizvod_Korak;
    unos.step = input.Proizvod_Korak;
    unos.placeholder = 'Unesi količinu';
    unos.value = korak;

    kolicina.appendChild(unos);
    objekt.appendChild(kolicina);

    // Dućani
    const ducani = document.createElement('div');
    ducani.classList.add('ducani');

    input.Ducani.forEach(info => {
        const ovaj_ducan = document.createElement('div');
        ovaj_ducan.classList.add('jedan_ducan');

        const logo = document.createElement('img');
        logo.src = info.Logo;
        ovaj_ducan.appendChild(logo);

        const dodatno = input.Proizvod_Korak == 1 ? "kom" : "kg";
        const cijena = document.createElement('p');
        cijena.innerHTML = `<strong>${info.Naziv}</strong><br>${info.Cijena} €/${dodatno}<br>`;
        if (info.Akcija === "DA") {
            cijena.classList.add('akcija');
            const akcijaLabel = document.createElement('p');
            akcijaLabel.style.padding = '0';
            akcijaLabel.style.margin = '0';
            akcijaLabel.style.color = 'red';
            akcijaLabel.textContent = 'AKCIJA';
            cijena.appendChild(akcijaLabel);
        } else {
            cijena.appendChild(document.createElement('br'));
        }
        ovaj_ducan.appendChild(cijena);

        const gumb = document.createElement('button');
        gumb.textContent = 'Dodaj u košaricu';
/*      PREPRAVITI U JAVASCRIPT
            gumb.addEventListener('click', function() {
            <?php
            $_COOKIE['kosarica'][$_SESSION["ID"]][$info.ID] = document.querySelector('.kolicina').value;
            require_once __DIR__ . '/../view/kosarica_index.php';
            ?>
        });
*/
        ovaj_ducan.appendChild(gumb);
        ducani.appendChild(ovaj_ducan);
    });

    objekt.appendChild(ducani);

    return objekt;
}


function stvori_karticu_akcije(input)
{
    const objekt = document.createElement('div');
    objekt.classList.add('kartica_akcije');

    const opis = document.createElement('div');
    opis.classList.add('opis');

    const proizvod = document.createElement('img');
    proizvod.src = input.Slika;
    opis.appendChild(proizvod);

    const desno = document.createElement('div');
    desno.classList.add('right');

    const ime = document.createElement('h4');
    ime.textContent = input.Naziv;
    desno.appendChild(ime);

    const ducan = document.createElement('img');
    ducan.src = input.DucanSlika;
    desno.appendChild(ducan);
    opis.appendChild(desno);

    objekt.appendChild(opis);

    const kolicina = document.createElement('p');
    kolicina.textContent = 'Količina: ';
    kolicina.style.marginRight = '10px';

    let korak = input.Korak;
    if (korak == 1) {
        korak = parseInt(korak);
    }

    const unos = document.createElement('input');
    unos.classList.add('kolicina');
    unos.type = 'number';
    unos.min = input.Korak;
    unos.step = input.Korak;
    unos.placeholder = 'Unesi količinu';
    unos.value = korak;

    kolicina.appendChild(unos);
    objekt.appendChild(kolicina);

    const cijena = document.createElement('p');
    cijena.innerHTML = `Cijena: ${input.Cijena}`;
    cijena.style.marginRight = '10px';
    cijena.style.textDecoration = 'line-through';
    objekt.appendChild(cijena);

    const akcijaElement = document.createElement('p');
    akcijaElement.innerHTML = "<label style='padding:0; margin:0; color:red;'>AKCIJA: </label>";
    akcijaElement.style.margin = 'auto';
    akcijaElement.style.padding = '5px';
    akcijaElement.classList.add('akcija');
    akcijaElement.innerHTML += input.Akcija;
    if (input.Korak == 0.1) {
        akcijaElement.innerHTML += "€ / kg";
        cijena.innerHTML += "€ / kg";
    } else {
        akcijaElement.innerHTML += "€ / kom";
        cijena.innerHTML += "€ / kom";
    }
    objekt.appendChild(akcijaElement);

    const gumb = document.createElement('button');
    gumb.textContent = 'Dodaj u košaricu';
    gumb.style.marginLeft = 'auto';
    gumb.addEventListener('click', function() {
        dodajArtikl(input.ID, unos.value);
    });
    objekt.appendChild(gumb);

    return objekt;
}


// artikl = {ArtiklID, ArtiklSlika, ArtiklaNaziv, DucanSlika, Kolicina, Cijena, Akcija}
function stvori_karticu_artikla(artiklZaView)
{
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
        kosaricaController.obrisiArtikl(artiklZaView.ponudaID, document.querySelector('.kolicina').value);
    });

    return sadrzaj;
}
