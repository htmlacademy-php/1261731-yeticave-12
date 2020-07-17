    <nav class="nav">
    <?= $menu_lot; ?>
    </nav>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">

      <?php foreach ($lots as $key => $value): ?>     
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $value['photo']; ?>" width="54" height="40" alt="Сноуборд">
            </div>
            <h3 class="rates__title"><a href="lot.php?id=<?= $value['id']; ?>"><?= $value['name']; ?></a></h3>
          </td>
          <td class="rates__category">
          <?= $value['category']; ?>
          </td>
          <td class="rates__timer">
          <?php $time_limited = countTime($value['expiration_time']); ?>
                  <?php if ($time_limited[0] <= 0): ?>
                      <div class="lot__timer timer timer--finishing">
                  <?php else: ?>
                      <div class="lot__timer timer">
                  <?php endif; ?>
                  <?= $time_limited[0]; ?> : <?= $time_limited[1]; ?>
                </div>
          </td>
          <td class="rates__price">
            10 999 р
          </td>
          <td class="rates__time">
            5 минут назад
          </td>
        </tr>       
        <?php endforeach; ?>

        <tr class="rates__item rates__item--win">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../img/rate3.jpg" width="54" height="40" alt="Крепления">
            </div>
            <div>
              <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
              <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
            </div>
          </td>
          <td class="rates__category">
            Крепления
          </td>
          <td class="rates__timer">
            <div class="timer timer--win">Ставка выиграла</div>
          </td>
          <td class="rates__price">
            10 999 р
          </td>
          <td class="rates__time">
            Час назад
          </td>
        </tr>

        <tr class="rates__item rates__item--end">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../img/rate5.jpg" width="54" height="40" alt="Куртка">
            </div>
            <h3 class="rates__title"><a href="lot.html">Куртка для сноуборда DC Mutiny Charocal</a></h3>
          </td>
          <td class="rates__category">
            Одежда
          </td>
          <td class="rates__timer">
            <div class="timer timer--end">Торги окончены</div>
          </td>
          <td class="rates__price">
            10 999 р
          </td>
          <td class="rates__time">
            Вчера, в 21:30
          </td>
        </tr>

              
      </table>
    </section>
  