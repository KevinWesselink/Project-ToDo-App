<?php
include "../database/db.php";

if (isset($_POST['insertTask'])) {
    $title = $_POST['title'];
    $description = $_POST["description"];
    $location = $_POST["location"];
    $createdOn = date("Y-m-d H:i:s");

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
    $completedOn = date("Y-m-d H:i:s");

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

function getToDo() {
    global $conn;
    //Data uit de database ophalen
    $query = "SELECT id, title, description, location, date_created, date_completed FROM todoapp";
    $sth = $conn->prepare($query);

    $sth->execute();
    //Geeft data weer in een associatieve array (data wordt niet opgehaald via indexes, maar via namen)
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    //Toon de data uit de array
    $teller = 1;
    foreach ($result as $row) {
        if ($row['date_completed'] == "") {
            $class = "tableBorder";
        } else {
            $class = "completed";
        }
        echo "<tr class='$class'>
                <td>" . $row['id'] . "</td>
                <td><span id='title_" . $teller . "'>" . $row['title'] . "</span></td>
                <td><span id='description_" . $teller . "'>" . $row['description'] . "</span></td>
                <td><span id='location_" . $teller . "'>" . $row['location'] . "</span></td>
                <td>" . $row['date_created'] . "</td>
                <td>" . $row['date_completed'] . "</td>
                <td>
                    <input type='image' src='../images/BalPen.jpg' alt='' value='edit' name='balpen' class='icons' ";
                    if ($row['date_completed'] == "") {
                        echo "onclick='prepareModal(1, " . $teller . ", " . $row['id'] . ")'";
                    }
                    echo ">
                    <input type='image' src='../images/Vinkje.jpg' alt='' value='complete' name='vinkje' class='icons' ";
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