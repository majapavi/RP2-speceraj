<?php require_once __DIR__ . '/_header.php'; ?>

<div class="container">
    <div class="left-box">
        <p><?php echo $msg; ?></p>

        <form id="reviewForm" method="post" action="index.php?rt=recenzije/posalji">
            <label for="store">Odaberi dućan:</label>
            <select id="store" name="store" required>
                <?php
                    foreach( $ducani as $ducan ) {
                        echo '<option value="' . $ducan->ID . '">' . $ducan->Naziv . '</option>';
                    }
                ?>
            </select>
            <br><br>

            <label for="review">Recenzija:</label>
            <textarea id="review" name="review" required></textarea>
            <br><br>

            <label>Ocjena:</label>
            <div id="stars">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <input type="hidden" id="rating" name="rating" required>
            <br><br>

            <button type="submit">Pošalji recenziju</button>
        </form>
    </div>

    <div class="right-container">
        <div class="right-box" style="background-color: lightgreen;">
            <table>
                <tr>
                    <th>ID</th>
                    <th>ID_Ducan</th>
                    <th>ID_User</th>
                    <th>Ocjena</th>
                    <th>Tekst</th>
                </tr>
                <?php
                    foreach( $recenzijeList as $recenzija )
                    {
                        echo '<tr>';
                        echo '<td>' . $recenzija->ID . '</td>';
                        echo '<td>' . $recenzija->ID_Ducan . '</td>';
                        echo '<td>' . $recenzija->ID_User . '</td>';
                        echo '<td>' . $recenzija->Ocjena . '</td>';
                        echo '<td>' . $recenzija->Tekst . '</td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </div>
        <div class="right-box" style="background-color: lightcoral;">
            <table>
                <tr>
                    <th>ID</th>
                    <th>ID_Ducan</th>
                    <th>ID_User</th>
                    <th>Ocjena</th>
                    <th>Tekst</th>
                </tr>
                <?php
                    foreach( $recenzijeList as $recenzija )
                    {
                        echo '<tr>';
                        echo '<td>' . $recenzija->ID . '</td>';
                        echo '<td>' . $recenzija->ID_Ducan . '</td>';
                        echo '<td>' . $recenzija->ID_User . '</td>';
                        echo '<td>' . $recenzija->Ocjena . '</td>';
                        echo '<td>' . $recenzija->Tekst . '</td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </div>
        <!-- <div class="right-box" style="background-color: lightgoldenrodyellow;">
            <table>
                <tr>
                    <th>ID</th>
                    <th>ID_Ducan</th>
                    <th>ID_User</th>
                    <th>Ocjena</th>
                    <th>Tekst</th>
                </tr>
                < ?php
                    foreach( $recenzijeList as $recenzija )
                    {
                        echo '<tr>';
                        echo '<td>' . $recenzija->ID . '</td>';
                        echo '<td>' . $recenzija->ID_Ducan . '</td>';
                        echo '<td>' . $recenzija->ID_User . '</td>';
                        echo '<td>' . $recenzija->Ocjena . '</td>';
                        echo '<td>' . $recenzija->Tekst . '</td>';
                        echo '</tr>';
                    }
                ? >
            </table>
        </div> -->
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    let selectedRating = 0;

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
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>
