<?php
  require_once '../model/session.php';
  require_once '../config/database.php';
  require_once '../model/function.php';

  // Check if user is logged in
  if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit();
  }

  // Handle logout
  if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login.php');
    exit();
  }

  // Fetch customer details from session or database
  $customerEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A';
  $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $customerEmail);
  $stmt->execute();
  $result = $stmt->get_result();
  $customer = $result->fetch_assoc();
  $customerFullName = $customer['full_name'];
  $customerPhone = $customer['phone_number'];
  $customerAddress = $customer['address'];
  $customerPosition = $customer['position'];
  $customerRole = $customer['role'];
  
  // Handle edit form submission (basic placeholder, expand as needed)
  if (isset($_POST['save_changes'])) {
    // Update session or database with new values
    $customerFullName = secureData($_POST['full_name']);
    $customerPhone = secureData($_POST['phone']);
    $customerAddress = secureData($_POST['address']);
    
    $stmt = $mysqli->prepare("UPDATE users SET full_name = ?, phone_number = ?, address = ?, position = ?, role = ? WHERE email = ?");
    $stmt->bind_param("ssssss", $customerFullName, $customerPhone, $customerAddress, $customerPosition, $customerRole, $customerEmail);
    $stmt->execute();
    
    // Redirect to profile page
    header("Location: profile");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once './includes/header.php'; ?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main style="margin: 0 auto;">
          <h2  style="font-size: 48px; font-weight: bold; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;" class="section__header">Staff Profile</h2>
          <div class="profile__card">
            <img src="https://i.postimg.cc/k5kz0TjQ/1381511-588644811197844-1671954779-n.jpg" alt="Profile Picture" class="profile__pic">
            <div class="profile__details">
              <h3><?php echo htmlspecialchars($customerFullName); ?></h3>
              <p><strong>Email:</strong> <?php echo htmlspecialchars($customerEmail); ?></p>
              <p><strong>Phone:</strong> <?php echo htmlspecialchars($customerPhone); ?></p>
              <p><strong>Address:</strong> <?php echo htmlspecialchars($customerAddress); ?></p>
              <?php
                if ($customerPosition == '') {
                  echo '<p><strong>Position:</strong> Customer</p>';
                } else {
                  echo '<p><strong>Position:</strong> ' . htmlspecialchars($customerPosition) . '</p>';
                }
              ?>
              <p><strong>Role:</strong> <?php echo htmlspecialchars($customerRole); ?></p>
              <div class="profile__actions">
                <button onclick="toggleEditForm()" class="edit__btn">Edit Profile</button>
                <form method="POST" action="">
                  <button type="submit" name="logout" class="logout__btn">Logout</button>
                </form>
              </div>
            </div>
          </div>
          
          <div class="edit__form__container" id="editFormContainer" style="display: none;">
            <h3>Edit Profile Information</h3>
            <form method="POST" action="">
              <div class="form__group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($customerFullName); ?>" required>
              </div>
              <div class="form__group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($customerPhone); ?>">
              </div>
              <div class="form__group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($customerAddress); ?></textarea>
              </div>
              <div class="form__actions">
                <button type="submit" name="save_changes" class="save__btn">Save Changes</button>
                <button type="button" onclick="toggleEditForm()" class="cancel__btn">Cancel</button>
              </div>
            </form>
          </div>
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>

<script>
  function toggleEditForm() {
    const formContainer = document.getElementById('editFormContainer');
    if (formContainer.style.display === 'none') {
      formContainer.style.display = 'block';
    } else {
      formContainer.style.display = 'none';
    }
  }
</script>

<style>
  .profile__container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
    background-color: #f9f9f9;
    min-height: calc(100vh - 200px);
  }

  .profile__card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 100%;
    max-width: 600px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 20px;
  }

  .profile__pic {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 5px solid #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  }

  .profile__details h3 {
    margin: 0 0 15px;
    color: #333;
    font-size: 24px;
  }

  .profile__details p {
    margin: 10px 0;
    color: #666;
    font-size: 16px;
  }

  .profile__actions {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    justify-content: center;
  }

  .edit__btn, .logout__btn, .save__btn, .cancel__btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
  }

  .edit__btn {
    background-color: #007bff;
    color: white;
  }

  .edit__btn:hover {
    background-color: #0056b3;
  }

  .logout__btn {
    background-color: #ff5c5c;
    color: white;
  }

  .logout__btn:hover {
    background-color: #e60000;
  }

  .edit__form__container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 100%;
    max-width: 600px;
  }

  .edit__form__container h3 {
    margin: 0 0 20px;
    color: #333;
    font-size: 20px;
    text-align: center;
  }

  .form__group {
    margin-bottom: 20px;
  }

  .form__group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #333;
  }

  .form__group input, .form__group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
  }

  .form__actions {
    display: flex;
    gap: 15px;
    justify-content: center;
  }

  .save__btn {
    background-color: #28a745;
    color: white;
  }

  .save__btn:hover {
    background-color: #218838;
  }

  .cancel__btn {
    background-color: #6c757d;
    color: white;
  }

  .cancel__btn:hover {
    background-color: #5a6268;
