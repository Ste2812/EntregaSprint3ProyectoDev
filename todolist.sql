DROP DATABASE IF EXISTS todolist;
CREATE DATABASE todolist CHARACTER SET utf8mb4;
USE todolist;

/* detalls tasques */
CREATE TABLE IF NOT EXISTS task (
	id INT UNSIGNED AUTO_INCREMENT,
    task_description VARCHAR(100) NOT NULL,
    date_time_start DATETIME NOT NULL,
    date_time_end DATETIME NOT NULL,
    task_state ENUM('Pending','On execution','Finished'),
    user_first_name VARCHAR(20) NOT NULL,
    user_last_name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;