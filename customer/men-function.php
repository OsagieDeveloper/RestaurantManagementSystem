function addMenuItem($name, $price, $image, $type) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    $stmt = $conn->prepare("INSERT INTO menu_items (name, price, image, type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $price, $image, $type);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function fetchMenuItems() {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    $stmt = $conn->prepare("SELECT * FROM menu_items");
    $stmt->execute();
    $result = $stmt->get_result();
    $menu_items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $menu_items;
}

function updateMenuItem($id, $name, $price, $image, $type) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    $stmt = $conn->prepare("UPDATE menu_items SET name = ?, price = ?, image = ?, type = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $price, $image, $type, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function deleteMenuItem($id) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}