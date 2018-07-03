DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS league;

CREATE TABLE league (
  `id`         INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(100) NOT NULL,
  `created_by` INT(11)      NOT NULL,
  CONSTRAINT fk_league_created_by FOREIGN KEY (created_by) REFERENCES user (user_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
);

INSERT INTO league (name, created_by) VALUES ('Premier League', 1);

CREATE TABLE team (
  `id`         INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(100) NOT NULL,
  `strip`      VARCHAR(255)     DEFAULT NULL,
  `league_id`  INTEGER UNSIGNED,
  `created_by` INT(11)      NOT NULL,
  CONSTRAINT fk_team_created_by FOREIGN KEY (created_by) REFERENCES user (user_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_team_league_id FOREIGN KEY (league_id) REFERENCES league (id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
);


