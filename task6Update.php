<?php 

   require 'dbConnection.php';
    
   $id = $_GET['id'];
   $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
  
   $message = "";

   if(!filter_var($id,FILTER_VALIDATE_INT)){

    $_SESSION['message'] = "Invalid Id";

    header("Locattion: task6Index.php");
   }


   # Clean input ...
   function CleanInputs($input){

    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
  }

    $errorMessages = array();
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

          $sql  = "update posts set name='$name' , content ='$content' , image ='$imgname'  where id =$id ";
     
          $op   =  mysqli_query($con,$sql);

          //mysqli_error($con);

       if($op){
           $_SESSION['message'] = "Record Updated";
            header("Location: task6Index.php");
       }else{
        $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
    }



     }else{

     // print error messages 
     foreach($errorMessages as $key => $value){

        echo '* '.$key.' : '.$value.'<br>';
         }
       }
    }







   


  
    // Fetch single Row of Data .... 
     $sql = "select * from posts where id = $id";
     $op = mysqli_query($con,$sql); 
     $data = mysqli_fetch_assoc($op);
  
    



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Edit Data </h2>
  <form  method="post"  action="task6Update.php?id=<?php echo $data['id'];?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text"  name="name"   value="<?php echo $data['name'];?>"   class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail1">Content</label>
    <input type="text" name="content"  value="<?php echo $data['content'];?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>


  <div class="form-group">
    <label for="exampleInputPassword1">Birth Date</label>
    <input type="file"  name="image"   value="<?php echo $data['image'];?>"  class="form-control" >
  </div>


  
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>

</body>
</html>
