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

                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $cost_current; ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= $item_lot['step_cost']; ?></span>
                        </div>
                    </div>

                    <form class="lot-item__form" action="/lot.php?id=<?= $_GET['id'] ?>" method="post" autocomplete="off">
                        <p class="lot-item__form-item form__item form__item--invalid">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?= $item_lot['step_cost']; ?>">
                            <span class="form__error"><?=$errors['cost'] ?? ""; ?></span>
                        </p>
                        <button type="submit" class="button" name="submit" value="1">Сделать ставку</button>
                    </form>

                </div>
                <?= $history_lot; ?>
            </div>
        </div>
</section>
