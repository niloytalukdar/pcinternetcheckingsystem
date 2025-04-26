<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    include 'config.php';
    if (!$pdo) {
        throw new Exception('Database connection failed');
    }
    $stmt = $pdo->query("SELECT pc_id, lab_id, status, timestamp FROM pc_status_archive ORDER BY timestamp DESC LIMIT 100");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
    try {
        $pdo->exec("CREATE INDEX idx_timestamp ON pc_status_archive (timestamp)");
    } catch (PDOException $e) {
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>