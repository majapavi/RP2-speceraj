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