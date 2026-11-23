<?php

namespace Kanboard\Plugin\TaskTimeTracking\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE task_time_tracking (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        task_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        start INTEGER NOT NULL,
        end INTEGER NULL,
        FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE,
               FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    )');
}
