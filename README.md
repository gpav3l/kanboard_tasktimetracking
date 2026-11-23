# TaskTimeTracking

TaskTimeTracking is a Kanboard plugin that adds a simple start/stop timer to
the task sidebar. Starting a timer records the current user and timestamp;
stopping it calculates the elapsed time and adds the result to the task's
`time_spent` field in hours.

## Features

- Start and stop a timer from the task sidebar.
- Display when the current timer started.
- Show total tracked time for the task in `HH:MM:SS` format.
- Store timer history in the `task_time_tracking` table.
- Automatically disable starting a timer on tasks that contain subtasks.
- Support MySQL, PostgreSQL, and SQLite databases.

## Requirements

- Kanboard `>=1.2.57`
- PHP and database requirements supported by Kanboard

## Installation

1. Copy this directory into the Kanboard installation as
   `plugins/TaskTimeTracking`.
2. Make sure the directory and PHP files are readable by the Kanboard web
   server.
3. Open Kanboard. The plugin creates the `task_time_tracking` table
   automatically during installation/upgrade.
4. Open any task. The **Time tracking** section appears in the task sidebar.

Example directory layout:

```text
kanboard/
└── plugins/
    └── TaskTimeTracking/
        ├── Plugin.php
        ├── Controller/
        ├── Helper/
        ├── Model/
        ├── Schema/
        └── Template/
```

## Usage

- Select **Start timer** to begin tracking time for the current user and task.
- The sidebar shows **Running since** while the timer is active.
- Select **Stop timer** to finish the session. The elapsed duration is added
  to Kanboard's task **Time spent** value and the session becomes part of
  **Total tracked**.
- A timer cannot be started when the task has subtasks; the sidebar displays
  this restriction and disables the start button.
- Starting an already-running timer or stopping a timer that is not active
  displays a failure message and leaves the task unchanged.

Each user has their own active timer for each task, and only completed
sessions contribute to the task's total tracked time. The plugin records the
elapsed time in hours when a timer stops.

## Data model

The plugin adds the `task_time_tracking` table:

| Column | Description |
| --- | --- |
| `id` | Primary key |
| `task_id` | Kanboard task ID |
| `user_id` | User who started the timer |
| `start` | Unix timestamp for timer start |
| `end` | Unix timestamp for timer end; `NULL` while running |

Database-specific migrations live in `Schema/Sqlite.php`,
`Schema/Mysql.php`, and `Schema/Postgres.php`.

## Updating

Replace the existing `plugins/TaskTimeTracking` directory with the new
version and reload Kanboard. Preserve the `task_time_tracking` table and its
data during upgrades.

## License

MIT — see [LICENSE](LICENSE).
