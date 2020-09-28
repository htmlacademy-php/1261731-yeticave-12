<ul class="pagination-list">
    <?php if (1 < $number_page) {  ?>
    <li class="pagination-item pagination-item-prev">
        <a href="/search.php?search=<?=$_GET['search']; ?>&page=<?= $number_page - 1; ?>&find=Найти">Назад</a></li>
    <?php } ?>
    <?php for ($j = 1; $j <= $amount_pages; $j++) { ?>  
    <?php if ($number_page == $j) {  ?>
    <li class="pagination-item pagination-item-active">
        <a><?= $j;?></a></li>
    <?php } else { ?>
    <li class="pagination-item">
        <a href="/search.php?search=<?=$_GET['search']; ?>&page=<?= $j;?>&find=Найти"><?= $j;?></a></li>
    <?php } ?>
    <?php } ?> 
    <?php if ($number_page < $amount_pages) { ?>            
    <li class="pagination-item pagination-item-next">
        <a href="/search.php?search=<?=$_GET['search']; ?>&page=<?= $number_page + 1; ?>&find=Найти">Вперед</a></li>
    <?php } ?>
</ul>