// ovaj javaScript sadrži:
//     - funkciju za stvaranje kartice proizvoda (korištenu u ponude_index)
//     - funkciju za stvaranje kartice akcije (korištenu u akcije_index)

function stvori_karticu_proizvoda( input ){

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
    unos = $(`<input class="kolicina" type="number" min="${input.Proizvod_Korak}" step="${input.Proizvod_Korak}">`).attr('placeholder', 'Unesi količinu');

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
        gumb.on('click', function() {
            //id ponude ce bit u info
            kosaricaController.dodajPonudu(input.ID, $('kolicina').val());
        });

        ovaj_ducan.append(logo).append(cijena).append(gumb);
        ducani.append(ovaj_ducan);
    });

    objekt.append(ducani);

    return objekt;
}

function stvori_karticu_akcije( input ){

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
        
    unos = $(`<input class="kolicina" type="number" min="${input.Korak}" step="${input.Korak}">`).attr('placeholder', 'Unesi količinu');
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
    gumb.on('click', function() {
        kosaricaController.dodajArtikl(input.ID, $('kolicina').val());
    });
objekt.append(gumb);

    return objekt;
}

// artikl = {ArtiklID, ArtiklSlika, ArtiklaNaziv, DucanSlika, Kolicina, Cijena, Akcija}
function stvori_karticu_artikla( artiklZaView )
{
    // ArtiklID, ArtiklSlika, ArtiklaNaziv, DucanSlika, Kolicina, Cijena, Akcija
    // u json format 
    
        //daj ujednaci ove nazive
        const sadrzaj = $('<div></div>').addClass('kartica_artikla');
    
        const slika_proizvoda = $('<img>').attr('src', artiklZaView.ArtiklSlika);
        sadrzaj.append(slika_proizvoda);
        
        const ime_proizvoda = $('<h4></h4>');
        ime_proizvoda.append(`${artiklZaView.ArtiklaNaziv}`);
        sadrzaj.append(ime_proizvoda);
    
        const slika_ducana = $('<img>').attr('src', artiklZaView.DucanSlika);
        sadrzaj.append(slika_ducana);
        //sadrzaj.append(desno);
    
        // Količina
        const kolicina = $('<div></div>').append("Kolicina: " + `${artiklZaView.Kolicina}`)
        //KOLICINA SE SALJE KO STRING, ZAJEDNO SA MJERNOM JEDINICOM
        sadrzaj.append(kolicina);
        
        // Cijena
        const cijena = $('<div></div>').append("Cijena: " + `${artiklZaView.Cijena}`)
        sadrzaj.append(cijena);
    
        const gumb = $('<button></button>').addClass('removeBtn').html('Ukloni iz košarice').css('margin-left', 'auto');
        sadrzaj.append(gumb);
        gumb.on('click', function() {
            kosaricaController.dodajArtikl(artiklZaView.ArtiklID);
        });
    
        return sadrzaj;
    }
    
    function nadi_najjeftiniju_ponudu_artikla( )
    {
    
    }