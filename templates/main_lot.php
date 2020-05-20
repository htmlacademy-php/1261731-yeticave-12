<nav class="nav">
    <?= $menu_lot; ?>
</nav>
<section class="lot-item container">
    <h2><?= $item_lot[0]['name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $item_lot[0]['photo']; ?>" width="730" height="548" alt="<?= $item_lot[0]['name']; ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $item_lot[0]['category']; ?></span></p>
            <p class="lot-item__description"><?= $item_lot[0]['detail']; ?></p>
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

                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $item_lot[0]['cost']; ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= $item_lot[0]['step_cost']; ?></span>
                        </div>
                    </div>
                    <?= $form_lot; ?>
                </div>
                <?= $rate_history; ?>
            </div>
        </div>
</section>
