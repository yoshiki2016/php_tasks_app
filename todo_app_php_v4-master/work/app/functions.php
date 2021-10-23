<?php

function addTodos($pdo)
{
  $title = trim(filter_input(INPUT_POST, 'title'));
  if ($title === '') {
    return;
  }

  $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
  $stmt->bindValue('title', $title, PDO::PARAM_STR);
  $stmt->execute();
}

function toggleTodos($pdo)
{
  $id = filter_input(INPUT_POST, 'id');
  if ( empty( $id ) ) {
    return;
  }

  $stmt = $pdo->prepare("Update todos Set is_done = Not is_done Where id = :id");
  $stmt->bindValue('id', $id, PDO::PARAM_INT);
  $stmt->execute();
}

function deleteTodos($pdo)
{
  $id = filter_input(INPUT_POST, 'id');
  if ( empty( $id ) ) {
    return;
  }

  $stmt = $pdo->prepare("Delete From todos Where id = :id");
  $stmt->bindValue('id', $id, PDO::PARAM_INT);
  $stmt->execute();
}

function getTodos($pdo)
{
  $stmt = $pdo->query("Select * From todos Order By id Desc");
  $todos = $stmt->fetchAll();
  return $todos;
}
