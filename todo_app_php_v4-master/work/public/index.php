<?php

define('DSN', 'mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'myappuser');
define('DB_PASS', 'myapppass');

try {
  $pdo = new PDO(
    DSN,
    DB_USER,
    DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );
} catch (PDOException $e) {
  echo $e->getMesage();
  exit;
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function getTodos($pdo)
{
  $stmt = $pdo->query("Select * From todos Order By id Desc");
  $todos = $stmt->fetchAll();
  return $todos;
}

$todos = getTodos($pdo);
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>My Todos</title>
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>
    <h1>Todos</h1>
    <ul>
      <?php foreach ($todos as $todo): ?>
        <li>
          <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
          <span class="<?= $todo->is_done ? 'done' : ''; ?>">
            <?= h($todo->title); ?>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
  </body>
</html>
