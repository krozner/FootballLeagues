DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS league;

TRUNCATE TABLE user;
INSERT INTO user (username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, first_name, last_name) VALUES ('test', 'test', 'test', 'test', 1, null, '$2y$13$xzHopDrK.Fb8JW6yua4uF.6vs8y9JkSRbQM1Pq/XCuLs6YwHNLv1y', null, null, null, 'a:0:{}', null, null);

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


