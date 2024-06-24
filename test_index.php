<?php
    $title = "Test objekt";
?>
<script>
    const test_objekt = {
    //   id: 1,
    slika: "https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/proizvodi/sir.png",
    proizvod: "Sir",
    ducani: {
        konzum: {
            logo: "https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/konzum.png",
            cijena: "3.2€",
            akcija: "NE"
            },
        spar: {
            logo: "https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/spar.png",
            cijena: "1.7€",
            akcija: "DA"
            },
        lidl: {
            logo: "https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/ducani/lidl.png",
            cijena: "2.8€",
            akcija: "NE"
            }
        }
    };

    // let test_objekt = [ 'slika' => "https://e7.pngegg.com/pngimages/254/955/png-clipart-gruyere-cheese-cheesecake-swiss-cheese-cheese-cheese-slice-food-cheese.png",
    //                     'proizvod' => "Sir",
    //                     'ducani' => [   'konzum' => [   'logo' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVeELSDUQHmeXN4-q8jB_Q6wSJPet2tAxreg&s",
    //                                                     'cijena' => "3.2€",
    //                                                     'akcija' => "NE"
    //                                                 ],
    //                                     'spar' =>   [   'logo' => "https://banner2.cleanpng.com/20180518/zte/kisspng-spar-logo-company-marketing-5afe7f0fbac0d3.362503861526628111765.jpg",
    //                                                     'cijena' => "1.7€",
    //                                                     'akcija' => "DA"
    //                                                 ],
    //                                     'lidl' =>   [   'logo' => "https://w7.pngwing.com/pngs/727/982/png-transparent-lidl-logo-ireland-logo-lidl-symbols-lidl-logo-miscellaneous-cdr-text-thumbnail.png",
    //                                                     'cijena' => "2.8€",
    //                                                     'akcija' => "NE"
    //                                                 ]
    //                                 ]
    //                 ];
</script>



<?php require_once __DIR__ . '/view/_header.php'; ?>

<div id="svi_objekti">Tu ide objekt</div>

<?php
require_once __DIR__ .'/model/specerajservice.class.php';

$ss = new SpecerajService();
$kartica = $ss->getKarticaByIdProizvoda( 4 );
// print_r($kartica);
$json_kartica = json_encode($kartica);
echo "<hr>";
// print($json_kartica);
?>

<script>
    console.log("PRVI TEST: ", test_objekt);
    // ubaci_objekt(test_objekt);
    // ubaci_objekt(test_objekt);

    // ovdje pokusavam ubacit karticu
    let kartica = <?php echo $json_kartica; ?>;
    console.log("DRUGI TEST: ", kartica);
    // ubaci_objekt(kartica);

    <?php
        for ($i=1; $i < 7; $i++) { 
            $kartica = $ss->getKarticaByIdProizvoda( $i );
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


        $('#svi_objekti').append(objekt);
    }
</script>


<?php require_once __DIR__ . '/view/_footer.php'; ?>
