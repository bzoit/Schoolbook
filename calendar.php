<?php
    require('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GA Digital Planner</title>
  <link rel="stylesheet" href="calendar.css">
  <link rel="icon" href="img/iconCal.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anek+Telugu:wght@300&display=swap" rel="stylesheet">
</head>
<body>
  <div id="headerCntr">
    <img src="img/menu.png" id="menuBtn" alt="Open menu button" onclick="openNav()"/>
  </div>
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Add to Planner</a>
    <a href="calendar.php">View Planner</a>
    <a href="schedule.html">View Schedule</a>
    <p id="subList">Helpful Links</p>
    <ul id="subNav">
      <li><a href="https://docs.google.com/spreadsheets/d/1q8iJtieIyEleBNDLJW209wmfL-ei64UVl0Hw4GcMsnc/edit#gid=0">Zoom Links</a></li>
      <li><a href="https://www.germantownacademy.net/">GA Website</a></li>
      <li><a href="https://accounts.veracross.com/gapatriots/portals/login">Veracross</a></li>
      <li><a href="files/Middle%20School%20Handbook%202022-2023.pdf">Student Handbook</a></li>
    </ul>
  </div>
  <div id="calendarCntr">
    <div class="month">
      <ul>
        <li class="prev">&#10094;</li>
        <li class="next">&#10095;</li>
        <li>
          <p id="month"></p><br>
          <span id="year" style="font-size:18px"></span>
        </li>
      </ul>
    </div>

    <ul class="weekdays">
      <li>Mon</li>
      <li>Tue</li>
      <li>Wed</li>
      <li>Thu</li>
      <li>Fri</li>
      <li>Sat</li>
      <li>Sun</li>
    </ul>

    <ul id="days">
      <li><span class="day">1</span></li>
      <li><span class="day">2</span></li>
      <li><span class="day">3</span></li>
      <li><span class="day">4</span></li>
      <li><span class="day">5</span></li>
      <li><span class="day">6</span></li>
      <li><span class="day">7</span></li>
      <li><span class="day">8</span></li>
      <li><span class="day">9</span></li>
      <li><span class="day">10</span></li>
      <li><span class="day">11</span></li>
      <li><span class="day">12</span></li>
      <li><span class="day">13</span></li>
      <li><span class="day">14</span></li>
      <li><span class="day">15</span></li>
      <li><span class="day">16</span></li>
      <li><span class="day">17</span></li>
      <li><span class="day">18</span></li>
      <li><span class="day">19</span></li>
      <li><span class="day">20</span></li>
      <li><span class="day">21</span></li>
      <li><span class="day">22</span></li>
      <li><span class="day">23</span></li>
      <li><span class="day">24</span></li>
      <li><span class="day">25</span></li>
      <li><span class="day">26</span></li>
      <li><span class="day">27</span></li>
      <li><span class="day">28</span></li>
      <li><span class="day" id="29">29</span></li>
      <li><span class="day" id="30">30</span></li>
      <li><span class="day" id="31">31</span></li>
    </ul>
  </div>
  <?php
      if($_REQUEST) {
          $d = $_REQUEST["d"];
          $m = $_REQUEST["m"];
          $y = $_REQUEST["y"];

          $date = $m . "/" . $d . "/" . $y;

          if(!empty($connection)) {
              $query = $connection->prepare("SELECT * FROM events WHERE date = :date");
              $query->bindParam(":date", $date, PDO::PARAM_STR);
              $query->execute();
              if ($query->rowCount() > 0) {
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                      print_r('<div class="event"><h2 class="eventHeader">' . $row["class"] . ' ' . $row["type"] . ':</h2><h2 class="eventTitle">' . $row["name"] . '</h2></div>');
                  }
              }
          }
      }
  ?>
  <script src="main.js"></script>
  <script src="cal.js"></script>
</body>
</html>