<?php
    require_once __DIR__ . '/../model/specerajservice.class.php';
    require_once __DIR__ . '/_header.php';
    require_once __DIR__ . '/../controller/kosaricaController.class.php';
    ?>

<div class="forma_za_search_i_sort">
    <form action="index.php?rt=ponude/index" method="POST" class="filter">
        <input type="search" class="pretrazivanje" name="pretrazivanje" placeholder="Pretraži proizvode...">
        <label for="sortiranje">Sortiraj po: </label>
        <select name="sortiranje" class="sortiranje">
            <option value="">Zadano</option>
            <option value="Naziv ASC">Nazivu (A->Z)</option>
            <option value="Naziv DESC">Nazivu (Z->A)</option>
        </select>
        <input type="submit" value="Pretraži i sortiraj">
    </form>
    <form action="index.php?rt=ponude/index" method="POST" class="reset">
        <input type="submit" value="Prikaži sve ponude">
    </form>
</div>

<div id="sve_ponude"></div>

<script>

    let kartica;

    <?php $zadnjePretrazivanje = isset($_POST['pretrazivanje']) ? $_POST['pretrazivanje'] : ''; ?>;
    
    // Zadrzi zadnje pretrazivanje u search baru
    const zadnjePretrazivanje = "<?php echo htmlspecialchars($zadnjePretrazivanje, ENT_QUOTES, 'UTF-8'); ?>";
    if (zadnjePretrazivanje) {
        $('.pretrazivanje').val(zadnjePretrazivanje);
    }

    // Zadrzi zadnju izabranu sort opciju
    <?php $zadnjiSort = isset($_POST['sortiranje']) ? $_POST['sortiranje'] : ''; ?>;
    const zadnjiSort = "<?php echo $zadnjiSort; ?>";
    //console.log("zadnjiSort: ", zadnjiSort)
    if(zadnjiSort){
        $(`option[value='${zadnjiSort}']`).prop('selected', true);
    }
    <?php

        if( count($kartice) == 0 ){
            ?>
            $('#sve_ponude').append(`<p>Nema rezultata za pretraživanje: <strong>${zadnjePretrazivanje}</strong></p>`)
            <?php
        }
        else{
            foreach( $kartice as $kartica ) {
                $json_kartica = json_encode($kartica);
                ?>
                kartica = <?php echo $json_kartica; ?>;
                //console.log(kartica);
                $('#sve_ponude').append( stvori_karticu_proizvoda(kartica) );
                <?php
            }
        }

        

        // foreach( $akcije as $akcija ) {
        //     ?>
        //     akcija = <?php 
        // echo $akcija; ?>;
        //     console.log( akcija );
        //     <?php
        // }

    ?>

function stvori_karticu_proizvoda(input) {
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
        gumb.addEventListener('click', function() {
            <?php
            $_COOKIE['kosarica'][$_SESSION["ID"]][$info.ID] = document.querySelector('.kolicina').value;
            require_once __DIR__ . '/../view/kosarica_index.php';
            ?>
        });

        ovaj_ducan.appendChild(gumb);
        ducani.appendChild(ovaj_ducan);
    });

    objekt.appendChild(ducani);

    return objekt;
}

</script>


<?php require_once __DIR__ . '/_footer.php'; ?>