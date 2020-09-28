CREATE TABLE Users (
    PRIMARY KEY (id),
    id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name              CHAR (50)    NOT NULL,
    email             CHAR (50)    NOT NULL,
    password          CHAR (100)   NOT NULL,
    contact           CHAR (255)   NOT NULL,
    date_registration DATETIME     NOT NULL,
                      UNIQUE (email)
);
CREATE INDEX password_idx ON Users (password);
CREATE TABLE Categories (
    PRIMARY KEY (id),
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        CHAR (50),
    symbol_code CHAR (50),
                UNIQUE (name),
                UNIQUE (symbol_code)
);
CREATE TABLE Rates (
    PRIMARY KEY (id),
    id          INT UNSIGNED          NOT NULL AUTO_INCREMENT,
    user_id     INT UNSIGNED          NOT NULL,
    lot_id      INT UNSIGNED          NOT NULL,
    cost        DECIMAL (12, 2)       NOT NULL,
    date_create DATETIME
);
CREATE TABLE Lots (
    PRIMARY KEY (id),
    id            INT UNSIGNED              NOT NULL AUTO_INCREMENT,
    user_id       INT UNSIGNED              NOT NULL,
    category_id   INT UNSIGNED              NOT NULL,
    winner_id     INT UNSIGNED,
    name          CHAR (255)                NOT NULL,
    detail        TEXT                      NOT NULL,
    cost_start    DECIMAL (12, 2)           NOT NULL,
    step_cost     DECIMAL (12, 2)           NOT NULL,
    photo         CHAR (255),
    date_create   DATETIME                  NOT NULL,
    date_finished DATETIME,
                  FOREIGN KEY (user_id)     REFERENCES Users (id),
                  FOREIGN KEY (category_id) REFERENCES Categories (id),
                  FOREIGN KEY (winner_id)   REFERENCES Users (id)
);
CREATE INDEX name_idx ON Lots (name);
ALTER TABLE Rates ADD FOREIGN KEY (user_id) REFERENCES Users (id);
ALTER TABLE Rates ADD FOREIGN KEY (lot_id) REFERENCES Lots (id);
CREATE FULLTEXT INDEX lots_search ON Lots(name, detail);





