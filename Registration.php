<?php

    //Handling errors.
    //require_once('GeneralResources/ErrorHandling_Config.php');

    $errorMessage = "";

    if(isset($_POST["Register"])){

        //Connecting to DB.
        require_once('GeneralResources/connPatientFile.php');

        //Checking to see if the given email has already been submitted.
        $stmt = $link->prepare("SELECT Email FROM logincredentials WHERE Email = (?)");
        $stmt->bind_param("s", $email);
        $validInput = true;
        if(!($email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)))
            $validInput = false;

        //If the user's input is valid, we proceed with DB operations.
        if($validInput){
            
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0){
                $errorMessage = "Email is already in use!";
                $stmt->close();
            }
            else{//If the email is unique, we input the user's email and hashed password to our DB.
                $stmt->close();
                $stmt2 = $link->prepare("INSERT INTO logincredentials (Email, Passwordd, docName) VALUES (?, ?, ?)");
                $stmt2->bind_param("sss", $email2, $hashedPassword, $name);
                $email2 = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
                //Hashing password.
                $options = [ 'cost' => 12];
                $hashedPassword = password_hash($_POST['Password'], PASSWORD_BCRYPT, $options);
                $name = $_POST['Name'];
                $stmt2->execute();
                $stmt2->close();
                $errorMessage = "Registration successful!";
            }

        }
        else
            $errorMessage = "Your input was invalid!";



        //header("Location: " . $_SERVER['PHP_SELF']);
        //exit();

        $link->close();
    }

?>

<!DOCTYPE HTML>
<html lang="en">
    <head>

        <title>LogIn Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="RegistrationResources/Registration1.css">
        <script src="RegistrationResources/Registration1.js"></script>

    </head>

    <body>

        <h1>Register</h1>

        <div class="container w-100 h-100 pt-1 ">
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-8">
                    <!--Login Form -->
                    <form name="LogIn" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="Email" name="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="Name" name="Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="Password" name="Password" onkeyup="CheckPasswords();" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Re-enter Password</label>
                        <input type="password" class="form-control" id="Password_2" name="Password_2" onkeyup="CheckPasswords();" required minlength="8">
                    </div>
                    <p id="PasswordMessage"></p>
                    <p><?php echo htmlspecialchars($errorMessage);?></p>
                    <button type="submit" class="btn btn-primary" name="Register" id="Register" disabled>Register</button>
                    <button class="btn btn-secondary" name="LogIn"><a href="Log_In.php">Login</a></button>
                    </form>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>

    </body>
</html>