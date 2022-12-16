<?php

if (isset($_POST['Opslaan'])) {
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

function editTask() {
    //Functie pas aanmaken als deleteTask() werkt
    global $conn;
}

function completeTask() {
    //Functie pas aanmaken als editTask() werkt
    global $conn;
}

if (isset($_POST['Verwijder taak'])) {
    global $conn;
    $title = $_POST['title'];
    $description = $_POST["description"];
    $location = $_POST["location"];

    $query = "DELETE FROM todoapp WHERE title = '$title' AND description = '$description' AND location = '$location'";
    $sth = $conn->prepare($query);
    $sth->execute();
}

function getTodo() {
    global $conn;
    //Data uit de database ophalen
    $query = "SELECT id, title, description, location FROM todoapp";
    $sth = $conn->prepare($query);

    $sth->execute();
    //Geeft data weer in een associatieve array (data wordt niet opgehaald via indexes, maar via namen)
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    $createdOn = date("Y-m-d H:i:s");

    //Toon de data uit de array
    foreach ($result as $row) {
        echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['location'] . "</td>
                    <td></td>
                    <td></td>
                    <td>
                        <input type='image' src='../images/BalPen.jpg' alt='' value='edit' name='balpen' class='icons' onclick='modal(1)'>
                        <input type='image' src='../images/Vinkje.jpg' alt='' value='complete' name='vinkje' class='icons' onclick='modal(2)'>
                        <input type='image' src='../images/Prullenbak.jpg' alt='' value='delete' name='prullenbak' class='icons' onclick='modal(3)'>
                    </td>
                </tr>";
    }
}
?>