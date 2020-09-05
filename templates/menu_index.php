<ul class="promo__list">
    <!--заполните этот список из массива категорий-->

    <?php $j = 0; ?>
    <?php while ($j < count($categories)): ?>
        <li class="promo__item promo__item--<?= $categories[$j]['symbol_code']; ?>">
            <a class="promo__link" href="/lots_by_categories.php?id_category_lot=<?= $categories[$j]['id']; ?>"><?= $categories[$j]['name']; ?></a>
        </li>
        <?php $j++; ?>
    <?php endwhile; ?>
</ul>
