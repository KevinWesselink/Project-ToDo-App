<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css?=v081220220848">
    <?php include "db.php"; ?>
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
            <div class="modalHeader">
                <div class="title">Nieuwe taak aanmaken</div>
                <button data-close-button class="closeButton">&times;</button>
            </div>
            <div class="modalBody">
                <form method="post">
                    <div>
                        <label for="title">Titel</label>
                        <input type="text" id="title" name="createTask" placeholder="Titel:" value="" minlength="0" maxlength="50" required>
                    </div>
                    <div>
                        <label for="description">Omschrijving</label>
                        <input type="text" id="description" name="createTask" placeholder="Omschrijving:" value="" minlength="0" maxlength="255" required>
                    </div>
                    <div>
                        <label for="location">Locatie</label>
                        <input type="text" id="location" name="createTask" placeholder="Locatie:" value="" minlength="0" maxlength="50" required>
                    </div>
                </form>

                <button data-close-button class="submit" onclick="submit()">Opslaan</button>
                <button data-close-button class="cancel" >Annuleren</button>

            </div>
        </div>
        <div id="overlay"></div>
    </div>
</div>

<div class="myTasksDiv">
    Mijn taken
</div>

<div class="taskList">
    <table class="tableHead">
        <tr>
            <th>#</th>
            <th>Titel</th>
            <th>Omschrijving</th>
            <th>Locatie</th>
            <th>Aangemaakt op</th>
            <th>Afgerond op</th>
            <th>Kladblok</th>
        </tr>
        <!--For loop plaatsen, die door alle taken in de takenlijst loopt (Array?) en hier onder plaatst.-->
        <!--Eerst degene die nog open staan, daarna de voltooide.-->
    </table>
</div>

</body>

<script src="index.js"></script>

</html>