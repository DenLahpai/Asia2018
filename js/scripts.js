//function to check 2 empty fields
function check_fields(field1, field2, field3) {
    var field1 = document.getElementById(field1);
    var field2 = document.getElementById(field2);
    var field3 = document.getElementById(field3);

    if (field1.value == "") {
        field1.style.background = 'red';
    }

    if (field2.value == "") {
        field2.style.background = 'red';
    }

    if (field3.value == "") {
        field3.style.background = 'red';
    }

    if (field1.value == "" || field2.value == "" || field3.value == "") {
        document.getElementsByClassName('notice error')[0].innerHTML = "Please fill out the empty field in red!";
        // alert("Please fill out the empty field(s) in red");
    }
    else {
        document.getElementById('buttonSubmit').type = 'Submit';
    }
}
