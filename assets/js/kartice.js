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
        // console.log("INFO: ", info);
        const ovaj_ducan = $('<div></div>').addClass('jedan_ducan');

        const logo = $('<img>').attr('src', info.Logo);
        let dodatno = 'kg';
        if( input.Proizvod_Korak == 1 ){
            dodatno = "kom";
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
    if(input.Korak == 0.1){
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
        // console.log(getCookie(`kosarica${userID}`))
    });
    
    objekt.append(gumb);

    return objekt;
}


// artikl = {ArtiklID, ArtiklSlika, ArtiklaNaziv, DucanSlika, Kolicina, Cijena, Akcija}
function stvori_karticu_artikla(artiklZaView, userID)
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
        let ponuda = artiklZaView.ponudaID;
        makni_artikl_iz_kosarice(userID, ponuda);
        console.log(getCookie(`kosarica${userID}`));
    });

    return sadrzaj;
}