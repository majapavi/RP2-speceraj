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
    
    const ime = $('<h4></h4>');
    ime.append(`${input.Naziv}`);
    opis.append(ime);

    const slike = $('<div></div>').addClass('bot')
    const proizvod = $('<img>').attr('src', input.Slika);
    slike.append(proizvod);
    
    const ducan = $('<img>').attr('src', input.DucanSlika);
    slike.append(ducan);
    opis.append(slike);

    objekt.append(opis);

    // Ducan (logo i ime)
    // const ducan = $('<div></div>').addClass('opis_ducana');

    // // const logo = $('<img>').attr('src', input.DucanSlika);
    // // ducan.append(logo);
    // // ducan.append($('<br>'));

    // const ime_ducana = $('<h4></h4>');
    // ime_ducana.append(`${input.Ducan}`);
    // // ducan.append(ime_ducana);

    // objekt.append(ducan);


    // Količina
    const kolicina = $('<p></p>').append('Količina: ');
    
    let korak = input.Korak;
    if( korak == 1 ){
        korak = parseInt(korak);
    }
        
    unos = $(`<input class="kolicina" type="number" min="${input.Korak}" step="${input.Korak}">`).attr('placeholder', 'Unesi količinu');
    unos.val(korak);

    kolicina.append(unos);
    objekt.append(kolicina);
    
    // Stara cijena
    const cijena = $('<p></p>').html(`Cijena: ${input.Cijena}`);
    cijena.css('text-decoration', 'line-through');
    objekt.append(cijena);

    // Akcija
    const akcija = $('<p></p>').append("<label style='padding:0; margin:0; color:red;'>AKCIJA: </label>");
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

    const gumb = $('<button></button>').html('Dodaj u košaricu');
    objekt.append(gumb);

    return objekt;
}