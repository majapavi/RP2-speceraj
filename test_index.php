<!-- Treba prebaciti ovu stranicu u view ( i prilagoditi require-ove i linkove u headeru da radi ) -->

<?php
    $title = "Ponuda";
    require_once __DIR__ . '/model/specerajservice.class.php';
    require_once __DIR__ . '/view/_header.php';
?>

<div id="forma_za_search_i_sort">
    <form>
        <input type="text" id="pretrazivanje" name="pretrazivanje" placeholder="Pretraži proizvode...">
        <label for="sortiranje">Sortiraj po: </label>
        <select name="sortiranje" id="sortiranje">
            <option value="bez_opcije">Zadano</option>
            <option value="naziv_uzlazno">Nazivu (A->Z)</option>
            <option value="naziv_silazno">Nazivu (Z->A)</option>
        </select>
        <input type="submit" value="Pretraži">
    </form>
</div>

<div id="sve_ponude"></div>

<?php

if(false){  // Ovaj if je samo da se pseudokod ne pokusava izvrsavat

    // Pseudokod ove web stranice
    $pretrazivanje = '';
    $sortiranje = '';

    // Provjera dal imamo kaj u get-u
    // Ako imamo pretrazivanje
    if( isset($_GET['pretrazivanje']) && $_GET['pretrazivanje'] != '' ){ // Mozda provjera dal je null?
        $pretrazivanje = $_GET['pretrazivanje'];
    }
    // Ako imamo sortiranje
    if( isset($_GET['sortiranje']) && $_GET['sortiranje'] != 'bez_opcije' ){ // Mozda provjera dal je null?
        $sortiranje = $_GET['sortiranje'];
    }

    $ss = new SpecerajService();
    $ss->getAllKartice($pretrazivanje, $sortiranje);

        // Pseudokod za funkciju getAllKartice
        function getAllKartice($search = '', $sort = ''){

            if( $search == '' && $sort == '' ){
                // SQL query tipa
                    /* SELECT id FROM projekt_proizvodi */
            }
            // else
                // Ako imamo $search != '' treba dodat
                    /* WHERE naziv LIKE %:nesto% */

                // Ako imamo $sort != '' treba dodati
                    /* ORDER BY naziv ASC (DESC) */

            // Dok imamo sve ID-ove proizvoda koji nam trebaju (nek su spremljeni u $indexi npr)

            foreach ($indexi as $i) {
                $sve_kartice[] = $ss->getKarticaByIdProizvoda($i);
                // Prilagodit da ne dohvaca sve ponude, smo one s trazenim id_proizvoda
            }

            // Mozda da se pretvori u JSON prije nego se vrati (moze se i kasnije)
            return $sve_kartice; json_encode($sve_kartice);
        }

        // Kad pomocu SpecerajService() dobijemo sve kartice, onda javascriptom popunimo stranicu
        foreach ($sve_kartice as $karica) {
            // Pretvaranje u JSON
            ubaci_objekt(kartica);
        }

        /////////////////////////////////////////////////////////////////////////////////////////////////////

        // Pseudokod / napomene za stranicu s akcijama

        // Slicno ko i gore, ali dodamo uvijet WHERE akcija != NULL u SQL query
        // Dodamo opcijeza sortiranje po cijeni

        // Prilagodimo javascript funkciju da generira manji objekt (samo s jednom ponudom, ne s cijelom karticom proizvoda)
    }
?>

<script>

    let kartica;

    <?php
        $ss = new SpecerajService();

        $kartice = $ss->getAllKartice();
        foreach( $kartice as $kartica ) {
            $json_kartica = json_encode($kartica);
            ?>
            kartica = <?php echo $json_kartica; ?>;
            ubaci_objekt(kartica);
            <?php
        }
    ?>


    function ubaci_objekt(input){
        const objekt = $('<div></div>').addClass('objekt');

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
        // PROBAJ
        // let korak = (int)input.Proizvod_Korak;
        // if (korak == input.Proizvod_Korak)
        unos = $(`<input class="kolicina" type="number" min="${input.Proizvod_Korak}" step="${input.Proizvod_Korak}">`).attr('placeholder', 'Unesi količinu');
        unos.val(input.Proizvod_Korak);
        kolicina.append(unos);

        objekt.append(kolicina);

        // Dućani
        const ducani = $('<div></div>').addClass('ducani');

        console.log("input.Ducani: ", input.Ducani);

        $.each(input.Ducani, function(index, info) {
            console.log("INFO: ", info);
            const ovaj_ducan = $('<div></div>').addClass('jedan_ducan');

            const logo = $('<img>').attr('src', info.Logo);
            const cijena = $('<p></p>').html(`<strong>${info.Naziv}</strong><br>Cijena: ${info.Cijena} €<br>`);
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


        $('#sve_ponude').append(objekt);
    }
</script>


<?php require_once __DIR__ . '/view/_footer.php'; ?>




<!-- for ($i=1; $i < 82; $i++) {
    $kartica = $ss->getKarticaByIdProizvoda( $i );
    $json_kartica = json_encode($kartica);
    ?>
    kartica = < ?php echo $json_kartica; ?>;
    ubaci_objekt(kartica);
    < ?php
} -->
