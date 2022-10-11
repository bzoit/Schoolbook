<?php
    include('config.php');
    $formErr = "";

    if($_POST) {
        $name = $_POST["title"];
        $type = $_POST["type"];
        $class = $_POST["class"];
        $date = $_POST["date"];
        $m = date("m", strtotime($date));
        $d = date("d", strtotime($date));
        $y = date("Y", strtotime($date));
        $m = ltrim($m, '0');
        $d = ltrim($d, '0');
        $date = "$m/$d/$y";

        if(empty($name) || empty($date)) {
            $formErr = "All fields are required.";
        }

        if(strlen($name) >= 255) {
            $formErr = "Title must be less than 255 characters.";
        } else {
            if(empty($connection)) {
                $formErr = "Something went wrong! Please try again later.";
            } else {
                $query = $connection->prepare("SELECT * FROM events WHERE (name = :name) and (date = :date) and (type = :type) and (class = :class)");
                $query->bindParam("name", $name, PDO::PARAM_STR);
                $query->bindParam("type", $type, PDO::PARAM_STR);
                $query->bindParam("class", $class, PDO::PARAM_STR);
                $query->bindParam("date", $date, PDO::PARAM_STR);
                $query->execute();
                if ($query->rowCount() > 0) {
                    $formErr = "That event already exists.";
                } else {
                    $query = $connection->prepare("INSERT INTO events(name,type,class,date) VALUES (:name,:type,:class,:date)");
                    $query->bindParam("name", $name, PDO::PARAM_STR);
                    $query->bindParam("type", $type, PDO::PARAM_STR);
                    $query->bindParam("class", $class, PDO::PARAM_STR);
                    $query->bindParam("date", $date, PDO::PARAM_STR);
                    $result = $query->execute();
                    if ($result) {
                        header("Location: ./calendar.php");
                        die();
                    } else {
                        $formErr = "Something went wrong! Please try again later.";
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/iconCal.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Telugu:wght@300&display=swap" rel="stylesheet">
    <title>GA Digital Planner</title>
</head>
<body>
    <div id="headerCntr">
        <h1 id="header"></h1>
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
    <div id="formCntr">
        <form method="post">
            <span id="formErr"><?php echo $formErr?></span>
            <div>
                <label>
                    <input type="text" name="title" placeholder="Title">
                </label>
            </div>
            <div>
                <label>
                    <select name="type">
                        <option value="Test">Test</option>
                        <option value="Quiz">Quiz</option>
                        <option value="Essay">Essay</option>
                        <option value="Homework">Homework</option>
                        <option value="Project">Project</option>
                        <option value="Notes">Note</option>
                    </select>
                </label>
            </div>
            <div>
                <label>
                    <select name="class">
                        <option value="Advisory">Advisory</option>
                        <option value="English">English</option>
                        <option value="Math">Mathematics</option>
                        <option value="History">History</option>
                        <option value="Language">Language</option>
                        <option value="PE">PE</option>
                        <option value="Art">Art</option>
                        <option value="Music">Music</option>
                        <option value="Health">HealthWell</option>
                        <option value="Tech">Tech</option>
                        <option value="Drama">Drama</option>
                        <option value="Music">Music</option>
                        <option value="Science">Science</option>
                        <option value="Extracurricular">Extracurricular</option>
                    </select>
                </label>
            </div>
            <div>
                <label>
                    <input min="2022-08-31" max="2023-06-06" type="date" name="date">
                </label>
            </div>
            <div>
                <input type="submit" value="Add to Planner">
            </div>
        </form>
    </div>
    <script src="main.js"></script>
</body>
</html>