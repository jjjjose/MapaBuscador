<?php
// datos de tu base de datos XD
$host = 'localhost';
$db = 'mapas';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

// estado inicial de la app
$inicio = 0;
$dat;
$datos;
$nom = 0;
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
$db = new DbConnect;
// ejecutar todos los datos de la base de datos :v 
$query = "SELECT * FROM maps ORDER BY place_id";
$stmt = $db->connect()->prepare($query);
if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    $dat = $data;
}
// aca mostramos a los usuarios consultados en la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $inicio = 1;
    $name = $_POST['persona'];
    $rows = $db->connect()->query("SELECT * FROM maps WHERE place_id='{$name}'");

    if ($rows->fetchColumn() > 0) {
        // return 'positivo hay place_id';
        $inicio = 1;
        $nom = $name;
    } else {
        $inicio = 0;
    }
}
