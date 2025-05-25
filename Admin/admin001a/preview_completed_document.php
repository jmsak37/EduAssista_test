<?php
// preview_completed_document.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Increase PCRE limits if needed
ini_set('pcre.backtrack_limit', '100000000');
ini_set('pcre.recursion_limit', '100000');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Completed Document Preview</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 8px; text-align: left; }
    .button { padding: 5px 10px; background-color: #00796b; color: #fff; text-decoration: none; border-radius: 3px; }
    iframe { border: 1px solid #ccc; }
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

// Helper: Use a regular approach to extract file names.
// If the string contains only one file extension occurrence, return the entire trimmed string.
function getFiles($str) {
    if (empty($str)) {
        return [];
    }
    preg_match_all('/\.(pdf|docx?|PDF|DOCX?)\b/', $str, $matches);
    if (count($matches[0]) === 1) {
        return [trim($str)];
    }
    // Otherwise, use CSV parsing to split multiple file names.
    return str_getcsv($str);
}

// Helper: Clean file name by removing folder prefixes.
// For answer_files (and explanation_files) remove everything up to and including "doneorders/".
// Also, remove any leading "/" so that the file name is clean.
function cleanFileName($file, $docType) {
    $file = trim($file, " []\"'");
    if ($docType === 'uploaded') {
        if (stripos($file, 'uploads/') === 0) {
            $file = substr($file, strlen('uploads/'));
        }
    } elseif ($docType === 'answers' || $docType === 'explanation') {
        // Remove everything up to and including "doneorders/" (handles both / and \)
        $file = preg_replace('/^.*doneorders[\/\\\\]/i', '', $file);
        $file = ltrim($file, '/'); // Remove any leading slash
    }
    return $file;
}

// Connect to the database to fetch the completed record.
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Database connection error: " . $conn->connect_error);
}

$sql = "SELECT document_upload_link, completed_work_link, answer_files, explanation_files FROM completed WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "<p>No record found for Order ID: $order_id</p>";
    exit;
}
$record = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Determine the files array and base folder based on type.
switch ($type) {
    case 'uploaded':
        $files = getFiles($record['document_upload_link']);
        $baseFolder = "../../client/uploads/";
        break;
    case 'completed':
        $files = getFiles($record['completed_work_link']);
        $baseFolder = "../../Tutor/doneorders/";
        break;
    case 'answers':
        $files = getFiles($record['answer_files']);
        $baseFolder = "../../Tutor/doneorders/";
        break;
    case 'explanation':
        $files = getFiles($record['explanation_files']);
        $baseFolder = "../../Tutor/doneorders/";
        break;
    case 'all':
        $files = [];
        foreach (getFiles($record['document_upload_link']) as $f) {
            $files[] = array("file" => cleanFileName($f, 'uploaded'), "source" => "uploaded", "baseFolder" => "../../client/uploads/");
        }
        foreach (getFiles($record['completed_work_link']) as $f) {
            $files[] = array("file" => cleanFileName($f, 'completed'), "source" => "completed", "baseFolder" => "../../Tutor/doneorders/");
        }
        foreach (getFiles($record['answer_files']) as $f) {
            $files[] = array("file" => cleanFileName($f, 'answers'), "source" => "answers", "baseFolder" => "../../Tutor/doneorders/");
        }
        foreach (getFiles($record['explanation_files']) as $f) {
            $files[] = array("file" => cleanFileName($f, 'explanation'), "source" => "explanation", "baseFolder" => "../../Tutor/doneorders/");
        }
        break;
    default:
        echo "<p>Invalid document type.</p>";
        exit;
}

// If no specific file is specified, display a list of available documents.
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
                echo "<td>" . ucfirst($type) . "</td>";
                echo "<td><a class='button' href='preview_completed_document.php?type=$type&order_id=$order_id&file=" . urlencode($f) . "&source=$type'>Preview</a></td>";
                echo "</tr>";
            }
        } else {
            foreach ($files as $item) {
                $f = $item['file'];
                $src = $item['source'];
                echo "<tr>";
                echo "<td>$f</td>";
                echo "<td>" . ucfirst($src) . "</td>";
                echo "<td><a class='button' href='preview_completed_document.php?type=$src&order_id=$order_id&file=" . urlencode($f) . "&source=$src'>Preview</a></td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
    exit;
}

// Preview Mode: a specific file has been specified.
$fileName = cleanFileName($fileParam, $type);
if ($type === 'all' && !empty($sourceParam)) {
    if ($sourceParam === 'uploaded') {
        $baseFolder = "../../client/uploads/";
    } else {
        $baseFolder = "../../Tutor/doneorders/";
    }
}
$fullFilePath = $baseFolder . $fileName;

// Check if the file exists in the primary location; if not, try alternative folders.
if (!file_exists($fullFilePath)) {
    $alternative1 = "../../client/request/" . $fileName;
    $alternative2 = "../../client/supportreview_uploads/" . $fileName;
    if (file_exists($alternative1)) {
        $fullFilePath = $alternative1;
    } elseif (file_exists($alternative2)) {
        $fullFilePath = $alternative2;
    } else {
        echo "<p>File '" . htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8') . "' not found. The document does not exist.</p>";
        echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
        exit;
    }
}

$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
echo "<h2>Preview: " . htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8') . "</h2>";
if ($ext === 'doc' || $ext === 'docx') {
    $embedUrl = "https://docs.google.com/gview?embedded=true&url=" . urlencode($fullFilePath);
    echo "<iframe src='$embedUrl' style='width:100%; height:600px;' frameborder='0'></iframe>";
} elseif ($ext === 'pdf') {
    echo "<iframe src='$fullFilePath' style='width:100%; height:600px;' frameborder='0'></iframe>";
} else {
    echo "<p>Preview is not available for this file type.</p>";
}
echo "<p><a class='button' href='$fullFilePath' download>Download</a></p>";
echo "<p><a class='button' href='javascript:history.back()'>Back</a></p>";
?>
</body>
</html>
