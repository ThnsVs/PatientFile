


//Shows the paragraph targeted by getId and hides all others in the FieldWrap div. (Displays patient's details)
function showContentt(getId){

    for(var i = 0; i < 3; i++){

        var num = Number(i + 1);
        if(i + 1 == getId)
            document.getElementById('Content' + num.toString()).hidden = false;
        else
            document.getElementById('Content' + num.toString()).hidden = true;
    }
}

//Checks if given form number is displayed. If it's not, it displays it and hides the other two forms.
function showForm(formNum){

    //Working with the first (Patient Entry) form.
    if(formNum == 1){

        var form1 = document.getElementById('PatEntDiv');
        //If it's hidden, we show it and hide the other ones.
        if(window.getComputedStyle(form1).display === "none"){
            document.getElementById('PatEntDiv').style.display = "block";
            document.getElementById('PatDetDiv').style.display = "none";
            document.getElementById('PatEdDiv').style.display = "none";
        }//If it's not hidden, we hide it.
        else
            document.getElementById('PatEntDiv').style.display = "none";

    }//Working with the second (Patient Details) form.
    else if(formNum == 2){

        var form1 = document.getElementById('PatDetDiv');
        //If it's hidden, we show it and hide the other ones.
        if(window.getComputedStyle(form1).display === "none"){
            document.getElementById('PatDetDiv').style.display = "block";
            document.getElementById('PatEntDiv').style.display = "none";
            document.getElementById('PatEdDiv').style.display = "none";
        }//If it's not hidden, we hide it.
        else
            document.getElementById('PatDetDiv').style.display = "none";

    }//Working with the third (Patient Edit) form.
    else if(formNum == 3){

        var form1 = document.getElementById('PatEdDiv');
        //If it's hidden, we show it and hide the other ones.
        if(window.getComputedStyle(form1).display === "none"){
            document.getElementById('PatEdDiv').style.display = "block";
            document.getElementById('PatEntDiv').style.display = "none";
            document.getElementById('PatDetDiv').style.display = "none";
        }//If it's not hidden, we hide it.
        else
            document.getElementById('PatEdDiv').style.display = "none";

    }


}