function toggleEdit() {
    var form = document.getElementById('profileForm');
    var inputs = form.getElementsByTagName('input');
    var pencilIcon = document.getElementById('pencilIcon');
    var updateButton = document.getElementById('updateButton');
    var cancelButton = document.getElementById('cancelButton');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = !inputs[i].readOnly;
    }

    if (updateButton.style.display === 'none') {
        updateButton.style.display = 'inline-block';
        cancelButton.style.display = 'inline-block';
        pencilIcon.classList.remove('bi-pencil-fill');
        pencilIcon.classList.add('bi-pencil');
    } else {
        updateButton.style.display = 'none';
        cancelButton.style.display = 'none';
        pencilIcon.classList.remove('bi-pencil');
        pencilIcon.classList.add('bi-pencil-fill');
    }
}

function cancelEdit() {
    var form = document.getElementById('profileForm');
    var inputs = form.getElementsByTagName('input');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = true;
    }

    var pencilIcon = document.getElementById('pencilIcon');
    var updateButton = document.getElementById('updateButton');
    var cancelButton = document.getElementById('cancelButton');

    updateButton.style.display = 'none';
    cancelButton.style.display = 'none';
    pencilIcon.classList.remove('bi-pencil');
    pencilIcon.classList.add('bi-pencil-fill');
}












function toggleBusinessInfo() {
    // Hide the list of businesses
    document.getElementById("businessList").style.display = "none";
    // Show the business info section
    document.getElementById("division1").style.display = "block";
    // Change the text of the "Register" button to "Back"
    document.getElementById("registerButton").style.display = "none";
    document.getElementById("backButton").style.display = "block";
  }

  function toggleBack() {
    // Show the list of businesses
    document.getElementById("businessList").style.display = "block";
    // Hide the business info section
    document.getElementById("division1").style.display = "none";
    // Change the text of the "Back" button to "Register your business"
    document.getElementById("registerButton").style.display = "block";
    document.getElementById("backButton").style.display = "none";
  }

  function toggleEditable() {
        // Toggle the readonly attribute on input fields
        toggleInputEditable("busName");
        toggleInputEditable("street");
        toggleInputEditable("phone");
        toggleButtonVisibility("saveButton");
        toggleButtonVisibility("cancelButton");

        var editButton = document.getElementById("editButton");
        editButton.style.display = editButton.style.display === "none" ? "block" : "none";
    }

    function toggleInputEditable(inputId) {
        var input = document.getElementById(inputId);
        input.readOnly = !input.readOnly;
    }


    function toggleButtonVisibility(buttonId) {
        var button = document.getElementById(buttonId);
        button.style.display = button.style.display === "none" ? "block" : "none";
    }

    //Onwer Business Script
    document.querySelectorAll('.view-business').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default link behavior
            var businessCode = button.getAttribute('data-businesscode');
            // Hide the business list
            document.getElementById('businessList').style.display = 'none';

            // Display the business details
            var detailsForm = document.getElementById('detailsForm');
            detailsForm.style.display = 'block';

            // Hide all business details and show the one corresponding to the clicked button
            document.querySelectorAll('.business-details').forEach(function (details) {
                details.style.display = 'none';
            });
            var businessDetails = document.getElementById('businessDetails' + businessCode);
            businessDetails.style.display = 'block';
            detailsForm.innerHTML = businessDetails.innerHTML;
        });
    });