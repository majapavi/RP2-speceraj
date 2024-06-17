<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Naziv</th>
        <th>Prosjek</th>
    </tr>
    <?php
        foreach( $ducaniList as $ducan )
        {
            echo '<tr>';
            echo '<td>' . $ducan->ID . '</td>';
            echo '<td>' . $ducan->Naziv . '</td>';
            echo '<td>' . $ducan->Prosjek . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>
