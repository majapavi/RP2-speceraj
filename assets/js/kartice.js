// ovaj javaScript sadrži:
//     - funkciju za stvaranje kartice proizvoda (korištenu u ponude_index)
//     - funkciju za stvaranje kartice akcije (korištenu u akcije_index)
//     - funkciju za stvaranje kartice artikla (korištenu u kosarica_index)

function stvori_karticu_proizvoda( input, userID ){

    const objekt = $('<div></div>').addClass('kartica_proizvoda');

    // Slika i ime
    const opis = $('<div></div>').addClass('opis');

    const slika = $('<img>').attr('src', input.Proizvod_Link);
    opis.append(slika);
    opis.append($('<br>'));

    const ime = $('<h4></h4>');
    ime.append(`${input['Proizvod_Naziv']}`);
    opis.append(ime);

    objekt.append(opis);

    // Količina
    const kolicina = $('<p></p>').append('Količina:<br>');
    
    let korak = input.Proizvod_Korak;
    if( korak == 1 ){
        korak = parseInt(korak);
    }
    
    let unos = $(`<input class="kolicina" type="number" min="${input.Proizvod_Korak}" step="${input.Proizvod_Korak}">`).attr('placeholder', 'Unesi količinu');
    unos.val(korak);
    kolicina.append(unos);
    
    objekt.append(kolicina);

    // Dućani
    const ducani = $('<div></div>').addClass('ducani');

    $.each(input.Ducani, function(index, info) {
        const ovaj_ducan = $('<div></div>').addClass('jedan_ducan');

        const logo = $('<img>').attr('src', info.Logo);
        let dodatno = 'kom';
        if( input.Proizvod_Korak == 0.1 ){
            dodatno = "kg";
        }
        const cijena = $('<p></p>').html(`<strong>${info.Naziv}</strong><br>${info.Cijena} €/${dodatno}<br>`);
        if(info.Akcija == "DA"){
            cijena.addClass('akcija');
            cijena.append("<p style='padding:0; margin:0; color:red;'>AKCIJA</p>");
        }
        else{
            cijena.append("<br>")
        }
        const gumb = $('<button></button>').html('Dodaj u košaricu');
        
        // Funkcionalnost gumba
        gumb.on('click', function() {
            let ponuda = info.ID_Ponuda;
            spremi_artikl_u_kosaricu(userID, ponuda, unos.val());

            // Ispis potvrde
            const dodavanje = $('#dodavanje');
            const obavijest = $('<div class="obavijest"></div');
            obavijest.text(`Dodan proizvod ${input.Proizvod_Naziv} u košaricu\n(${unos.val()} ${dodatno}, ${info.Naziv})`);
            dodavanje.append(obavijest);

            setTimeout(() => {
                obavijest.addClass('pokazi');
            }, 10);

            setTimeout(() => {
                obavijest.removeClass('pokazi');
            
                setTimeout(() => {
                    obavijest.remove();
                }, 500);
            }, 4000);

        });

        ovaj_ducan.append(logo).append(cijena).append(gumb);
        ducani.append(ovaj_ducan);
    });

    objekt.append(ducani);

    return objekt;
}

function stvori_karticu_akcije( input, userID){

    const objekt = $('<div></div>').addClass('kartica_akcije');

    // Slike i naziv
    const opis = $('<div></div>').addClass('opis');
    
    const proizvod = $('<img>').attr('src', input.Slika);
    opis.append(proizvod);
    
    const desno = $('<div></div>').addClass('right')

    const ime = $('<h4></h4>');
    ime.append(`${input.Naziv}`);
    desno.append(ime);

    const ducan = $('<img>').attr('src', input.DucanSlika);
    desno.append(ducan);
    opis.append(desno);

    objekt.append(opis);

    // Količina
    const kolicina = $('<p></p>').append('Količina: ').css('margin-right', '10px');
    
    let korak = input.Korak;
    if( korak == 1 ){
        korak = parseInt(korak);
    }
        
    let unos = $(`<input class="kolicina" type="number" min="${input.Korak}" step="${input.Korak}">`).attr('placeholder', 'Unesi količinu');
    unos.val(korak);

    kolicina.append(unos);
    objekt.append(kolicina);
    
    // Stara cijena
    const cijena = $('<p></p>').html(`Cijena: ${input.Cijena}`).css('margin-right', '10px');
    cijena.css('text-decoration', 'line-through');
    objekt.append(cijena);

    // Akcija
    const akcija = $('<p></p>').append("<label style='padding:0; margin:0; color:red;'>AKCIJA: </label>");
    akcija.css('margin', 'auto').css('padding','5px');
    akcija.addClass('akcija')
    akcija.append(input.Akcija);
    let dodatno = "kom";
    if(input.Korak == 0.1){
        dodatno = "kg";
        akcija.append("€ / kg");
        cijena.append("€ / kg");
    }
    else{
        akcija.append("€ / kom")
        cijena.append("€ / kom")
    }
    objekt.append(akcija);

    const gumb = $('<button></button>').html('Dodaj u košaricu').css('margin-left', 'auto');
    // Funkcionalnost gumba
    gumb.on('click', function() {
        let ponuda = input.ID;
        spremi_artikl_u_kosaricu(userID, ponuda, unos.val());
        
            // Ispis potvrde
            const dodavanje = $('#dodavanje');
            const obavijest = $('<div class="obavijest"></div');
            obavijest.text(`Dodan proizvod ${input.Naziv} u košaricu\n(${unos.val()} ${dodatno}, ${input.Ducan})`);
            dodavanje.append(obavijest);

            setTimeout(() => {
                obavijest.addClass('pokazi');
            }, 10);

            setTimeout(() => {
                obavijest.removeClass('pokazi');
            
                setTimeout(() => {
                    obavijest.remove();
                }, 500);
            }, 4000);

    });
    
    objekt.append(gumb);

    return objekt;
}


// artikl = {ArtiklID, ArtiklSlika, ArtiklaNaziv, DucanSlika, Kolicina, Cijena, Akcija, Korak?}
function stvori_karticu_artikla(artiklZaView, userID, index) {
    const sadrzaj = $('<div>', { class: 'kartica_artikla' });

    const slika_proizvoda = $('<img>', { src: artiklZaView.ArtiklSlika });
    sadrzaj.append(slika_proizvoda);

    const ime_proizvoda = $('<h4>').text(artiklZaView.ArtiklaNaziv);
    sadrzaj.append(ime_proizvoda);

    const slika_ducana = $('<img>', { src: artiklZaView.DucanSlika });
    sadrzaj.append(slika_ducana);

    // Količina
    let jedinica = "kom";
    if (artiklZaView.Korak == 0.1) {
        jedinica = "kg";
    }
    const kolicina = $('<div>').text(`Količina: ${Math.round(artiklZaView.Kolicina * 100) / 100} ${jedinica}`);
    sadrzaj.append(kolicina);

    // Cijena
    const cijena = $('<div>');
    if (artiklZaView.Akcija == null) {
        cijena.text(`Cijena: ${Math.round(artiklZaView.Cijena * artiklZaView.Kolicina * 100) / 100} €`);
    } else {
        cijena.text(`Cijena: ${Math.round(artiklZaView.Akcija * artiklZaView.Kolicina * 100) / 100} €`);
        cijena.addClass('akcija');
    }
    sadrzaj.append(cijena);

    const gumb = $('<button>', {
        class: 'removeBtn',
        text: 'Ukloni iz košarice',
        css: { marginLeft: 'auto' }
    });

    gumb.on('click', function () {
        let ponuda = artiklZaView.ponudaID;
        makni_artikl_iz_kosarice(userID, ponuda);

        const broj_label = $('#broj');
        let broj = parseFloat(broj_label.text());
        if (artiklZaView.Akcija == null) {
            broj -= artiklZaView.Cijena * artiklZaView.Kolicina;
        } else {
            broj -= artiklZaView.Akcija * artiklZaView.Kolicina;
        }
        broj = Math.round(broj * 100) / 100;
        broj_label.text(broj.toFixed(2));

        // fade
        sadrzaj.removeClass('fade-in');
        // brisanje
        sadrzaj.on('transitionend', function handler(event) {
            // Unbind the event
            sadrzaj.off('transitionend', handler);
            
            // Provjera ima li jos vidljivih elemenata
            if ($('.kartica_artikla').filter('.fade-in').length == 0) {
                $('#gumbi').addClass('fade-out');
                const poruka = $('<p style="margin-left: 40px">Vaša košarica je prazna.</p>');
                poruka.hide();
                $('#kosarica').append(poruka);
                poruka.fadeIn(500);
            }
        });
    });

    // TEST gumb za formu "pronađi jeftiniji dućan"
    const gumbici = $('<div>', { class: 'gumbici' });
    gumbici.append(gumb);

    const forma_za_gumb2 = $('<form>', {
        action: `index.php?rt=kosarica/sparajNaJednomArtiklu`,
        method: 'post'
    });

    const idPonudaInput = $('<input>', {
        type: 'hidden',
        name: 'id_ponuda',
        value: artiklZaView.ponudaID // Assuming ponudaID is the parameter you want to send
    });

    forma_za_gumb2.append(idPonudaInput);

    const gumb2 = $('<button>', {
        type: 'submit',
        text: 'Nađi jeftinije'
    });
    
    forma_za_gumb2.on('submit', function(event) {
        event.preventDefault();
        localStorage.setItem('broj_kartica', $('.kartica_artikla.fade-in').length );
        sadrzaj.removeClass('fade-in');
        // Spremamo poziciju scrolla
        localStorage.setItem('index_mijenjanog', index);
        localStorage.setItem('scrollPosition', window.scrollY);
        
        $('.obavijest').removeClass('pokazi');

        setTimeout(() => {
            this.submit();
        }, 400);
    });

    forma_za_gumb2.append(gumb2);
    gumbici.append(forma_za_gumb2);

    sadrzaj.append(gumbici);

    return sadrzaj;
}
