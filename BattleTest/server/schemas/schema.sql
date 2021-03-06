DROP DATABASE IF EXISTS jeremy_game;

CREATE DATABASE jeremy_game;

USE jeremy_game;

CREATE TABLE game_user (
    user_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_party (
    party_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT(11),
    party_name VARCHAR(255),
    gold INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_stat (
    stat_id VARCHAR(255),
    stat_name VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_race (
    race_id INT(11) NOT NULL PRIMARY KEY,
    race_name VARCHAR(255),
    base_hp INT(11),
    base_mp INT(11),
    base_str INT(11),
    base_agl INT(11),
    base_mag INT(11),
    base_sta INT(11),
    base_move INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_job_class (
    job_class_id INT(11) NOT NULL PRIMARY KEY,
    job_class_name VARCHAR(255),
    mod_hp INT(11),
    mod_mp INT(11),
    mod_str INT(11),
    mod_agl INT(11),
    mod_mag INT(11),
    mod_sta INT(11),
    mod_move INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_skill (
    skill_id INT(11) NOT NULL PRIMARY KEY,
    job_class_id INT(11),
    skill_name VARCHAR(255),
    job_point_cost INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_unit (
    unit_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT(11),
    party_id INT(11),
    race_id INT(11),
    unit_name VARCHAR(255),
    job_class_id INT(11),
    status VARCHAR(255),
    max_hp INT(11),
    max_mp INT(11),
    max_str INT(11),
    max_agl INT(11),
    max_mag INT(11),
    max_sta INT(11),
    max_pow INT(11),
    max_def INT(11),
    max_acc INT(11),
    max_evd INT(11),
    max_move INT(11),
    max_range INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_unit_job_class (
    unit_job_class_id INT(11) NOT NULL PRIMARY KEY,
    unit_id INT(11),
    job_class_id INT(11),
    job_points INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_unit_skill (
    unit_skill_id INT(11) NOT NULL PRIMARY KEY,
    unit_id INT(11),
    skill_id INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item_class (
    item_class_id INT(11) NOT NULL PRIMARY KEY,
    item_class_name VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item_type (
    item_type_id INT(11) NOT NULL PRIMARY KEY,
    item_class_id INT(11),
    item_type_name VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_element (
    element_id INT(11) NOT NULL PRIMARY KEY,
    element_name VARCHAR(255),
    weak_id INT(11),
    stat VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_buff (
    buff_id INT(11) NOT NULL PRIMARY KEY,
    buff_name VARCHAR(255),
    buff_formula VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_status_effect (
    status_effect_id INT(11) NOT NULL PRIMARY KEY,
    status_effect_name VARCHAR(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item_material (
    item_material_id INT(11) NOT NULL PRIMARY KEY,
    item_material_name VARCHAR(255),
    mod_pow INT(11),
    mod_def INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item_quality (
    item_quality_id INT(11) NOT NULL PRIMARY KEY,
    item_quality_name VARCHAR(255),
    multiplier DECIMAL(11,5)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item_type_material (
    item_type_material_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    item_type_id INT(11),
    item_material_id INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item (
    item_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    item_class_id INT(11),
    item_type_id INT(11),
    user_id INT(11),
    party_id INT(11),
    material_id INT(11),
    quality_id INT(11),
    item_name VARCHAR(255),
    _pow INT(11),
    _def INT(11),
    _acc INT(11),
    _evd INT(11),
    mod_range INT(11),
    mod_move INT(11),
    mod_hp INT(11),
    mod_mp INT(11),
    mod_str INT(11),
    mod_agl INT(11),
    mod_mag INT(11),
    mod_sta INT(11),
    price INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item_buff (
    item_buff_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    buff_id INT(11),
    item_id INT(11),
    stat_id INT(11),
    element_id INT(11),
    status_effect_id INT(11),
    multiplier DECIMAL(11, 5)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_race_buff (
    race_buff_id INT(11) NOT NULL PRIMARY KEY,
    race_id INT(11),
    buff_id INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_item_type_job_class (
    item_job_class_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    item_type_id INT(11),
    job_class_id INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_unit_item (
    unit_item_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    unit_id INT(11),
    item_id INT(11),
    item_class_id INT(11),
    UNIQUE KEY unit_item_class (unit_id, item_class_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE game_unit_status (
    unit_status_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    unit_id INT(11),
    status_id INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO game_stat (stat_id, stat_name) VALUES
("hp", "Health"),
("mp", "Mana"),
("str", "Strength"),
("agl", "Agility"),
("mag", "Magic"),
("sta", "Stamina"),
("pow", "Power"),
("def", "Defence"),
("acc", "Accuracy"),
("evd", "Evade"),
("move", "Move"),
("range", "Range");

INSERT INTO game_race (race_id, race_name, base_hp, base_mp, base_str, base_agl, base_mag, base_sta, base_move) VALUES
(1, "Human", 100, 50, 5, 5, 5, 5, 3),
(2, "Elf", 80, 80, 5, 10, 10, 5, 3);

INSERT INTO game_job_class (job_class_id, job_class_name, mod_hp, mod_mp, mod_str, mod_agl, mod_mag, mod_sta, mod_move) VALUES
(1, "Squire", 50, 0, 2, 2, 0, 2, 0);

INSERT INTO game_skill (skill_id, job_class_id, skill_name, job_point_cost) VALUES
(1, 1, "Dash", 100);

INSERT INTO game_item_class (item_class_id, item_class_name) VALUES
(1, "Left Hand"),
(2, "Right Hand"),
(3, "Both Hands"),
(4, "Head"),
(5, "Body"),
(6, "Accessory");

INSERT INTO game_item_type (item_type_id, item_class_id, item_type_name) VALUES
(1, 1, "Sword"),
(2, 2, "Shield"),
(3, 3, "Bow"),
(4, 4, "Helmet"),
(5, 5, "Armor"),
(6, 6, "Ring");

INSERT INTO game_element (element_id, element_name, weak_id, stat) VALUES
(1, "Fire", 2, "str"),
(2, "Water", 3, "sta"),
(3, "Lightning", 2, "agl"),
(4, "Air", NULL, "move"),
(5, "Ice", 1, "sta"),
(6, "Light", 7, "acc"),
(7, "Dark", 6, "evd"),
(8, "Poison", NULL, NULL);

INSERT INTO game_item_material (item_material_id, item_material_name, mod_pow, mod_def) VALUES
(1, "Cloth", 0, 1),
(2, "Wood", 1, 3),
(3, "Iron", 2, 4),
(4, "Leather", 0, 2),
(5, "Bronze", 2, 5),
(6, "Silver", 4, 6),
(7, "Gold", 6, 8),
(8, "Diamond", 7, 10),
(9, "Crystal", 8, 12),
(10, "Dragon", 10, 14),
(11, "Adamantium", 12, 16),
(12, "Angelic", 15, 20);

INSERT INTO game_item_quality (item_quality_id, item_quality_name, multiplier) VALUES
(1, "Decent", 1),
(2, "Durable", 1.1),
(3, "Poor", 0.8),
(4, "Flimsy", 0.6);

INSERT INTO game_item_type_material (item_type_id, item_material_id) VALUES
(1, 2),(1,3),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),
(2, 2),(2,5),(2,6),(2,7),(2,8),(2,9),(2,10),(2,11),(2,12);

INSERT INTO game_buff (buff_id, buff_name, buff_formula) VALUES
(1, "Added", "stat * multiplier");

INSERT INTO game_status_effect (status_effect_id, status_effect_name) VALUES
(1, "Sleep");