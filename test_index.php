<?php
    $title = "Test objekt";
?>
<script>
    const test_objekt = {
    //   id: 1,
      slika: "https://rp2.studenti.math.hr/~brunpola/projekt-speceraj/slike/sir.png",
      proizvod: "Sir",
      ducani: {
        konzum: {
          logo: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVeELSDUQHmeXN4-q8jB_Q6wSJPet2tAxreg&s",
          cijena: "3.2€",
          akcija: "NE"
        },
        spar: {
          logo: "https://banner2.cleanpng.com/20180518/zte/kisspng-spar-logo-company-marketing-5afe7f0fbac0d3.362503861526628111765.jpg",
          cijena: "1.7€",
          akcija: "DA"
        },
        lidl: {
          logo: "https://w7.pngwing.com/pngs/727/982/png-transparent-lidl-logo-ireland-logo-lidl-symbols-lidl-logo-miscellaneous-cdr-text-thumbnail.png",
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

<script>
    console.log(test_objekt);
    ubaci_objekt(test_objekt);
    ubaci_objekt(test_objekt);
    
    function ubaci_objekt(input){
        const objekt = $('<div></div>').addClass('objekt');

        // Slika i ime
        const opis = $('<div></div>').addClass('opis');

        const slika = $('<img>').attr('src', input.slika);  
        opis.append(slika);
        opis.append($('<br>'));

        const ime = $('<h4></h4>');
        ime.append(`${input['proizvod']}`);
        console.log(ime);
        opis.append(ime);

        objekt.append(opis);

        
        // Količina
        const kolicina = $('<p></p>').append('Količina:<br>');
        unos = $('<input class="kolicina" type="number" min="0.1" step="0.1">').attr('placeholder', 'Quantity');
        unos.val(1.0);
        kolicina.append(unos);
    
        objekt.append(kolicina);

        // Dućani
        const ducani = $('<div></div>').addClass('ducani');

        $.each(test_objekt.ducani, function(ducan, info) {
            const ovaj_ducan = $('<div></div>').addClass('jedan_ducan');

            const logo = $('<img>').attr('src', info.logo);
            const cijena = $('<p></p>').html(`<strong>${ducan}</strong><br>Cijena: ${info.cijena}<br>`);
            if(info.akcija == "DA"){
                cijena.addClass('akcija');
                cijena.append("AKCIJA");
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