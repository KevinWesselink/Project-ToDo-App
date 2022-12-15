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

function getTodo()
{
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
                </tr>";
    }
}


?>