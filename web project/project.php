
<head>

   
<title>rejestration</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<meta name="viewport"contenr="width=device-width,intial-scalw=1.0">
</head>

<body>
    
<div class="container">
   <?php
 



if(isset($_POST["submit"])){
$fullname = $_POST["fullname"];
$email = $_POST["email"];
$Password = $_POST["Password"];
$PasswordRepeat = $_POST["Repeat_Password"];
$phone = $_POST["phone"];
$city = $_POST["city"];
$Password_Hash = password_hash($Password,PASSWORD_DEFAULT);

$errors = array();//empty bo zaniny away ka hamu fieldakan prkrawnatawa yan na
if (empty($fullname) or empty($email) or empty($Password) or empty($PasswordRepeat) or empty($phone) or empty($city)){
array_push($errors,"all fields are required");
}
//bo dlnia bunawa la emalaka
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
   array_push($errors,"Email is not valid");
}
if (strlen($Password)<8) {//boi passwordaka la 8 pit kamtr nabet
array_push($errors,"password must be 8 charecters long enogh");
}
if ($Password!==$PasswordRepeat) {//boi bzanin passwordaka yaksana yan na
array_push($errors,"password does not match");
}
require_once "database.php";
$sql ="SELECT * FROM users WHERE email ='$email'";//boi emaly dubara war nagret
$result = mysqli_query($conn, $sql);
$rowCount = mysqli_num_rows($result);
if ($rowCount) {
   array_push($errors,"Email already exists!");
}

if (count($errors)>0) {
   foreach ($errors as  $errors) {
echo "<div class ='alert alert-danger'>$errors</div>";
      
}
}
else{
   //we will insert the data into database
 
   $sql ="INSERT INTO users (full_name, email, password, phone, city)VALUES (?,?,?,?,?)";//($fullname, $email, $Password, $phone, $city) amashian akret bas bo sql injection asantra shkani
$stmt = mysqli_stmt_init($conn);
$preparestmt = mysqli_stmt_prepare($stmt,$sql);
if ($preparestmt) {
   mysqli_stmt_bind_param($stmt,"sssss", $fullname, $email, $Password_Hash, $phone, $city);
   mysqli_stmt_execute($stmt);
  // echo "<div class ='alert alert-success'>you are regestered successfuly.</div>";
  echo "<div class='alert alert-success'>You are registered successfully. Redirecting to login...</div>";
  header("refresh: 2; url=login.php");// Redirect after 2 seconds
  exit(); 

}
else {
   die("somthing went worng 2");
}
}

}
   ?>
    <form action="project.php" method="post">
        <div class="form-gruop">
            <input type="text" class="form-control" name="fullname"placeholder="Name:"> 
         </div>
         <div class="form-gruop">
           <input type="email" class="form-control" name="email" placeholder="Email:"> 
         </div>
         <div class="form-gruop">
            <input type="password" class="form-control" name="Password" placeholder="Password:"> 
         </div>
         <div class="form-gruop">
            <input type="password" class="form-control" name="Repeat_Password" placeholder="Repeat Password:"> 
         </div>
         <div class="form-gruop">
            <input type="tel" class="form-control" name="phone" placeholder="Phone:"> 
         </div>
         <div class="form-gruop">
            <input type="text" class="form-control" name="city" placeholder="City:"> 
         </div>
         <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Resister" name="submit" > 
         </div>
    </form>
</div>

</body>
</html>