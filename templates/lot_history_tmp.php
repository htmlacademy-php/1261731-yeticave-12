<div class="history">
                    <h3>История ставок (<span><?= $count_rates_history; ?></span>)</h3>
                    <table class="history__list">
                                        <?php $i = 0; ?>
                <?php while ($i < count($rates_history)): ?>
                        
                        <tr class="history__item">
                            <td class="history__name"><?= $rates_history[$i]['name']; ?></td>
                            <td class="history__price"><?= $rates_history[$i]['cost']; ?> р</td>
                            <td class="history__time"><?= getReadableTime($rates_history[$i]['date_create']); ?></td>
                        </tr>
                        <?php $i++; ?>
                <?php endwhile; ?>
                    </table>
                </div>
                