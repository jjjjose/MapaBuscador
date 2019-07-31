<?php
header("Content-type: application/json; charset=utf-8");
// datos de tu base de datos XD
$host = 'localhost';
$db = 'mapas';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

// funcion de conexion a base de datos
class DbConnect
{
    private $host = 'localhost';
    private $db = 'mapas';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8mb4';

    function connect()
    {
        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options);

            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $handler = fopen('php://input', 'r');
    $request = stream_get_contents($handler);

    $data = json_decode($request, true);
    $db = new DbConnect;
    if ($data['tip'] == 'all') {
        $query = "SELECT * FROM maps ORDER BY place_id";
        $stmt = $db->connect()->prepare($query);
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $dat[] = $row;
            }
            echo json_encode($dat);
        }
    } elseif ($data['tip'] == 'name') {
        $name = $data['id'];
        $query2 = "SELECT * FROM maps WHERE place_id=$name";
        $stmt2 = $db->connect()->prepare($query2);
        if ($stmt2->execute()) {
            while ($roww = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $dats[] = $roww;
            }
            echo json_encode($dats);
        }
    } else {
        echo json_encode('moral no mas choco');
    }
}
