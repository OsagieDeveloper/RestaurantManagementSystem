<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';
if(!isLoggedIn()){
    header("location: ../login");
    die();
}

// Handle form submission to add a staff member
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addMenu'])) {
        $menuId = 'menu' . uniqid();
        $menuName = $_POST['menu_name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';
        $imagePath = '';
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../public/assets/img/menu/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageName = basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $menuId . '_' . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $imagePath = str_replace('../', './', $imagePath);
            } else {
                $errorMessage = "Failed to upload image.";
            }
        } else {
            $errorMessage = "Image upload error.";
        }
        
        if (!empty($menuName) && !empty($price) && !empty($description) && !empty($imagePath)) {
            // Check for duplicate email, phone, or staff ID
            $checkQuery = $mysqli->prepare(
                "SELECT COUNT(*) FROM menus WHERE name = ? OR price = ? OR id = ?"
            );
            $checkQuery->bind_param("sss", $menuName, $price, $menuId);
            $checkQuery->execute();
            $checkQuery->bind_result($count);
            $checkQuery->fetch();
            $checkQuery->close();
        
            if ($count > 0) {
                $errorMessage = "Item is already in the menu.";
            } else {
                // Insert the new staff member
                $stmt = $mysqli->prepare(
                    "INSERT INTO menus (id, name, price, description, image) VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->bind_param("sssss", $menuId, $menuName, $price, $description, $imagePath);
        
                if ($stmt->execute()) {
                    $successMessage = "Menu added successfully!";
                } else {
                    $errorMessage = "Failed to add menu item. Please try again.";
                }
                $stmt->close();
            }
        } else {
            $errorMessage = "Please fill out all fields correctly.";
        }
    }
    
    // Handle edit menu item
    if (isset($_POST['editMenu'])) {
        $menuId = $_POST['menu_id'] ?? '';
        $menuName = $_POST['edit_menu_name'] ?? '';
        $price = $_POST['edit_price'] ?? '';
        $description = $_POST['edit_description'] ?? '';
        $imagePath = $_POST['existing_image'] ?? '';
        
        // Handle new image upload
        if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../public/assets/img/menu/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageName = basename($_FILES['edit_image']['name']);
            $imagePath = $uploadDir . $menuId . '_' . $imageName;
            if (move_uploaded_file($_FILES['edit_image']['tmp_name'], $imagePath)) {
                $imagePath = str_replace('../', './', $imagePath);
            } else {
                $errorMessage = "Failed to upload new image.";
            }
        }
        
        if (!empty($menuId) && !empty($menuName) && !empty($price) && !empty($description)) {
            $stmt = $mysqli->prepare(
                "UPDATE menus SET name = ?, price = ?, description = ?, image = ? WHERE id = ?"
            );
            $stmt->bind_param("sssss", $menuName, $price, $description, $imagePath, $menuId);
            
            if ($stmt->execute()) {
                $successMessage = "Menu item updated successfully!";
            } else {
                $errorMessage = "Failed to update menu item.";
            }
            $stmt->close();
        } else {
            $errorMessage = "Please fill out all fields correctly for update.";
        }
    }
    
    // Handle delete menu item
    if (isset($_POST['deleteMenu'])) {
        $menuId = $_POST['delete_menu_id'] ?? '';
        if (!empty($menuId)) {
            $stmt = $mysqli->prepare("DELETE FROM menus WHERE id = ?");
            $stmt->bind_param("s", $menuId);
            if ($stmt->execute()) {
                $successMessage = "Menu item deleted successfully!";
            } else {
                $errorMessage = "Failed to delete menu item.";
            }
            $stmt->close();
        } else {
            $errorMessage = "Invalid menu item ID for deletion.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require_once './includes/header.php';
?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <h1>Manage Menus</h1>

            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <div class="add-table-form" style="width: 100%;">
                <h2>Add Menu</h2>
                <form method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
                    <label for="menu_name">Name:</label>
                    <input 
                        type="text" 
                        id="menu_name" 
                        name="menu_name" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="price">Price:</label>
                    <input 
                        type="text" 
                        id="price" 
                        name="price" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="description">Description:</label>
                    <input 
                        type="text" 
                        id="description" 
                        name="description" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="image">Image:</label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        accept="image/*" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <button 
                        type="submit" 
                        name="addMenu" 
                        style="padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                        Add Menu
                    </button>
                </form>
            </div>

            <div class="recent-order">
                <h2>Existing Menus</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT id, name, price, description, image FROM menus";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="menu image" style="width: 50px; height: auto;"></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['name']); ?>', '<?php echo htmlspecialchars($row['price']); ?>', '<?php echo htmlspecialchars($row['description']); ?>', '<?php echo htmlspecialchars($row['image']); ?>')">Edit</button>
                                        <button class="btn btn-danger" onclick="openDeleteModal('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['name']); ?>')">Delete</button>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='6'>No menus found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px;">
            <span onclick="closeEditModal()" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2>Edit Menu Item</h2>
            <form id="editForm" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
                <input type="hidden" name="menu_id" id="edit_menu_id">
                <input type="hidden" name="existing_image" id="existing_image">
                <label for="edit_menu_name">Name:</label>
                <input type="text" id="edit_menu_name" name="edit_menu_name" required style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">
                
                <label for="edit_price">Price:</label>
                <input type="text" id="edit_price" name="edit_price" required style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">
                
                <label for="edit_description">Description:</label>
                <input type="text" id="edit_description" name="edit_description" required style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">
                
                <label for="edit_image">New Image (optional):</label>
                <input type="file" id="edit_image" name="edit_image" accept="image/*" style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">
                
                <button type="submit" name="editMenu" style="padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px;">Save Changes</button>
            </form>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div id="deleteModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; border-radius: 8px;">
            <span onclick="closeDeleteModal()" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete <span id="delete_menu_name"></span>?</p>
            <form id="deleteForm" method="POST" style="display: flex; justify-content: center; gap: 20px;">
                <input type="hidden" name="delete_menu_id" id="delete_menu_id">
                <button type="button" onclick="closeDeleteModal()" style="padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px;">Cancel</button>
                <button type="submit" name="deleteMenu" style="padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px;">Delete</button>
            </form>
        </div>
    </div>
    
    <script>
        function openEditModal(id, name, price, description, image) {
            document.getElementById('edit_menu_id').value = id;
            document.getElementById('edit_menu_name').value = name;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_description').value = description;
            document.getElementById('existing_image').value = image;
            document.getElementById('editModal').style.display = 'block';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        function openDeleteModal(id, name) {
            document.getElementById('delete_menu_id').value = id;
            document.getElementById('delete_menu_name').textContent = name;
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
        
        // Close modals when clicking outside of them
        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditModal();
            }
            if (event.target == document.getElementById('deleteModal')) {
                closeDeleteModal();
            }
        }
    </script>
    
    <?php require_once './includes/script.php'; ?>
</body>
</html>