<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
        <img src="ll.png" alt="Centered Image" id="header-image">
        <h1>Warden Confirmation</h1>
        <button class="go-back" onclick="window.location.href='studentview.php';">Go Back</button>
    </header>

<body>

    <form action="foza.php" method="POST" enctype="multipart/form-data">
       
            <legend><strong>Report Fault</strong></legend>

           
        <label for="date">Select Date:</label><br>
        <input type="date"  id="date" name="CreatedAt" required ><br>

   

 <label for="cat">Select Category:</label><br>
<select id="cat" name="CategoryName" placeholder="Select a category"> <br>
  <option value="">Select one</option>
    <option value="2">Plumbing</option>
    <option value="1">Electrical</option>
    <option value="3">Infrastructure</option>
  
</select>
<br>

<label for="description">Description</label><br>
<textarea id="description" name="Description" rows="3" cols="40"   ></textarea><br>



 <label for="picture">Upload Picture:</label><br>
<input type="file" id="picture" name="PhotoID"><br><br><br>

<img src="Z:\Final project\fo2.png" alt="Bottom Left Image" id="bottom-left-image">


          <input type="submit" name="submit" value="Submit">

   
</form>

</body>

</html>



<!-- 
<?php 
//get values from

//isset is to check whether variable was created 
if(isset($_REQUEST['submit'])) { 

    require_once("config.php"); //cannot execute further without it

            $date = $_REQUEST['CreatedAt'];
            $category = $_REQUEST['CategoryName'];
            $description = $_REQUEST['Description'];
            $picture = time() . $_FILES['PhotoID']['name']; //adding a picture
            $dest  =  $picture; //IMage.jpg
            move_uploaded_file($_FILES['PhotoID']['tmp_name'], $dest);
            //                                  temoporary location   //dest is permanent storge location
 
            $htmlDescription = "<p>$description</p>" ;

            
            //connection to the db without $ and all capital letters
            $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

            //ERROR HANDLING, check that connection is going to work
            if ($conn->connect_error){
                die("<p class=\"error\"><strong> Connection failed, sorry:</strong>" . $conn->connect_error . "</p>");
            }

            //query instructions
            $sql = "INSERT INTO maintenanceticket (CreatedAt, CategoryName, Description)
                        VALUE  ('$date', '$category', $htmlDescription')";
            $sqlPhoto ="INSERT INTO photo(PhotoID)
              VALUE  ('$picture')";
                        
                        
                        
                        
                        
            $result = $conn->query($sql);

            //Error handling, check query success
            if ($result === FALSE){
                die("<p class=\"error\">Unable to update form !</p>");
            }

            //close the connection to the db
            $conn->close();

            echo "<p class=\"success\">Form added</p>";
            

}
?> -->
<style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Full height */
            margin: 0;
            /* Remove default margin */
            background-color: #10162A;
            /* Light background color */
        }

        .container {
            background-color: #10162A;
            /* Light green background */
            border: 2px solid #155724;
            /* Dark green border */
            padding: 20px;
            /* Padding inside the box */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        h2 {
            margin: 0;
            /* Remove margin from heading */
        }

        table {
            background-color: #EDE8F5;
            width: 80%;
            /* Increase width (adjust as needed) */
            height: 600px;
            border-collapse: collapse;
            /* Keep borders from double-spacing */
            margin: 20px auto;
            /* Add some margin above and below the table */
        }
        th, td {
    
    padding: 150px; /* Adjust this value to move results closer */
    text-align: left;
}
th {
    background-color: #f2f2f2;
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
        .yes-button,
        .no-button {
           
    margin-right: 60px;
    background-color: #EDCD1F;
    border-radius: 9px;
    height: 40px;
    width: 150px;
    border: none;
    cursor: pointer;
        }

        .yes-button:hover {
            background-color: #C18D00; /* Darker green on hover */
        }

        .no-button {
            background-color: #f44336; /* Red color */
        }

        .no-button:hover {
            background-color: red; /* Darker red on hover */
        }
    </style> -->