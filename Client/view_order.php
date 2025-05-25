<?php
// view_order.php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if order_id is provided in the URL; if not, fetch the first order.
if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $query = "SELECT order_id, subject, name, description, instructions, deadline, document_name, document_upload_link, number_of_pages, price FROM orders WHERE order_id = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "Order not found.";
        exit;
    }
    $stmt->close();
} else {
    // No order_id provided; fetch the first order from the orders table.
    $query = "SELECT order_id, subject, name, description, instructions, deadline, document_name, document_upload_link, number_of_pages, price FROM orders LIMIT 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "No orders found.";
        exit;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Details</title>
  <link rel="stylesheet" href="style4.css">
  <style>
    /* Additional page-specific CSS if needed */
    .order-details {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="order-details">
    <h2>Order Details</h2>
    <table>
      <tr>
        <th>Order ID</th>
        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
      </tr>
      <tr>
        <th>Subject</th>
        <td><?php echo htmlspecialchars($order['subject']); ?></td>
      </tr>
      <tr>
        <th>Name</th>
        <td><?php echo htmlspecialchars($order['name']); ?></td>
      </tr>
      <tr>
        <th>Description</th>
        <td><?php echo htmlspecialchars($order['description']); ?></td>
      </tr>
      <tr>
        <th>Instructions</th>
        <td><?php echo htmlspecialchars($order['instructions']); ?></td>
      </tr>
      <tr>
        <th>Deadline</th>
        <td><?php echo htmlspecialchars($order['deadline']); ?></td>
      </tr>
      <tr>
        <th>Price</th>
        <td>$<?php echo htmlspecialchars($order['price']); ?></td>
      </tr>
      <tr>
        <th>Number of Pages</th>
        <td><?php echo htmlspecialchars($order['number_of_pages']); ?></td>
      </tr>
    </table>
    <?php if (!empty($order['document_upload_link'])): ?>
      <div class="download-link">
        <p><strong>Uploaded Document:</strong> <?php echo htmlspecialchars($order['document_name']); ?></p>
        <a href="<?php echo htmlspecialchars($order['document_upload_link']); ?>" target="_blank">Download Document</a>
      </div>
    <?php else: ?>
      <p>No document uploaded.</p>
    <?php endif; ?>
  </div>
</body>
</html>
