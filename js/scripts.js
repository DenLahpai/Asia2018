//function to check 2 empty fields
function check_two_fields(field1, field2) {
    var field1 = document.getElementById(field1);
    var field2 = document.getElementById(field2);

    if (field1.value == "") {
        field1.style.background = 'red';
    }

    if (field2.value == "") {
        field2.style.background = 'red';
    }

    if (field1.value == "" || field2.value == "") {
        document.getElementsByClassName('notice error')[0].innerHTML = "Please fill out the empty field in red!";
    }
    else {
        document.getElementById('buttonSubmit').type = 'Submit';
    }
}
