<?php
    require_once __DIR__ . '/../model/specerajservice.class.php';
    require_once __DIR__ . '/_header.php';
?>

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
    console.log("zadnjiSort: ", zadnjiSort)
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
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>