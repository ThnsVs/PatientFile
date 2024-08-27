
//document.getElementById('Register').disabled = false;

//Checks to see if the passwords are matching.
function CheckPasswords(){
    if(document.getElementById('Password').value == document.getElementById('Password_2').value){
        document.getElementById('PasswordMessage').style.color = "green";
        document.getElementById('PasswordMessage').innerHTML = "Passwords match!";
        document.getElementById('Register').disabled = false;
    }
    else{
        document.getElementById('PasswordMessage').style.color = "red";
        document.getElementById('PasswordMessage').innerHTML = "Passwords do not match.";
        document.getElementById('Register').disabled = true;
    }
}