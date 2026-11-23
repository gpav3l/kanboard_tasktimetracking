<?php

namespace Kanboard\Plugin\TaskTimeTracking\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE task_time_tracking (
        id INT NOT NULL AUTO_INCREMENT SERIAL PRIMARY KEY,
        task_id INT NOT NULL,
        user_id INT NOT NULL,
        start INT NOT NULL,
        end INT NULL,
        FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE,
               FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB CHARSET=utf8');
}
