<?php
  require('config.php');
  if($_REQUEST) {
      $date = $_REQUEST["date"];
      $subject = $_REQUEST["s"];
      $type = $_REQUEST["type"];
      $title = $_REQUEST["title"];

      if(!empty($connection)) {
          $query = $connection->prepare("DELETE FROM events WHERE (date = :date) and (class = :subject) and (type = :type) and (name = :title)");
          $query->bindParam(":date", $date, PDO::PARAM_STR);
          $query->bindParam(":subject", $subject, PDO::PARAM_STR);
          $query->bindParam(":type", $type, PDO::PARAM_STR);
          $query->bindParam(":title", $title, PDO::PARAM_STR);
          $query->execute();
      }
  }
?>