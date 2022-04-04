<?php
$mysqli = new mysqli("localhost", "root", "", "uni_db");
if (isset($_POST['id'])) {

    // verificam daca s-au completat formurile, cu un default value daca nu au fost completate.
    // posibil aici sa facem si o validare in care verificam daca putem folosii datele de la user.
    $firstName = $_POST['nume'] ?? "";
    $lastName = $_POST['prenume'] ?? "";
    $age = $_POST['varsta'] ?? 0;

    // cauta daca exista un rand cu id-ul respectiv
    $stmt = $mysqli->prepare("SELECT * FROM students WHERE ID = ?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // daca exista => update
    if ($result->num_rows > 0) {
        $updateStmt = $mysqli->prepare("UPDATE students SET first_name = ?, last_name = ?,age=?   WHERE ID = ?");

        $updateStmt->bind_param("ssii", $firstName, $lastName, $age, $_POST['id']);
        $updateStmt->execute();
        var_dump($updateStmt);
        $updateStmt->close();
    } else {
        // daca nu exista => create
        $createStmt = $mysqli->prepare("INSERT INTO students (first_name,last_name, age) VALUES (?, ?, ?)");
        $createStmt->bind_param("ssi", $firstName, $lastName, $age,);
        $createStmt->execute();
        $createStmt->close();
    }
}
?>


<h1>Inserare Student</h1>
<div class="form">
    <form method="post" action="db_operations.php">
        <div>
            <label>
                ID:
                <input type="number" name="id" value=""/>
            </label>
        </div>
        <div>
            <label>
                Nume:
                <input type="text" name="nume" value=""/>
            </label>
        </div>
        <div>
            <label>
                Prenume:
                <input type="text" name="prenume" value=""/>
            </label>
        </div>
        <div>
            <label>
                Varsta:
                <input type="number" name="varsta" value=""/>
            </label>
        </div>
        <button type="submit">Trimite</button>
    </form>
</div>

<?php

// ia toate randurile din db

$stmt = $mysqli->prepare("SELECT * FROM students");
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<h2>Lista studenti</h2>
<table>
    <thead>
        <th>Id</th>
        <th>Nume</th>
        <th>Prenume</th>
        <th>Varsta</th>
    </thead>
    <tbody>
        <?php
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['ID'] ?></td>
                <td><?php echo $row['first_name'] ?></td>
                <td><?= $row['last_name'] ?></td>
                <td><?= $row['age'] ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>