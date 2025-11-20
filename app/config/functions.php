function getCount($table) {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)['total'];
}
