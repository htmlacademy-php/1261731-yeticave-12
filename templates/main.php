<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
            снаряжение.</p>

        <?= $menu_category; ?>

    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($lots as $key => $value): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $value['photo']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $value['category']; ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= $value['id']; ?>"><?= $value['name']; ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><b><?= cost($value['cost_start']); ?>&#8381;</b></span>
                            </div>
                            <?php $time_limited = countTime($value['expiration_time']); ?>
                            <?php if ($time_limited[0] <= 0): ?>
                            <div class="lot__timer timer timer--finishing">
                                <?php else: ?>
                                <div class="lot__timer timer">
                                    <?php endif; ?>
                                    <?= $time_limited[0]; ?> : <?= $time_limited[1]; ?>
                                </div>
                            </div>
                        </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>
