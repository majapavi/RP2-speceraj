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
    let userID = <?php echo $_SESSION["ID"]; ?>;
    // console.log("userID: ", userID);

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
                $('#sve_ponude').append( stvori_karticu_proizvoda(kartica, userID) );
                <?php
            }
        }
    ?>
</script>


<?php require_once __DIR__ . '/_footer.php'; ?>