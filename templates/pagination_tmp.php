<ul class="pagination-list">
    <?php if (1 < $number_page) {  ?>
    <li class="pagination-item pagination-item-prev">
        <a href="/lots_by_categories.php?page=<?= $number_page - 1; ?>&limit=9&id_category_lot=<?= $id_category_lot ?>">Назад</a></li>
    <?php } ?>
    <?php for ($j = 1; $j <= $amount_pages; $j++) { ?>  
    <?php if ($number_page == $j) {  ?>
    <li class="pagination-item pagination-item-active">
        <a><?= $j;?></a></li>
    <?php } else { ?>
    <li class="pagination-item">
        <a href="/lots_by_categories.php?page=<?= $j;?>&limit=9&id_category_lot=<?= $id_category_lot ?>"><?= $j;?></a></li>
    <?php } ?>
    <?php } ?> 
    <?php if ($number_page < $amount_pages) { ?>            
    <li class="pagination-item pagination-item-next">
        <a href="/lots_by_categories.php?page=<?= $number_page + 1; ?>&limit=9&id_category_lot=<?= $id_category_lot ?>">Вперед</a></li>
    <?php } ?>
</ul>