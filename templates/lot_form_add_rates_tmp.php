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
                    
                
