<?php
include "index.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoapp";

//Database connectie aangemaakt
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

//Data in de database stoppen
$query = "insert into todoapp (`title`, `description`, `location`) values (:title, :description, :location)";
//echo $query;
$sth = $conn->prepare($query);
$sth->bindParam(':title', $_POST['title']);
$sth->bindParam(':description', $_POST['description']);
$sth->bindParam(':location', $_POST['location']);
$sth->execute();

//Data uit de database ophalen
$query = "select id, title, description, location from todoapp";
$sth = $conn->prepare($query);
$sth->execute();
//Geeft data weer in een associatieve array (data wordt niet opgehaald via indexes, maar via namen)
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

//Toon de data uit de array
foreach($result as $row) {
    echo "<table>
            <tr>
                <td>".$row['id']."</td>
                <td>".$row['title']."</td>
                <td>".$row['description']."</td>
                <td>".$row['location']."</td>
            </tr>
        </table>";
}
?>