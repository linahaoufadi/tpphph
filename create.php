<?php
 $errorMsg="";
 $fnameValue = "";
    
 $lnameValue = "";
 
 $emailValue = "";

 $successMsg ="";

 include ("connection.php");
 $connection=new Connection();
 include ("client.php");
 $connection->selectDatabase("poog4");

if(isset($_POST['submit'])){

    $fnameValue = $_POST['firstName'];
    
    $lnameValue = $_POST['lastName'];
    
    $emailValue = $_POST['email'];
    
    $passValue = $_POST['password'];

    $idCityValue = $_POST['cities'];

    if(empty($fnameValue) ||empty($lnameValue) ||empty($emailValue) ||empty($passValue)){

    $errorMsg = "all fields must be filled in";

    }else if(strlen($passValue)<8){
        $errorMsg = "password must contains at least 8 char";

    }else if(preg_match('/[A-Z]+/',$passValue)==0){
        $errorMsg = "password must contains at least one capital letter";

    }else{


        $client= new Client($fnameValue,$lnameValue,$emailValue,$passValue,$idCityValue);
        $client->insertClient("clients",$connection->conn);
        $errorMsg=Client::$errorMsg;
        $successMsg=Client::$successMsg;
    }


}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5 ">

        <h2>SIGN UP</h2>


        <?php

        if(!empty($errorMsg)){
            echo " <div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong> $errorMsg</strong>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
  </button>
  </div>" ;
        }

?>
        <br>
        <form method="post">
            <div class="row mb-3">
                    <label class="col-form-label col-sm-1" for="fname">First Name:</label>
                    <div class="col-sm-6">
                        <input  value="<?php  echo $fnameValue?>"  class="form-control" type="text" id="fname" name="firstName">
                    </div>
            </div>
            <div class="row mb-3">
                    <label class="col-form-label col-sm-1" for="lname">Last Name:</label>
                    <div class="col-sm-6">
                        <input  value="<?php  echo $lnameValue?>" class="form-control" type="text" id="lname" name="lastName">
                    </div>
            </div>
            <div class="row mb-3 ">
                    <label class="col-form-label col-sm-1" for="email">Email:</label>
                    <div class="col-sm-6">
                        <input  value="<?php  echo $emailValue?>"  class="form-control" type="email" id="email" name="email">
                    </div>
            </div>
            <div class="row mb-3">
            <label class="col-form-label col-sm-1" for="cities">Cities:</label>
            <div class="col-sm-6">
                <select name='cities' class="form-select">
                <option selected>Select your city</option>
           <?php

            include("City.php");
            $cities = City::selectAllCities('Cities',$connection->conn);
            foreach($cities as $city){
                echo "<option value='$city[id]' >$city[cityName]</option>";

            }

           ?>
                </select>
                </div>
   </div>
            <div class="row mb-3 ">
                    <label class="col-form-label col-sm-1" for="password">Password:</label>
                    <div class="col-sm-6">
                        <input class="form-control" type="password" id="password" name="password" >
                    </div>
            </div>


<?php
            if(!empty($successMsg)){
            echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong> $successMsg</strong>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
  </button>
  </div>" ;
        }
      
?>
            <div class="row mb-3">
                    <div class="offset-sm-1 col-sm-3 d-grid">
                        <button name="submit" type="submit" class=" btn btn-primary">Signup</button>
                    </div>
                    <div class="col-sm-1 col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" >Login</a>
                    </div>
            </div>
        </form>

    </div>


</body>
</html>