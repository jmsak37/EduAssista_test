<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header('Location: ../login.html');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pricing info for writer types
$pricingQuery = "SELECT writer_type, price_per_page FROM pricing";
$pricingResult = $conn->query($pricingQuery);

// Fetch user's current balance
$userBalance = 0;
$userID = $_SESSION['userID'];
$sqlBalance = "SELECT balance FROM balance WHERE user_id = ?";
$stmtBalance = $conn->prepare($sqlBalance);
$stmtBalance->bind_param("i", $userID);
$stmtBalance->execute();
$stmtBalance->bind_result($balance);
$stmtBalance->fetch();
$stmtBalance->close();
$userBalance = is_null($balance) ? 0 : $balance;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Place Order</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 80%;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    label {
      margin-top: 10px;
      font-weight: bold;
    }
    input, textarea, select, button {
      margin-top: 5px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 100%;
      box-sizing: border-box;
    }
    button {
      background-color: #28a745;
      color: #fff;
      cursor: pointer;
      margin-top: 20px;
    }
    button:hover {
      background-color: #218838;
    }
    #total_price {
      font-weight: bold;
    }
    .document-group {
      margin-top: 10px;
    }
    .document-group input {
      margin-bottom: 5px;
    }
    #add-document-btn {
      background-color: #007BFF;
      margin-top: 5px;
      font-size: 14px;
      padding: 8px;
    }
    /* Popup overlay style */
    #upload-popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 9999;
    }
    #upload-popup .popup-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
      width: 300px;
    }
    .progress-bar {
      width: 100%;
      background: #eee;
      border-radius: 5px;
      overflow: hidden;
      margin-bottom: 10px;
    }
    .progress-bar .progress {
      width: 0%;
      height: 20px;
      background: #4caf50;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Place Your Order</h2>
    <form id="order-form" enctype="multipart/form-data" method="POST" action="submit_order.php">
      <!-- Hidden fields for client_id and current user balance -->
      <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($_SESSION['userID']); ?>">
      <input type="hidden" id="user_balance" value="<?php echo htmlspecialchars($userBalance); ?>">
      
      <?php
      if (isset($pricingResult) && $pricingResult && $pricingResult->num_rows > 0) {
          echo '<label for="writer_type">Select Writer Type:</label>';
          echo '<select id="writer_type" name="writer_type" required>';
          while ($row = $pricingResult->fetch_assoc()) {
              echo '<option value="' . $row['writer_type'] . '" data-price="' . $row['price_per_page'] . '">' 
                   . $row['writer_type'] . ' - $' . $row['price_per_page'] . ' per page</option>';
          }
          echo '</select>';
      } else {
          echo "<p>No pricing information available.</p>";
      }
      ?>
      
      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject">
      
      <label for="order_name">Order Name:</label>
      <input type="text" id="order_name" name="order_name">
      
      <label for="order_description">Order Description:</label>
      <textarea id="order_description" name="order_description" rows="5"></textarea>
      
      <label for="upload_instructions">Upload Instructions:</label>
      <textarea id="upload_instructions" name="upload_instructions" rows="3"></textarea>
      
      <label for="order_deadline">Order Deadline:</label>
      <input type="datetime-local" id="order_deadline" name="order_deadline">
      
      <label for="number_of_pages">Number of Pages:</label>
      <input type="number" id="number_of_pages" name="number_of_pages" min="1">
      
      <label for="order_document">Attach Document (optional):</label>
      <input type="file" id="order_document" name="order_document[]">
      <!-- Container for additional document inputs -->
      <div id="additional-documents-container"></div>
      <button type="button" id="add-document-btn">Add Another Document</button>
      
      <p>Total Price: $<span id="total_price">0.00</span></p>
      
      <button type="submit">Place Order</button>
    </form>
    <p id="order-response"></p>
  </div>
  
  <!-- Upload Popup -->
  <div id="upload-popup">
    <div class="popup-content">
      <div class="progress-bar">
        <div class="progress" id="progress"></div>
      </div>
      <p>Uploading documents, please wait...</p>
    </div>
  </div>
  
  <script>
    // Recalculate total price when writer type or number of pages changes.
    document.getElementById('writer_type').addEventListener('change', calculateTotalPrice);
    document.getElementById('number_of_pages').addEventListener('input', calculateTotalPrice);
    
    function calculateTotalPrice() {
      const writerType = document.getElementById('writer_type');
      const pricePerPage = parseFloat(writerType.options[writerType.selectedIndex].getAttribute('data-price'));
      const numberOfPages = parseInt(document.getElementById('number_of_pages').value) || 0;
      const totalPrice = pricePerPage * numberOfPages;
      document.getElementById('total_price').textContent = totalPrice.toFixed(2);
    }
    
    // Append additional document file inputs
    document.getElementById('add-document-btn').addEventListener('click', function() {
      const container = document.getElementById('additional-documents-container');
      const input = document.createElement('input');
      input.type = "file";
      input.name = "order_document[]";
      container.appendChild(input);
    });
    
    // Handle form submission with XMLHttpRequest to support upload progress
    document.getElementById('order-form').addEventListener('submit', function(event) {
      event.preventDefault();
      
      // Validate deadline: must be at least 1 hour from now
      const orderDeadline = new Date(document.getElementById('order_deadline').value);
      const currentTime = new Date();
      const timeDifference = (orderDeadline - currentTime) / (1000 * 60 * 60); // in hours
      if (timeDifference < 1) {
        alert("The order deadline must be at least 1 hour from the current time.");
        return;
      }
      
      // Validate total price
      const totalPrice = parseFloat(document.getElementById('total_price').textContent);
      if (isNaN(totalPrice) || totalPrice <= 0) {
        alert("Please select a valid writer type and number of pages to calculate a valid price.");
        return;
      }
      
      // Check if the user's balance is sufficient
      const userBalance = parseFloat(document.getElementById('user_balance').value);
      if (userBalance < totalPrice) {
        window.location.href = "dipost.html?required=" + totalPrice.toFixed(2);
        return;
      }
      
      const formData = new FormData(this);
      formData.append('total_price', totalPrice);
      
      // Show upload popup
      const uploadPopup = document.getElementById('upload-popup');
      const progressBar = document.getElementById('progress');
      uploadPopup.style.display = 'block';
      progressBar.style.width = '0%';
      
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'submit_order.php', true);
      
      xhr.upload.onprogress = function(event) {
        if (event.lengthComputable) {
          const percentComplete = Math.round((event.loaded / event.total) * 100);
          progressBar.style.width = percentComplete + '%';
        }
      };
      
      xhr.onload = function() {
        uploadPopup.style.display = 'none';
        if (xhr.status === 200) {
          const data = JSON.parse(xhr.responseText);
          if (data.success) {
            window.location.href = 'successresults.html';
            setTimeout(function() {
              window.location.href = 'index.html';
            }, 5000);
          } else {
            // Check if error indicates insufficient balance
            if (data.message.indexOf("Insufficient balance") !== -1) {
              if (confirm(data.message + "\nWould you like to deposit?")) {
                window.location.href = "dipost.html?required=" + parseFloat(data.required).toFixed(2);
              } else {
                window.location.href = "index.html";
              }
            } else {
              alert("Failed to place order: " + data.message);
            }
          }
        } else {
          alert("Error placing order.");
        }
      };
      
      xhr.onerror = function() {
        uploadPopup.style.display = 'none';
        alert("An error occurred during the upload.");
      };
      
      xhr.send(formData);
    });
  </script>
</body>
</html>
