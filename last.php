<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
    

<?php 
//get values from

//isset is to check whether variable was created 
if(isset($_REQUEST['submit'])) { 

require_once("cfig.php"); //cannot execute further without it

            $productLine = $_REQUEST['productLine'];
            $textDescription = $_REQUEST['textDescription'];
            $picture = time() . $_FILES['picture']['name']; //adding a picture
            $dest  =  $picture; //IMage.jpg
            move_uploaded_file($_FILES['picture']['tmp_name'], $dest);
            //                                    temoporary location   //dest is permanent storge location

            $htmlDescription = "<p>$textDescription</p>" ;
            //connection to the db without $ and all capital letters
            $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

            //ERROR HANDLING, check that connection is going to work
            if ($conn->connect_error){
                die("<p class=\"error\"><strong> Connection failed, sorry:</strong>" . $conn->connect_error . "</p>");
            }

            //query instructions
            $sql = "INSERT INTO productlines(productLine, textDescription, htmlDescription, picture)
                        VALUE ('$productLine', '$textDescription', $htmlDescription', '$picture')";
                        
            $result = $conn->query($sql);

            //Error handling, check query success
            if ($result === FALSE){
                die("<p class=\"error\">Unable to add new productline!</p>");
            }

            //close the connection to the db
            $conn->close();

            echo "<p class=\"success\">The new product line was successfully added</p>";
}
?>
<form action="p3ex2.php" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend><strong>Add a new product line</strong></legend>
       
        <label for="pline">Product line:</label><br>
        <input type="text" name="pline"  id="pline" required ><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="3" cols="40" required ></textarea><br>
        
        <label for="picture">Picture:</label><br>
        <input type="file" id="picture" name="picture"><br></br>

       <input type="submit" name="submit" value="Add" >

    </fieldset>

</form>

</body>
 </html>
