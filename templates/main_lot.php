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
                
                    <form class="lot-item__form" action="/lot.php?id=<?= $_GET['id'] ?>" method="post" autocomplete="off">
                        <p class="lot-item__form-item form__item form__item--invalid">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?= $item_lot[0]['step_cost']; ?>">
                            <span class="form__error"><?=$errors['cost'] ?? ""; ?></span>
                        </p>
                        <button type="submit" class="button" name="submit" value="1">Сделать ставку</button>
                    </form>
                    
                </div>
                <div class="history">
                    <h3>История ставок (<span>10</span>)</h3>
                    <table class="history__list">
                        <tr class="history__item">
                            <td class="history__name">Иван</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">5 минут назад</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Константин</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">20 минут назад</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Евгений</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">Час назад</td>
                        </tr>
                        <tr class="history__item">
                            <td class="history__name">Игорь</td>
                            <td class="history__price">10 999 р</td>
                            <td class="history__time">19.03.17 в 08:21</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
</section>
