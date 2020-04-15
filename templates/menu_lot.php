<ul class="nav__list container">
    <?php $i = 0; ?>
    <?php while ($i < count($categories)): ?>
        <li class="nav__item">
            <a href="all-lots.html"><?= $categories[$i]['name']; ?></a>
        </li>
        <?php $i++; ?>
    <?php endwhile; ?>

</ul>
