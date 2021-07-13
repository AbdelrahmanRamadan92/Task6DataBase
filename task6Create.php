<?php
require("dbConnection.php");

if($_SERVER['REQUEST_METHOD'] == "POST" ){

   $name  = $_POST['name'];
   $content = $_POST['content']; 

    if(!empty($_FILES['image']['name'])){
       // CODE ... 
     $tmp_path = $_FILES['image']['tmp_name'];
     $imgName  = $_FILES['image']['name'];
     $size     = $_FILES['image']['size'];
     $type     = $_FILES['image']['type'];
       

     $nameArray = explode('.',$imgName);
     $FileExtension = strtolower($nameArray[1]);

     $FinalName = rand().time().'.'.$FileExtension;

      $allowedExtension = ['png','jpg'];    

       if(in_array($FileExtension,$allowedExtension)){
        // code ....
      
        $disFolder = './uploads/';
        
        $disPath  = $disFolder.$FinalName;

         if(move_uploaded_file($tmp_path,$disPath))
           {
              echo 'File Uploaded';

           }else{
               echo 'Error In upload try again';
           }

       }else{

        echo '* extension not allowed';
       }
    

       



    }else{

        echo '*  please  Upload File';
    }




    $sql= "insert into posts (name,content,image) value ('$name','$content','$imgName') ";
    $op = mysqli_query($con,$sql);

    if ($op) {
        echo "data inserted";
    }
    else{
        echo "try again";
    }
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Insert Data</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>posts</h2>
  <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text"  name="name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Title">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">content</label>
    <input type="text" name="content" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter content">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1"> Image</label>
    <input type="file"  name="image" >
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</body>
</html>