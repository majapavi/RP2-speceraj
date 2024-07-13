<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password_Hash</th>
    </tr>
    <?php
        foreach( $kupciList as $kupac )
        {
            echo '<tr>';
            echo '<td>' . $kupac->ID . '</td>';
            echo '<td>' . $kupac->Username . '</td>';
            echo '<td>' . $kupac->Password_Hash . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>
