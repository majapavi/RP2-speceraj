<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Naziv</th>
        <th>Opis</th>
        <th>Link na sliku</th>
        <th>Korak</th>
    </tr>
    <?php
        foreach( $proizvodiList as $proizvod )
        {
            echo '<tr>';
            echo '<td>' . $proizvod->ID . '</td>';
            echo '<td>' . $proizvod->Naziv . '</td>';
            echo '<td>' . $proizvod->Opis . '</td>';
            echo '<td>' . $proizvod->Link . '</td>';
            echo '<td>' . $proizvod->Korak . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>
