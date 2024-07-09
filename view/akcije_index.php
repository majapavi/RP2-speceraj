<?php
    require_once __DIR__ . '/../model/specerajservice.class.php';
    require_once __DIR__ . '/_header.php';
?>

<!-- This section contains a form for searching and sorting actions -->
<div class="forma_za_search_i_sort">
    <form action="index.php?rt=akcije/index" method="POST" class="filter">
        <div class="check_forma">
        Odaberite dućane koje želite pretražiti:
        <?php
            foreach ($ducani as $ducan) {
                echo "<label>";
                echo "<input type='checkbox' name='ducani[]' value = '$ducan->ID'>";
                echo $ducan->Naziv;
                echo "</label>";
            }
        ?>
        </div>
        <input type="search" class="pretrazivanje" name="pretrazivanje" placeholder="Pretraži proizvode...">
        <label for="sortiranje">Sortiraj po: </label>
        <select name="sortiranje" class="sortiranje">
            <option value="">Zadano</option>
            <option value="Naziv ASC">Nazivu (A->Z)</option>
            <option value="Naziv DESC">Nazivu (Z->A)</option>
            <option value="Akcija ASC">Cijena (prvo najjeftinije)</option>
            <option value="Akcija DESC">Cijena (prvo najskuplje)</option>
        </select>
        <input type="submit" value="Primjeni filter">
    </form>
    <form action="index.php?rt=akcije/index" method="POST" class="reset">
        <input type="submit" value="Očisti filter">
    </form>
</div>

<div id="sve_akcije"></div>

<script>

    document.addEventListener('DOMContentLoaded', function()
    {
        let akcija;

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

        // Zadrzi zadnje izabrane checkbox opcije
        let id;
        <?php 
            $zadnjiCheck = isset($_POST['ducani']) ? $_POST['ducani'] : [];
            foreach ($zadnjiCheck as $key => $value) {
                ?>
                id = <?php echo $value ?>
                // console.log(id);
                $(`input[type='checkbox'][value='${id}']`).prop('checked', true);    
                <?php
            }
        ?>

        <?php

            if( count($akcije) == 0 ){
                ?>
                $('#sve_akcije').append(`<p>Nema rezultata za pretraživanje: <strong>${zadnjePretrazivanje}</strong></p>`)
                <?php
            }
            else{
                foreach( $akcije as $akcija ) {
                    ?>
                    akcija = <?php echo $akcija; ?>;
                    // console.log(akcija);
                    $('#sve_akcije').append( stvori_karticu_akcije(akcija) );
                    <?php
                }
            }

        ?>

        function stvori_karticu_akcije(input) {
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

    });

    function dodajArtikl(ponudaId, kolicina) {
        // Construct the cookie value
        let cookieValue = '';
        if (document.cookie.includes('kosarica=')) {
            // If 'kosarica' cookie already exists, retrieve its value
            cookieValue = decodeURIComponent(document.cookie.replace(/(?:(?:^|.*;\s*)kosarica\s*\=\s*([^;]*).*$)|^.*$/, "$1"));
        }

        // Parse the existing cookie value or initialize an empty object
        let kosarica = cookieValue ? JSON.parse(cookieValue) : {};

        // Update the cart object with the new item
        kosarica[ponudaId] = kolicina;

        // Encode the updated cart object and set it as the 'kosarica' cookie
        document.cookie = `kosarica=${encodeURIComponent(JSON.stringify(kosarica))}; path=/`;

        // Assuming you want to update the UI after adding the item to "cart"
        // Replace with actual UI update logic as per your application
        //updateCartUI();

        // Example: Reload or navigate to the cart view (assuming it's a separate HTML page or view)
        window.location.href = '/../view/kosarica_index.php';
    }

</script>

<?php require_once __DIR__ . '/_footer.php'; ?>