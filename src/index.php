<?php
include "../database/db.php";
include "../src/functions.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css?=v151220221613">
    <title>To Do App</title>
</head>
<body>
<div class="appHeader">
    <div class="headerText">
        ToDo, just another taskapp
    </div>
    <div class="headerButtonDiv">
        <button data-modal-target="#modal" class="newTaskButton">+ Nieuwe taak</button>
        <div id="modal" class="modal">
<!--            Nieuwe taak aanmaken-->
            <div class="modalHeader">
                <div class="title">Nieuwe taak aanmaken</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <form name="insertData" method="post">
                    <div>
                        <label for="title">Titel</label>
                        <input type="text" id="title" name="title" placeholder="Titel:" value="" minlength="0" maxlength="50" required>
                    </div>
                    <div>
                        <label for="description">Omschrijving</label>
                        <input type="text" id="description" name="description" placeholder="Omschrijving:" value="" minlength="0" maxlength="255" required>
                    </div>
                    <div>
                        <label for="location">Locatie</label>
                        <input type="text" id="location" name="location" placeholder="Locatie:" value="" minlength="0" maxlength="50" required>
                    </div>

                    <input type="submit" name="Opslaan" value="Opslaan" class="submit">
                    <button data-close-button class="cancel">Annuleren</button>
                </form>
            </div>
        </div>
        <div id="overlay"></div>

<!--        Taak aanpassen-->
        <div id="modal1" class="modal">
            <div class="modalHeader">
                <div class="title">Taak aanpassen</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <form name="insertData" method="post">
                    <div>
                        <label for="title">Titel</label>
                        <input type="text" id="title" name="title" placeholder="Titel:" value="" minlength="0" maxlength="50" required>
                    </div>
                    <div>
                        <label for="description">Omschrijving</label>
                        <input type="text" id="description" name="description" placeholder="Omschrijving:" value="" minlength="0" maxlength="255" required>
                    </div>
                    <div>
                        <label for="location">Locatie</label>
                        <input type="text" id="location" name="location" placeholder="Locatie:" value="" minlength="0" maxlength="50" required>
                    </div>

                    <input type="submit" name="Opslaan" value="Opslaan" class="submit">
                    <button data-close-button class="cancel">Annuleren</button>
                </form>
            </div>
        </div>
        <div id="overlay"></div>

<!--        Taak afronden-->
        <div id="modal2" class="modal">
            <div class="modalHeader">
                <div class="title">Taak afronden</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <form name="insertData" method="post">
                    <div>
                        <label for="title">Titel</label>
                        <input type="text" id="title" name="title" placeholder="Titel:" value="" minlength="0" maxlength="50" required>
                    </div>
                    <div>
                        <label for="description">Omschrijving</label>
                        <input type="text" id="description" name="description" placeholder="Omschrijving:" value="" minlength="0" maxlength="255" required>
                    </div>
                    <div>
                        <label for="location">Locatie</label>
                        <input type="text" id="location" name="location" placeholder="Locatie:" value="" minlength="0" maxlength="50" required>
                    </div>

                    <input type="submit" name="Opslaan" value="Opslaan" class="submit">
                    <button data-close-button class="cancel">Annuleren</button>
                </form>
            </div>
        </div>
        <div id="overlay"></div>

<!--        Taak verwijderen-->
        <div id="modal3" class="modal">
            <div class="modalHeader">
                <div class="title">Taak verwijderen</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <form name="deleteData" method="post"></form>
                    <h3>Weet je zeker dat je deze taak wil verwijderen?</h3>

                    <input type="submit" name="Opslaan" value="Verwijder taak" class="submit">
                    <button data-close-button class="cancel">Annuleren</button>
                </form>
            </div>
        </div>
        <div id="overlay"></div>
    </div>
</div>

<div class="myTasksDiv">
    Mijn taken
</div>
<table class="tableHead">
    <tr class="tableBorder">
        <th>#</th>
        <th>Titel</th>
        <th>Omschrijving</th>
        <th>Locatie</th>
        <th>Aangemaakt op</th>
        <th>Afgerond op</th>
        <th>Acties</th>
    </tr>
    <?php getTodo(); ?>
    <!--For loop plaatsen, die door alle taken in de takenlijst loopt (Array?) en hier onder plaatst.-->
    <!--Eerst degene die nog open staan, daarna de voltooide.-->
</table>
</body>


<script src="index.js"></script>

</html>