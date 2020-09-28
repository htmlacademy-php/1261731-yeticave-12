<ul class="nav__list container">
    <?php $i = 0; ?>
    <?php while ($i < count($categories)): ?>
        <li class="nav__item">
            <a href="./lots_by_categories.php?page=1&limit=9&id_category_lot=<?= $categories[$i]['id']; ?>"><?= $categories[$i]['name']; ?></a>
        </li>
        <?php $i++; ?>
    <?php endwhile; ?>

</ul>
