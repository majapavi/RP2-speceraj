<?php require_once __DIR__ . '/_header.php'; ?>

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

<?php require_once __DIR__ . '/_footer.php'; ?>
