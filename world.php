<?php
header('Access-Control-Allow-Origin: *');

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? trim(strip_tags($_GET['country'])) : '';
$lookup = isset($_GET['lookup']) ? trim(strip_tags($_GET['lookup'])) : '';

if ($lookup === 'cities') {
    if (!empty($country)) {
        $stmt = $conn->prepare(
            "SELECT cities.name, cities.district, cities.population 
             FROM cities 
             JOIN countries ON cities.country_code = countries.code 
             WHERE countries.name LIKE :country"
        );
        $stmt->execute(['country' => "%$country%"]);
    } else {
        $stmt = $conn->query(
            "SELECT cities.name, cities.district, cities.population 
             FROM cities 
             JOIN countries ON cities.country_code = countries.code"
        );
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['district']); ?></td>
                    <td><?= htmlspecialchars(number_format($row['population'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
} else {
    if (!empty($country)) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Continent</th>
                <th>Independence</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['continent']); ?></td>
                    <td><?= htmlspecialchars($row['independence_year'] ?? 'N/A'); ?></td>
                    <td><?= htmlspecialchars($row['head_of_state'] ?? 'N/A'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>