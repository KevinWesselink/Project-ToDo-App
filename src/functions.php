<?php
include "../database/db.php";

if (isset($_POST['insertTask'])) {
    $title = $_POST['title'];
    $description = $_POST["description"];
    $location = $_POST["location"];
    echo "Data array updated \n";

    //Check of de titel en omschrijving al bestaan
    $resultTitleDupeCheck = $conn->query("SELECT title FROM todoapp WHERE title = '$title'");
    $resultDescriptionDupeCheck = $conn->query("SELECT description FROM todoapp WHERE description = '$description'");

    if ($resultTitleDupeCheck->rowCount() == 0 && $resultDescriptionDupeCheck->rowCount() == 0) {
        //Data in de database stoppen
        $query = "insert into todoapp (`title`, `description`, `location`) values (:title, :description, :location)";

        $sth = $conn->prepare($query);
        $sth->bindParam(':title', $title);
        $sth->bindParam(':description', $description);
        $sth->bindParam(':location', $location);
        $sth->execute();
    } else {
        echo "Error: Deze titel of omschrijving bestaat al.";
    }
}

if (isset($_POST['editTask'])) {

}

if (isset($_POST['completeTask'])) {
    //Als task wordt gecomplete, INSERT date_completed INTO date_completed
}

if (isset($_POST['deleteTask'])) {
    $id = $_POST['modal_taskId'];
    $sth = $conn->prepare("DELETE FROM todoapp WHERE id = :id");
    $sth->bindParam(':id', $id);
    $sth->execute();

    header("Location:index.php");
}

function getTodo() {
    global $conn;
    //Data uit de database ophalen
    $query = "SELECT id, title, description, location, date_created, date_completed FROM todoapp";
    $sth = $conn->prepare($query);

    $sth->execute();
    //Geeft data weer in een associatieve array (data wordt niet opgehaald via indexes, maar via namen)
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    $createdOn = date("Y-m-d H:i:s");

    //Toon de data uit de array
    $teller = 1;
    foreach ($result as $row) {
        echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td><span id='title_" . $teller . "'>" . $row['title'] . "</span></td>
                    <td><span id='description_" . $teller . "'>" . $row['description'] . "</span></td>
                    <td><span id='location_" . $teller . "'>" . $row['location'] . "</span></td>
                    <td>" . $row['date_created'] . "</td>
                    <td>" . $row['date_completed'] . "</td>
                    <td>
                        <input type='image' src='../images/BalPen.jpg' alt='' value='edit' name='balpen' class='icons' onclick='modal(1, " . $teller . ")'>
                        <input type='image' src='../images/Vinkje.jpg' alt='' value='complete' name='vinkje' class='icons' onclick='modal(2, " . $teller . ")'>
                        <input type='image' src='../images/Prullenbak.jpg' alt='' value='delete' name='prullenbak' class='icons' onclick='modal(3, ". $teller .", ". $row['id'] .")'>
                    </td>
                </tr>";
        $teller++;
    }
}
?>