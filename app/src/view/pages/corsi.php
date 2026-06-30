<a href="/corsi/create">Nuovo</a>

<ul>
<?php foreach ($corsi as $corsiItem): ?>
    <li>
        <?= $corsiItem->id ?>
        <a href="/corsi/edit/<?= $corsiItem->id ?>">Edit</a>
        <a href="/corsi/delete/<?= $corsiItem->id ?>">Delete</a>
    </li>
<?php endforeach; ?>
</ul>
