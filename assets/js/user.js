
function toggleButtonVisibility(buttonId) {
    var button = document.getElementById(buttonId);
    button.style.display = button.style.display === "none" ? "block" : "none";
}

    
///Business=========================================================

    function toggleEditable() {
        
        // Toggle the readonly attribute on input fields
        toggleButtonVisibility("saveBusiness");
        toggleButtonVisibility("cancelBusiness");
        toggleButtonVisibility("ViewBranch");
        toggleButtonVisibility("AddBranch");
        toggleButtonVisibility("filelabel1");
    
        // Toggle visibility of h6 and input fields
        toggleVisibility("busNameInput");
        toggleVisibility("aboutInput");
        toggleVisibility("contactInput");
        toggleVisibility("busName");
        toggleVisibility("about");
        toggleVisibility("phone");

    
        var editButton = document.getElementById("editButton");
        editButton.style.display = editButton.style.display === "none" ? "block" : "none";

    
    }
    
    function toggleVisibility(elementId) {
        var element = document.getElementById(elementId);
        element.style.display = element.style.display === "none" ? "block" : "none";
    }
    
    
    
    function previewImage(input) {
        console.log('Function called');
        var preview = document.getElementById('imagePreview');
        console.log('File:', input.files);

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onloadend = function () {
                console.log('Read successful');
                preview.src = reader.result;
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            console.log('No file selected or no files support');
            preview.src = "https://mdbootstrap.com/img/Photos/Others/placeholder.jpg";
        }
    }


//Branch=============================================
function toggleAddBranch(event) {
    const button = event.currentTarget;
    const businessCode = button.getAttribute("data-businesscode");
    const branchDetails = document.querySelector("#branch" + businessCode);
    branchDetails.style.display = branchDetails.style.display === "none" ? "block" : "none";
}

document.addEventListener("DOMContentLoaded", function() {
    const addBranchButtons = document.querySelectorAll(".add-branch-button");
    addBranchButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            toggleAddBranch(event);
        });
    });
});

function hideAddBranch(branchId) {
    document.getElementById('branch' + branchId).style.display = 'none';
}


function previewAddBranch(input) {
    var preview = document.getElementById('imageAddBranch');
    var file = input.files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        preview.style.display = null;
    }
}



function toggleViewBranch(event) {
    const button = event.currentTarget;
    const businessCode = button.getAttribute("data-businesscode");
    const branchDetails = document.querySelector("#branchDetails" + businessCode);
    branchDetails.style.display = branchDetails.style.display === "none" ? "block" : "none";
    
}

document.addEventListener("DOMContentLoaded", function() {
    const viewBranchButtons = document.querySelectorAll(".view-branch-button");
    viewBranchButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            toggleViewBranch(event);
        });
    });
});

function toggleEditBranch(branchCode) {
    // Toggle the readonly attribute on input fields
    toggleButtonVisibility(`saveBranch_${branchCode}`);
    toggleButtonVisibility(`deleteBranch${branchCode}`);
    toggleButtonVisibility(`cancelBranch_${branchCode}`);
    toggleButtonVisibility("ViewPackage");
    toggleButtonVisibility(`filelabel2_${branchCode}`);
    

    // Toggle visibility of h6 and input fields for the specific branch
    toggleVisibility(`branchNameInput_${branchCode}`);
    toggleVisibility(`addressInput_${branchCode}`);
    toggleVisibility(`coordinatesInput_${branchCode}`);
    toggleVisibility(`branchName_${branchCode}`);
    toggleVisibility(`address_${branchCode}`);
    toggleVisibility(`coordinates_${branchCode}`);

    var editBranch = document.getElementById(`editBranch_${branchCode}`);
    editBranch.style.display = editBranch.style.display === "none" ? "block" : "none";
}


            
function previewBranch(input, branchCode) {
    console.log('previewBranch function called');
    var previewBr = input.closest('.branch-details').querySelector('.imageBranchPreview_' + branchCode);

    console.log('File:', input.files);

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onloadend = function () {
            console.log('Read successful');
            previewBr.src = reader.result;
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        console.log('No file selected or no files support');
        previewBr.src = "https://mdbootstrap.com/img/Photos/Others/placeholder.jpg";
    }
}


/*function confirmDelete(branchCode) {
    var confirmation = confirm('Are you sure you want to delete this branch?');

    if (confirmation) {
        // If the user confirms, submit the form for deletion
        document.getElementById('deleteBranch' + branchCode).form.submit();
    }
}*/


