To-Do App (Task_2)

Files:
- `db.php` - shared DB connection used by the app (root folder)
- `Task_2/index.php` - single-page app: add tasks and view tasks. Uses PRG to avoid duplicate POSTs.
- `Task_2/app.js` - small client-side validation.
- `Task_2/styles.css` - small styles.

Database setup:
Run this SQL in `web_app` database (use phpMyAdmin or MySQL CLI):

CREATE TABLE `tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `description` VARCHAR(255) NOT NULL
);

How to run:
1. Ensure XAMPP Apache & MySQL are running.
2. Place project in `htdocs` (already done).
3. Visit: http://localhost/ADVANCE%20PROGRAMMING%20PROJECT/Task_2/index.php

Notes:
- PRG (Post/Redirect/Get) is used to prevent duplicate inserts on refresh.
- The app uses `db.php` in the parent folder for the MySQL connection.
