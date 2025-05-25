<?php
// view_orders.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Document Preview</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      margin: 20px; 
    }
    h2 { 
      margin-bottom: 20px; 
    }
    .doc-list, table { 
      margin-bottom: 20px; 
    }
    table { 
      width: 100%; 
      border-collapse: collapse; 
    }
    table, th, td { 
      border: 1px solid #ccc; 
    }
    th, td { 
      padding: 8px; 
      text-align: left; 
    }
    .button { 
      padding: 5px 10px; 
      background-color: #00796b; 
      color: #fff; 
      text-decoration: none; 
      border-radius: 3px; 
    }
    iframe { 
      border: 1px solid #ccc; 
    }
    /* Style for no-preview download area */
    .no-preview {
      border: 2px dashed #00796b;
      padding: 20px;
      text-align: center;
      margin-top: 20px;
    }
    .no-preview a {
      font-size: 18px;
      padding: 15px 25px;
      background-color: #00796b;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
    }
    .no-preview a:hover {
      background-color: #004d40;
    }
  </style>
</head>
<body>
<?php
// Get required parameters: order_id and file are required.
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$fileParam = isset($_GET['file']) ? $_GET['file'] : '';

if(empty($order_id) || empty($fileParam)) {
    echo "<p>Missing required parameters.</p>";
    exit;
}

// All order documents are stored in ../../client/uploads/
$baseFolder = "../../client/uploads/";

// Clean file name (assumes fileParam is URL-encoded)
$fileName = trim(urldecode($fileParam));

// Build full file path.
$fullFilePath = $baseFolder . $fileName;

if(!file_exists($fullFilePath)) {
    echo "<p>File '" . htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8') . "' not found. The document does not exist.</p>";
    echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
    exit;
}

$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
echo "<h2>Preview: " . htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8') . "</h2>";
if($ext === 'pdf') {
    // Preview PDFs in an iframe.
    echo "<iframe src='$fullFilePath' style='width:100%; height:600px;' frameborder='0'></iframe>";
} else {
    // For non-PDF files, show message and large download link.
    echo "<p>Preview is not available for this file type.</p>";
    echo "<div class='no-preview'>";
    echo "<p>Click below to download the document:</p>";
    echo "<a href='$fullFilePath' download>Download Document</a>";
    echo "</div>";
}
echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
?>
</body>
</html>
