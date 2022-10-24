<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Arae personale</title>
</head>

<body>
    <h2 class="text-success text-center">I miei Voti</h2>

    <?php
    if (isset($_POST['nome']) && isset($_POST['cognome'])) {
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        define('DB_SERVERNAME', 'localhost:3306');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', 'root');
        define('DB_NAME', 'db_university');
        $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($conn && $conn->connect_error) {
            echo 'Connessione fallita';
        } else {
            $stmt = $conn->prepare("
        SELECT S.`name`, S.`surname`, C.`name` AS 'esame', MAX(ES.vote) AS voto, IF(MAX(ES.vote)>18, 'PROMOSSO', 'BOCCIATO' ) AS 'stato_esame'
        FROM `students` S
        JOIN `exam_student` ES
        ON S.`id` = ES.`student_id`
        JOIN `exams` E
        ON E.`id` = ES.`exam_id`
        JOIN `courses` C
        ON C.`id` = E.`course_id`
        WHERE s.name = ? AND s.surname= ?
        GROUP BY S.`name`, S.`surname`, C.`name`; 
        ");
            if (!$stmt) {
                echo $conn->error;
                die();
            }
            $stmt->bind_param('ss', $nome, $cognome);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    include __DIR__ . "/student-votes.php";
                };
            } else {
                echo '<div class="w-100 text-center p-5">I parametri inseriti non sono presenti nel database</div>';
            }
        }
    };
    $conn->close()
    ?>
    <form action="index.html" class="d-flex justify-content-center my-4">
        <button class="btn btn-danger">Ritorna alla pagina iniziale</button>
    </form>
</body>

</html>