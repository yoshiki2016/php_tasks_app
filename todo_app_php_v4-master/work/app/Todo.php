<?php

namespace MyApp;
use MyApp\Token;

class Todo
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
    Token::create();
  }

  public function processPost()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      Token::validate();
      $action = filter_input(INPUT_GET, 'action');
      switch ($action) {
        case 'add':
          $this->add();
          break;
        case 'toggle':
          $this->toggle();
          break;
        case 'delete':
          $this->delete();
          break;
        default:
          exit;
        }
      header('Location: SITE_URL');
      exit;
    }
  }

  public function getAll()
  {
    $stmt = $this->pdo->query("Select * From todos Order By id Desc");
    $todos = $stmt->fetchAll();
    return $todos;
  }

  private function add()
  {
    $title = trim(filter_input(INPUT_POST, 'title'));
    if ($title === '') {
      return;
    }

    $stmt = $this->pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
    $stmt->bindValue('title', $title, \PDO::PARAM_STR);
    $stmt->execute();
  }

  private function toggle()
  {
    $id = filter_input(INPUT_POST, 'id');
    if ( empty( $id ) ) {
      return;
    }

    $stmt = $this->pdo->prepare("Update todos Set is_done = Not is_done Where id = :id");
    $stmt->bindValue('id', $id, \PDO::PARAM_INT);
    $stmt->execute();
  }

  private function delete()
  {
    $id = filter_input(INPUT_POST, 'id');
    if ( empty( $id ) ) {
      return;
    }

    $stmt = $this->pdo->prepare("Delete From todos Where id = :id");
    $stmt->bindValue('id', $id, \PDO::PARAM_INT);
    $stmt->execute();
  }

}
