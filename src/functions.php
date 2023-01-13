<?php
include "../database/db.php";

if (isset($_POST['insertTask'])) {
    $title = $_POST['title'];
    $description = $_POST["description"];
    $location = $_POST["location"];
    $createdOn = date("H:i:s d-m-Y");

    //Check of de titel en omschrijving al bestaan
    $resultTitleDupeCheck = $conn->query("SELECT title FROM todoapp WHERE title = '$title'");
    $resultDescriptionDupeCheck = $conn->query("SELECT description FROM todoapp WHERE description = '$description'");

    if ($resultTitleDupeCheck->rowCount() == 0 && $resultDescriptionDupeCheck->rowCount() == 0) {
        //Data in de database stoppen
        $query = "INSERT INTO todoapp (`title`, `description`, `location`, `date_created`) VALUES (:title, :description, :location, :date_created)";

        $sth = $conn->prepare($query);
        $sth->bindParam(':title', $title);
        $sth->bindParam(':description', $description);
        $sth->bindParam(':location', $location);
        $sth->bindParam(':date_created', $createdOn);
        $sth->execute();
    } else {
        echo "Error: Deze titel of omschrijving bestaat al.";
    }
}

if (isset($_POST['editTask'])) {
    $id = $_POST['modal_taskId1'];
    $title = $_POST['title1'];
    $description = $_POST["description1"];
    $location = $_POST["location1"];

    $sth = $conn->prepare("UPDATE todoapp SET title = :title, description = :description, location = :location WHERE id = :id");
    $sth->bindParam(':id', $id);
    $sth->bindParam(':title', $title);
    $sth->bindParam(':description', $description);
    $sth->bindParam(':location', $location);
    $sth->execute();

    header("Location:index.php");
}

if (isset($_POST['completeTask'])) {
    $id = $_POST['modal_taskId'];
    $completedOn = date("H:i:s d-m-Y");

    $sth = $conn->prepare("UPDATE todoapp SET date_completed = :completedOn, completed = 1 WHERE id = :id");
    $sth->bindParam(':id', $id);
    $sth->bindParam(':completedOn', $completedOn);
    $sth->execute();

    header("Location:index.php");
}

if (isset($_POST['deleteTask'])) {
    $id = $_POST['modal_taskId'];
    $sth = $conn->prepare("DELETE FROM todoapp WHERE id = :id");
    $sth->bindParam(':id', $id);
    $sth->execute();

    header("Location:index.php");
}

function getTasks($completed) {
    global $conn;
    $teller = 1;
    if ($completed == 0) {
        $query = "SELECT id, title, description, location, date_created, date_completed FROM todoapp  WHERE date_completed IS NULL";
        $class = "tableBorder";
    } else {
        $countNotCompletedTasks = "SELECT count(*) AS amount FROM todoapp  WHERE date_completed IS NULL";
        $sth = $conn->prepare($countNotCompletedTasks);
        $sth->execute();
        $amount = $sth->fetch(PDO::FETCH_ASSOC);
        $teller =  $amount['amount'] + 1;
        $query = "SELECT id, title, description, location, date_created, date_completed FROM todoapp  WHERE date_completed IS NOT NULL";
        $class = "completed";
    }
    //Data uit de database ophalen
    $sth = $conn->prepare($query);

    $sth->execute();
    //Geeft data weer in een associatieve array (data wordt niet opgehaald via indexes, maar via namen)
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    //Toon de data uit de array
    foreach ($result as $row) {
        echo "<tr class='$class'>
                <td>" . $row['id'] . "</td>
                <td><span id='title_" . $teller . "'>" . $row['title'] . "</span></td>
                <td><span id='description_" . $teller . "'>" . $row['description'] . "</span></td>
                <td><span id='location_" . $teller . "'>" . $row['location'] . "</span></td>
                <td>" . $row['date_created'] . "</td>
                <td>" . $row['date_completed'] . "</td> ";
                 if ($row['date_completed'] == ""){
                     $class = "icons";
                 } else {
                     $class = "completedIcons";
                 }
                echo "<td>
                    <input type='image' src='../images/BalPen.jpg' alt='' value='edit' name='balpen' class='$class' ";
                    if ($row['date_completed'] == "") {
                        echo "onclick='prepareModal(1, " . $teller . ", " . $row['id'] . ")'";
                    }
                    echo ">
                    <input type='image' src='../images/Vinkje.jpg' alt='' value='complete' name='vinkje' class='$class' ";
                    if ($row['date_completed'] == "") {
                    echo "onclick='prepareModal(2, " . $teller . ", " . $row['id'] . ")'";
                    }
                    echo " >
                    <input type='image' src='../images/Prullenbak.jpg' alt='' value='delete' name='prullenbak' class='icons' onclick='prepareModal(3, " . $teller . ", " . $row['id'] . ")'>
                </td>
        </tr>";
        $teller++;
    }
}
?>