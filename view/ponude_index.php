<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>ID</th>
        <th>ID_Proizvod</th>
        <th>ID_Ducan</th>
        <th>Cijena</th>
        <th>Akcija</th>
    </tr>
    <?php
        foreach( $ponudeList as $ponuda )
        {
            echo '<tr>';
            echo '<td>' . $ponuda->ID . '</td>';
            echo '<td>' . $ponuda->ID_Proizvod . '</td>';
            echo '<td>' . $ponuda->ID_Ducan . '</td>';
            echo '<td>' . $ponuda->Cijena . '</td>';
            echo '<td>' . $ponuda->Akcija . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>
