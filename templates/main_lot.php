<nav class="nav">
    <?= $menu_lot; ?>
</nav>
<section class="lot-item container">
    <h2><?= $item_lot['lot_name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $item_lot['photo']; ?>" width="730" height="548" alt="<?= $item_lot['lot_name']; ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $item_lot['category']; ?></span></p>
            <p class="lot-item__description"><?= $item_lot['detail']; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <?php if ($time_limited[0] <= 0): ?>
                <div class="lot__timer timer--finishing">
                    <?php else: ?>
                    <div class="lot__timer timer">
                        <?php endif; ?>
                        <?= $time_limited[0]; ?> : <?= $time_limited[1]; ?>
                    </div>
                    </div>
                    <?= $lot_form_add_rates_tmp; ?>
                        
                <?= $history_lot; ?>
            </div>
        </div>
</section>
