<?php
require_once("config.php"); // Ensure the path is correct

// Create connection
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Categories
$categories = $conn->query("SELECT CategoryID, CategoryName FROM faultcategory"); // Adjust table name as needed
// Check if query was successful
if (!$categories) {
    die("Query failed: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $conn->real_escape_string($_POST['description']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $createdAt = date('Y-m-d H:i:s');

    // Insert into maintenanceticket
    $sql = "INSERT INTO maintenanceticket (Description, CategoryID, CreatedAt) VALUES ('$description', '$category_id', '$createdAt')";

    if ($conn->query($sql) === TRUE) {
        $ticketID = $conn->insert_id; // Get the last inserted TicketID

        // Photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $targetDir = "uploads/";

            // Check if the uploads directory exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true); // Create the directory if it doesn't exist
            }

            $targetFile = $targetDir . basename($_FILES['photo']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is an actual image
            $check = getimagesize($_FILES['photo']['tmp_name']);
            if ($check === false) {
                die("File is not an image.");
            }

            // Move the uploaded file
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                // Insert into photo table
                $sqlPhoto = "INSERT INTO photo (TicketID, URL) VALUES ('$ticketID', '$targetFile')";
                if ($conn->query($sqlPhoto) === TRUE) {
                    echo "New record created successfully!";
                } else {
                    echo "Error: " . $sqlPhoto . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Error: " . $_FILES['photo']['error'];
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



// Close the database connection
$conn->close();
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data
    $foeStudentNumber = $_POST['foeStudentNumber'];
    $createdAt = $_POST['CreatedAt'];
    $name = $_POST['name'];

    // Here, you would typically add code to save the data to a database
    // For example, if the data was successfully saved:
    $success = true; // Change this based on actual success of the operation

    if ($success) {
        // Redirect to the "feedbackform" page
        header("Location: feedbackform.php");
        exit(); // Make sure to call exit after header redirection
    } else {
        // Handle failure (e.g., show an error message)
        echo "There was an error processing your request.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<header>
        <img src="ll.png" alt="Centered Image" id="header-image">
        <h1>Maintenance Fault Form</h1>
        <button class="go-back" onclick="window.location.href='studentview.php';">Go Back</button>
    </header>

<body>
   
    <form action="" method="post" enctype="multipart/form-data">
   
    <label for="date">Select Date:</label><br>
        <input type="date"  id="date" name="CreatedAt" required ><br><br>

        <label for="category_id">Category:</label><br><br>
        <select name="category_id" id="category_id" required>
            <?php while ($row = $categories->fetch_assoc()): ?>
                <option value="<?php echo $row['CategoryID']; ?>"><?php echo $row['CategoryName']; ?></option>
            <?php endwhile; ?>
        </select><br>


        <label for="description">Description:</label><br><br>
        <textarea name="description" id="description" required></textarea><br>

        <label for="photo">Upload Photo:</label><br><br>
        <input type="file" name="photo" id="photo" accept="image/*" required><br><br><br><br>

<input type="hidden" name="StudentNumber" id="StudentNumber" value="<?php echo $StudentNumber; ?>">
<input type="hidden" name="ResidenceLocation" id="ResidenceLocation" value="<?php echo $ResidenceLocation; ?>"> 
<input type="submit" value="Submit">
<img src="fo2.png" alt="Bottom Left Image" id="bottom-left-image">
    </form>
</body>
</html>

<style>

header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: black;

            padding: 0px;
            color: #EDE8F5;
            font-family: 'Times New Roman', Times, serif;

        }
        label {
            font-weight: bold; /* Option 1: Make all labels bold */
       margin-bottom: 8px; }

        #header-image {
            width: 300px;
            /* Ensure the image scales down if necessary */
            height: auto;
            /* Maintain the image aspect ratio */
            margin-right: auto;
            position: relative;


        }

        header h1 {
            color: #EDE8F5;
            margin-right: 800px;

        }

        button.go-back {
            display: block;
    margin-right: 60px;
    background-color: #EDCD1F;
    border-radius: 9px;
    height: 40px;
    width: 150px;
    border: none;
    cursor: pointer;}
    

        button.go-back:hover {
            background-color: #C18D00;
            /* Darker yellow on hover */
        }

        header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: black;
    
    padding: 0px;
    color: #EDE8F5; 
    font-family: 'Times New Roman', Times, serif;
    
    

}

#header-image {
    width: 300px; /* Ensure the image scales down if necessary */
    height: auto; /* Maintain the image aspect ratio */
    margin-right: auto;
    position: relative;
   
    
}
header h1{
    color:#EDE8F5;
    margin-right: 800px;
  
}

body {
      background-color: #10162A;
      background-size: cover;
      background-position: center;
      margin: 0;
      height: 100vh;
      
    }
 
  
  form {
    margin: 0 auto;
    width: 800px;
  color: black;
    background-color: #EDE8F5;
    padding-left: 50px; /* Add space on the sides */
    padding-right: 50px;
    padding-bottom: 150px;
    padding-top: 50px;
    font-family: Arial, Helvetica, sans-serif;
    display: flex;
    flex-direction: column;
   
   
  }

  
#date {
    background-color: rgba(237.000, 232.000, 245.000, 1);
    opacity: 1;
    border: 1.000px solid rgba(0.000, 0.000, 0.000, 1);
    border-radius: 9px;
    transform: matrix(1.00, 0.00, 0.00, 1.00, 0, 0);
    width: 100%;
    height: 40px;
    
}






#category_id{
    background-color: rgba(237.000, 232.000, 245.000, 1);
    opacity: 1;
    border: 1.000px solid rgba(0.000, 0.000, 0.000, 1);
    border-radius: 9px;
    transform: matrix(1.00, 0.00, 0.00, 1.00, 0, 0);
    width: 100%;
    height: 40px;
}

#description{
  width: 100%;
  height: 100px;
  background-color: rgba(237.000, 232.000, 245.000, 1);
  opacity: 1;
  border: 1.000px solid rgba(0.000, 0.000, 0.000, 1);
  border-radius: 9px;
  transform: matrix(1.00, 0.00, 0.00, 1.00, 0, 0);
 
}

#photo{
    background-color: rgba(237.000, 232.000, 245.000, 1);
    opacity: 1;
    border: 1.000px solid rgba(0.000, 0.000, 0.000, 1);
    border-radius: 9px;
    transform: matrix(1.00, 0.00, 0.00, 1.00, 0, 0);
    width: 100%;
    height: 40px;
}

.go {
    display: block;
    margin-right: 60px;
    background-color: #EDCD1F;
    border-radius: 9px;
    height: 40px;
    width: 150px;
    border: none;
    cursor: pointer;
}

.go:hover {
    background-color: #C18D00;
}

 input[type="submit"]{
    display: block;
    margin: 0 auto;
    background-color: #EDCD1F;
    border-radius: 9px;
    height: 40px;
    width: 150px;
    cursor: pointer;
    
}
  

input[type="submit"] :hover{
    background-color: #C18D00;
}
#bottom-left-image {
    position: fixed; /* Use fixed positioning to keep it in place */
    bottom: 0px; /* Distance from the bottom */
    left: 430px; /* Distance from the left */
    opacity: 50;
    width: 150px; /* Ensure the image scales down if necessary */
    height: 150px; /* Maintain the image aspect ratio */
}

       
</style>
