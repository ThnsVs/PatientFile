<?php

    //Handling errors.
    require_once('GeneralResources/ErrorHandling_Config.php');

    $errorMessage = "";

    if(isset($_POST["LogIn"])){
        //Attempting to log in.
        require_once('GeneralResources/connPatientFile.php');

        $validInput = true;
        $stmt = $link->prepare("SELECT Passwordd, userID, docName FROM logincredentials WHERE Email = (?)");
        $stmt->bind_param("s", $email);
        //We don't really need to validate this email but let's do it just for the sake of it.
        if(!($email = filter_var($_POST['Email'])))
            $validInput = false;


        //If the user's input was valid, we proceed with DB operations.
        if($validInput){

            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($Passwordd, $userID, $docName);
            $stmt->fetch();

            //If the user's credentials are valid, they are granted access.
            if(password_verify($_POST['Password'], $Passwordd)){
                require_once('GeneralResources/Session_Config.php');
                $_SESSION["ID"] = $userID;
                $_SESSION["DOC_NAME"] = htmlSpecialChars($docName);
                $stmt->close();
                $link->close();
                header('Location: MainPage_PatientList.php');
            }
            else{
                $stmt->close();
                $link->close();
                $errorMessage =  "Email and Password don't match!";
            }

        }
        
    }

?>


<!DOCTYPE HTML>
<html lang="en">
    <head>

        <title>Login Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="LogInResources/LogIn.css">
        <script src="LogInResources/LogIn.js"></script>

    </head>
    </head>
    <body>

        <h1>Log In</h1>

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
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="Password" name="Password" required>
                    </div>
                    <p><?php echo $errorMessage;?></p>
                    <button type="submit" class="btn btn-primary" name="LogIn">Log In</button>
                    <button class="btn btn-secondary" name="Register"><a href="Registration.php">Register</a></button>
                    </form>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
    </body>
</html>