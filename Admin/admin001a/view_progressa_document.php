<?php
// view_progressa_document.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document Preview</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { margin-bottom: 20px; }
    .doc-list, table { margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 8px; text-align: left; }
    .button { padding: 5px 10px; background-color: #00796b; color: #fff; text-decoration: none; border-radius: 3px; }
    iframe { border: 1px solid #ccc; }
    /* Large area styling for documents with no preview */
    .no-preview {
      border: 2px dashed #00796b;
      padding: 40px;
      text-align: center;
      margin-top: 20px;
      font-size: 1.2em;
      color: #00796b;
      cursor: pointer;
    }
    .no-preview:hover {
      background-color: #e0f7fa;
    }
  </style>
</head>
<body>
<?php
// Get required parameters: type and order_id must be provided; file and source are optional.
$type = isset($_GET['type']) ? $_GET['type'] : '';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$fileParam = isset($_GET['file']) ? $_GET['file'] : '';
$sourceParam = isset($_GET['source']) ? $_GET['source'] : ''; // used in "all" mode

if (empty($type) || empty($order_id)) {
    echo "<p>Missing required parameters.</p>";
    exit;
}

// Force display of all documents table when type is "all"
if ($type === 'all') {
    $fileParam = '';
}

// Helper: Split comma-separated list and remove empty values.
function getFiles($str) {
    $arr = array_map('trim', explode(",", $str));
    return array_filter($arr, function($val) { return !empty($val); });
}

// Helper: Clean file name by removing folder prefixes.
function cleanFileName($file, $docType) {
    $file = trim($file, " []\"'");
    if ($docType === 'uploaded') {
        if (stripos($file, 'uploads/') === 0) {
            $file = substr($file, strlen('uploads/'));
        }
    } elseif ($docType === 'answers' || $docType === 'explanation') {
        $file = preg_replace('/^(doneorders[\/\\\\]+)/i', '', $file);
    }
    return $file;
}

// Connect to the database to fetch the progressa record.
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Database connection error: " . $conn->connect_error);
}

$sql = "SELECT document_upload_link, answer_files, explanation_files FROM progressa WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows == 0) {
    echo "<p>No record found for Order ID: $order_id</p>";
    exit;
}
$stmt->bind_result($docUpload, $answerFilesStr, $explanationFilesStr);
$stmt->fetch();
$stmt->close();
$conn->close();

// Get arrays of files.
$uploadedFiles    = getFiles($docUpload);
$answerFiles      = getFiles($answerFilesStr);
$explanationFiles = getFiles($explanationFilesStr);

// Determine the files array and base folder.
if ($type === 'uploaded') {
    $files = $uploadedFiles;
    $source = 'uploaded';
    $baseFolder = "../../client/uploads/";
} elseif ($type === 'answers') {
    $files = $answerFiles;
    $source = 'answers';
    $baseFolder = "../../Tutor/doneorders/";
} elseif ($type === 'explanation') {
    $files = $explanationFiles;
    $source = 'explanation';
    $baseFolder = "../../Tutor/doneorders/";
} elseif ($type === 'all') {
    $files = [];
    foreach ($uploadedFiles as $f) {
        $files[] = array("file" => cleanFileName($f, 'uploaded'), "source" => "uploaded", "baseFolder" => "../../client/uploads/");
    }
    foreach ($answerFiles as $f) {
        $files[] = array("file" => cleanFileName($f, 'answers'), "source" => "answers", "baseFolder" => "../../Tutor/doneorders/");
    }
    foreach ($explanationFiles as $f) {
        $files[] = array("file" => cleanFileName($f, 'explanation'), "source" => "explanation", "baseFolder" => "../../Tutor/doneorders/");
    }
} else {
    echo "<p>Invalid document type.</p>";
    exit;
}

// If no specific file is specified, display table of documents.
if (empty($fileParam)) {
    echo "<h2>Documents (" . ucfirst($type) . ") for Order $order_id</h2>";
    if (empty($files)) {
        echo "<p>No documents available.</p>";
    } else {
        echo "<table>";
        echo "<tr><th>Document Name</th><th>Source</th><th>Action</th></tr>";
        if ($type !== 'all') {
            foreach ($files as $f) {
                $cleanName = cleanFileName($f, $type);
                echo "<tr>";
                echo "<td>$cleanName</td>";
                echo "<td>" . ucfirst($source) . "</td>";
                echo "<td><a class='button' href='view_progressa_document.php?type=$type&order_id=$order_id&file=" . urlencode($cleanName) . "&source=$source'>Preview</a></td>";
                echo "</tr>";
            }
        } else {
            foreach ($files as $item) {
                $f = $item['file'];
                $src = $item['source'];
                echo "<tr>";
                echo "<td>$f</td>";
                echo "<td>" . ucfirst($src) . "</td>";
                echo "<td><a class='button' href='view_progressa_document.php?type=$src&order_id=$order_id&file=" . urlencode($f) . "&source=$src'>Preview</a></td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
    exit;
}

// --- Preview Mode: a file has been specified ---
$fileName = cleanFileName($fileParam, $type);

if ($type === 'all' && !empty($sourceParam)) {
    $baseFolder = ($sourceParam === 'uploaded') ? "../../client/uploads/" : "../../Tutor/doneorders/";
}

$fullFilePath = $baseFolder . $fileName;

if (!file_exists($fullFilePath)) {
    $alternative1 = "../../client/request/" . $fileName;
    $alternative2 = "../../client/supportreview_uploads/" . $fileName;
    if (file_exists($alternative1)) {
        $fullFilePath = $alternative1;
    } elseif (file_exists($alternative2)) {
        $fullFilePath = $alternative2;
    } else {
        echo "<p>File '$fileName' not found. The document does not exist.</p>";
        echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
        exit;
    }
}

$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
echo "<h2>Preview: $fileName</h2>";
if ($ext === 'pdf') {
    echo "<iframe src='$fullFilePath' style='width:100%; height:600px;' frameborder='0'></iframe>";
} else {
    echo "<div class='no-preview' onclick=\"window.location.href='$fullFilePath';\">";
    echo "Preview is not available for this file type. Click here to download the document.";
    echo "</div>";
}
echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
?>
</body>
</html>
