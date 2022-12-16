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

function deleteTask() {
    //Eerst deze functie afmaken
    global $conn;
    $query = "DELETE FROM todoapp WHERE id = :id";
    $sth = $conn->prepare($query);
    $sth->bindParam(':id', $id);
    $sth->execute();
}


/*
function modal(value){

    if (value == 'edit') {
        ?>
        <button data-modal-target="#modal" class="newTaskButton">+ Nieuwe taak</button>
        <div id="modal" class="modal">
            <div class="modalHeader">
                <div class="title">Taak aanpassen</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <h2>Pas de taak aan</h2>
                <button class="submit" onclick="editTask()">Aanpassen</button>
                <button data-close-button class="cancel">Annuleer</button>
            </div>
        </div>
        <div id="overlay"></div>
        <?php
    } else if (value == 'delete') {
        ?>
        <button data-modal-target="#modal" class="newTaskButton">+ Nieuwe taak</button>
        <div id="modal" class="modal">
            <div class="modalHeader">
                <div class="title">Taak verwijderen</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <h2>Weet je zeker dat je de taak wil verwijderen?</h2>
                <button class="submit" onclick="deleteTask()">Ik weet het zeker</button>
                <button data-close-button class="cancel">Annuleer</button>
            </div>
        </div>
        <div id="overlay"></div>
        <?php
    } else  {
        ?>
        <button data-modal-target="#modal" class="newTaskButton">+ Nieuwe taak</button>
        <div id="modal" class="modal">
            <div class="modalHeader">
                <div class="title">Taak afronden</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <h2>Weet je zeker dat je de taak wil afronden?</h2>
                <button class="submit" onclick="completeTask()">Ik weet het zeker</button>
                <button data-close-button class="cancel">Annuleer</button>
            </div>
        </div>
        <div id="overlay"></div>
        <?php
    }
}
*/

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