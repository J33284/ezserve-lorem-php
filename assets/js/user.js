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


    //BRANCH SCRIPT
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

    //BUTTONS SCRIPT
   function toggleBack() {
        // Show the list of businesses
        document.getElementById("businessList").style.display = "block";
        // Hide the business info section
        document.getElementById("detailsForm").style.display = "none";
        // Change the text of the "Back" button to "Register your business"
        document.getElementById("registerButton").style.display = "block";
        document.getElementById("backButton").style.display = "none";

        location.reload();
   }

    function toggleView() {
        // Show the list of businesses
        document.getElementById("businessList").style.display = "block";
        // Hide the business info section
        document.getElementById("detailsForm").style.display = "none";
        // Change the text of the "Back" button to "Register your business"
        document.getElementById("registerButton").style.display = "none";
        document.getElementById("backButton").style.display = "block";

    }

    
    function toggleEditable() {
        // Toggle the readonly attribute on input fields
        toggleInputEditable("busName");
        toggleInputEditable("about");
        toggleInputEditable("phone");
        toggleButtonVisibility("saveBusiness");
        toggleButtonVisibility("cancelBusiness");
        toggleButtonVisibility("ViewBranch");
        toggleButtonVisibility("AddBranch");
    
        var editButton = document.getElementById("editButton");
        editButton.style.display = editButton.style.display === "none" ? "block" : "none";
        
        // Store the initial values of the input fields
        var initialBusNameValue = document.getElementById("busName").value;
        var initialAboutValue = document.getElementById("about").value;
        var initialPhoneValue = document.getElementById("phone").value;
    
        // Add an event listener to hide the "Cancel" button when it's clicked
        document.getElementById("cancelBusiness").addEventListener('click', function () {
            var busNameInput = document.getElementById("busName");
            var aboutInput = document.getElementById("about");
            var phoneInput = document.getElementById("phone");
    
            // Set the input field values to their initial values (clearing any changes)
            busNameInput.value = initialBusNameValue;
            aboutInput.value = initialAboutValue;
            phoneInput.value = initialPhoneValue;
    
            toggleInputEditable("busName");
            toggleInputEditable("about");
            toggleInputEditable("phone");
            toggleButtonVisibility("ViewBranch");
            toggleButtonVisibility("AddBranch");
            editButton.style.display = "block"; // Show the "Edit" button again
        });
    }
    


//=====================BRANCH==============================

//VIEW
    function toggleViewBranch(button) {
        const businessCode = button.getAttribute("data-businesscode");
        const branchDetails = document.querySelector("#branchDetails" + businessCode);
        branchDetails.style.display = branchDetails.style.display === "none" ? "block" : "none";


        
    }
 

    const viewBranchButtons = document.querySelectorAll(".view-branch-button");
    viewBranchButtons.forEach(button => {
        button.addEventListener("click", () => toggleViewBranch(button));
    });

    function toggleEditBranch(branchCode) {
        // Find the input fields within the branch details section
        var branchNameInput = document.getElementById('branchName' + branchCode);
        var addressInput = document.getElementById('address' + branchCode);
        var coordinatesInput = document.getElementById('coordinates' + branchCode);
    
        // Make the input fields editable
        branchNameInput.removeAttribute('readonly');
        addressInput.removeAttribute('readonly');
        coordinatesInput.removeAttribute('readonly');
    
        // Show the "Save" and "Cancel" buttons for this specific branch
        var saveButton = document.getElementById('updateBranch' + branchCode);
        var cancelButton = document.getElementById('cancelBranch' + branchCode);
    
        // Show the "Cancel" button
        cancelButton.style.display = 'block';
        saveButton.style.display = 'block';

        // Hide the "Edit" button for this branch
        var editButton = document.getElementById('editBranch' + branchCode);
        editButton.style.display = 'none';

        var initialBranchNameValue = branchNameInput.value;
        var initialAddressValue = addressInput.value;
        var initialCoordinatesValue = coordinatesInput.value;
    
        // Add an event listener to the "Cancel" button to make fields non-editable and hide buttons
        cancelButton.addEventListener('click', function () {
            // Make the input fields read-only
            branchNameInput.readOnly = true;
            addressInput.readOnly = true;
            coordinatesInput.readOnly = true;
            
    
            // Hide the "Save" and "Cancel" buttons
            saveButton.style.display = 'none';
            cancelButton.style.display = 'none';
    
            // Show the "Edit" button again
            editButton.style.display = 'block';

            branchNameInput.value = initialBranchNameValue;
            addressInput.value = initialAddressValue;
            coordinatesInput.value = initialCoordinatesValue;
        });
    }
    
           
// ADD BRANCH
function toggleAddBranch(button) {
    const businessCode = button.getAttribute("data-businesscode");
    const branchDetails = document.querySelector("#branch" + businessCode);
    branchDetails.style.display = branchDetails.style.display === "none" ? "block" : "none";
}

const addBranchButtons = document.querySelectorAll(".add-branch-button");
addBranchButtons.forEach(button => {
    button.addEventListener("click", () => toggleAddBranch(button)); // <-- Corrected function name here
});



function previewImage(input) {
    // Check if a file is selected
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            // Update the image source and display it
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            
        };

        // Read the file as a data URL
        reader.readAsDataURL(input.files[0]);
    }
}
//PACKAGE


