<?php require_once __DIR__ . '/_header.php'; ?>

<div class="container">
    <div class="left-box">
        <p><?php echo $msg; ?></p>

        <form id="reviewForm" method="post" action="index.php?rt=recenzije/posalji">
            <label for="store">Odaberi dućan:</label>
            <select id="store" name="store" required>
                <?php
                    foreach( $ducani as $ducan ) {
                        $selected = ($zadnjiDucan == $ducan->ID) ? 'selected' : '';
                        echo '<option value="' . $ducan->ID . '" ' . $selected . '>' . htmlspecialchars($ducan->Naziv, ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                ?>
            </select>
            
            <br><br>

            <label for="review">Recenzija:</label><br>
            <textarea class="review" name="review" required></textarea>
            <br>

            <div class="rating-container">
                <label>Ocjena:</label>
                <div id="stars">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
            </div>
            <input type="hidden" id="rating" name="rating" required>
            <br>

            <div class="submit-container">
                <button type="submit">Pošalji recenziju</button>
            </div>
        </form>
    </div>

    <div class="right-container">
        <?php
            foreach ($ducani as $ducan) {
                echo '<div class="reviews hidden" id="reviews-' . $ducan->ID . '">';

                $count = 0;
                foreach ($recenzije as $recenzija) {
                    if ($recenzija->ID_Ducan !== $ducan->ID) continue;
                    $count++;

                    echo '<div class="right-box">';
                    echo '<div><strong>' . htmlspecialchars($recenzija->User, ENT_QUOTES, 'UTF-8') . '</strong></div>';
                    echo '<div><img src="' . htmlspecialchars($recenzija->Ducan_Logo, ENT_QUOTES, 'UTF-8') . '" alt="Logo dućana"></div>';
                    echo '<div class="stars">' . str_repeat('&#9733;', (int)$recenzija->Ocjena) . '</div>';
                    echo '<div>' . htmlspecialchars($recenzija->Tekst, ENT_QUOTES, 'UTF-8') . '</div>';
                    echo '</div>';
                }
                if($count === 0) {
                    echo '<div class="right-box"><p>Nema recenzija za ovaj dućan.</p></div>';
                }
                echo '</div>';
            }
        ?>
    </div>
</div>

<script>
    // Zadrži zadnje izabrani dućan
    <?php $zadnjiDucan = isset($_POST['store']) ? $_POST['store'] : '1'; ?>;
    const selectedStore = "<?php echo $zadnjiDucan; ?>";
    console.log("selectedStore: ", selectedStore);
    if (selectedStore) {
        document.querySelector(`select[name='store'] option[value='${selectedStore}']`).selected = true;
    }
</script>

<script>
    const stars = document.querySelectorAll('.star');
    let selectedRating = 0;
    let prosjek;
    
    // Mappiranje prosjeka (koristi se za ažuriranje ocjene pokraj selecta)
    <?php
        $prosjekValues = array_map(function($ducan) {
            return [
                "Prosjek" => $ducan->Prosjek,
                "Naziv" => $ducan->Naziv,
            ];
        }, $ducani);
        
        // Encode the "Prosjek" values to JSON
        $prosjekJson = json_encode($prosjekValues);
    ?>
    var prosjeci = <?php echo $prosjekJson; ?>;
    console.log(prosjeci);

    stars.forEach(star => {
        star.addEventListener('click', () => {
            selectedRating = star.getAttribute('data-value');
            document.getElementById('rating').value = selectedRating;
            updateStars();
        });

        star.addEventListener('mouseover', () => {
            const rating = star.getAttribute('data-value');
            highlightStars(rating);
        });

        star.addEventListener('mouseout', () => {
            highlightStars(selectedRating);
        });
    });

    function highlightStars(rating) {
        stars.forEach(star => {
            star.classList.toggle('selected', star.getAttribute('data-value') <= rating);
        });
    }

    function updateStars() {
        highlightStars(selectedRating);
    }

    // Promjena odabranog dućana
    document.getElementById('store').addEventListener('change', function() {
        var selectedStore = this.value;
        var reviewsContainers = document.querySelectorAll('.reviews');
        reviewsContainers.forEach(function(container) {
            container.classList.add('hidden');
        });
        var activeContainer = document.getElementById('reviews-' + selectedStore);
        if (activeContainer) {
            activeContainer.classList.remove('hidden');
        }

        // Ispis ocjene
        const ocj = $('.ocjena_ducana');
        ocj.empty();
        // zlatno.empty();
        // sivo.empty();
        prosjek = prosjeci[selectedStore-1]["Prosjek"];
        naziv = prosjeci[selectedStore-1]["Naziv"];
        ocj.append(" za ", naziv, " ");
        let zlatno = $('<span style="color:gold;"></span>');
        let sivo = $('<span style="color:gray;"></span>');
        for (let index = 0.5; index < 5; index += 1) {
            console.log(index, prosjek);
            if(index <= prosjek){
                zlatno.append('&#9733;');
            }
            else{
                sivo.append('&#9733;');
            }
        }
        ocj.append(zlatno).append(sivo);
        ocj.append(" ", prosjek);
    });

    // Pokreni promjenu odabranog dućana prilikom učitavanja stranice
    document.getElementById('store').dispatchEvent(new Event('change'));
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>
