<main>
      <nav class="nav">
          <?= $menu_lot; ?>
      </nav>
      <div class="container">
          <section class="lots">
              <?php if (!empty($result_search)): ?>
              <h2>Все лоты в категории «<span><?= $name_category_lot; ?></span>»</h2>

              <?php foreach ($result_search as $value): ?>

              <ul class="lots__list">
                  <li class="lots__item lot">
                      <div class="lot__image">
                          <img src="<?= $value['photo']; ?>" width="350" height="260" alt="<?= $value['name']; ?>>">
                      </div>
                      <div class="lot__info">
                          <span class="lot__category"><?= $value['name']; ?></span>
                          <h3 class="lot__title"><a class="text-link" href="lot.html"><?= $value['lot_name']; ?></a></h3>
                          <div class="lot__state">
                              <div class="lot__rate">
                                  <span class="lot__amount">Стартовая цена</span>
                                  <span class="lot__cost"><?= $value['cost_start']; ?><b class="rub">р</b></span>
                              </div>
                              <?php $time_limited = countTime($value['date_finished']); ?>
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
              </ul>

              <?php endforeach; ?>
              <?php else: ?>
                  <h2>Ничего не найдено по вашему запросу</h2>
              <?php endif; ?>

          </section>
          <ul class="pagination-list">
              <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
              <li class="pagination-item pagination-item-active"><a>1</a></li>
              <li class="pagination-item"><a href="#">2</a></li>
              <li class="pagination-item"><a href="#">3</a></li>
              <li class="pagination-item"><a href="#">4</a></li>
              <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
          </ul>
      </div>
  </main>



