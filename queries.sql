INSERT INTO Categories VALUES
    (NULL, 'Доски и лыжи', 'boards'),
    (NULL, 'Крепления', 'attachment'),
    (NULL, 'Ботинки', 'boots'),
    (NULL, 'Одежда', 'clothing'),
    (NULL, 'Инструменты', 'tools'),
    (NULL, 'Разное', 'others');
INSERT INTO Users VALUES
    (NULL, 'Ivan', 'ivan@mail.ru', '123', '112233', now()),
    (NULL, 'Anna', 'anna@yandex.ru', '4455', '68jkjk', now()),
    (NULL, 'Elena', 'elena@gmail.ru', '8877', 'kjlos', now());
INSERT INTO Lots VALUES
    (NULL, 1, 1, NULL, '2014 Rossignol District Snowboard', 'JJSSSWEE', 10999, 10, 'img/lot-1.jpg', now(), '2020-04-01'),
    (NULL, 2, 1, NULL, 'DC Ply Mens 2016/2017 Snowboard0', 'EDFIN', 159999, 20, 'img/lot-2.jpg', now(), '2020-10-20'),
    (NULL, 3, 2, NULL, 'Крепления Union Contact Pro 2015 года размер L/XL', 'UEUWUQS', 8000, 10, 'img/lot-3.jpg', now(), '2020-04-30'),
    (NULL, 1, 3, NULL, 'Ботинки для сноуборда DC Mutiny Charocal', 'uuusssxx', 10999, 30, 'img/lot-4.jpg', now(), '2020-08-20'),
    (NULL, 3, 4, NULL, 'Куртка для сноуборда DC Mutiny Charocal', 'eewwssw', 7500, 30, 'img/lot-5.jpg', now(), '2020-09-21'),
    (NULL, 2, 6, NULL, 'Маска Oakley Canopy', 'eedewse', 5400, 5, 'img/lot-6.jpg', now(), '2020-07-20');
INSERT INTO Rates VALUES
    (NULL, 2, 1, 11000, now()),
    (NULL, 3, 2, 170000, now()),
    (NULL, 2, 1, 12000, now());

    /* получить все категории */
    SELECT * FROM Categories;
    /*получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую
    цену, ссылку на изображение, текущую цену, название категории */
    SELECT Categories.name, Lots.name, cost_start, photo, cost FROM Lots
    INNER JOIN Categories ON Lots.category_id=Categories.id
    LEFT JOIN Rates ON Rates.lot_id=Lots.id
    ORDER BY Lots.id DESC LIMIT 3;
    /*показать лот по его id. Получите также название категории, к которой принадлежит лот*/
    SELECT Lots.*, Categories.name FROM Lots INNER JOIN Categories ON Lots.category_id=Categories.id AND Losts.id=1;
    /*обновить название лота по его идентификатору*/
    UPDATE Lots SET detail='update info' WHERE id=6;
    /*получить список ставок для лота по его идентификатору с сортировкой по дате.*/
    SELECT * FROM Rates WHERE lot_id=1 ORDER BY date_create ASC;
    /*вложенный запрос*/
    SELECT name FROM lots WHERE id=(SELECT lot_id FROM rates WHERE user_id=2 ORDER BY cost DESC LIMIT 1);

