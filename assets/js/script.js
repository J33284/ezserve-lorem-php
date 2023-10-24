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

//owner_business page
//===============================================================================================

function toggleDivision1() {
    var division1 = document.getElementById('division1');
    var division2 = document.getElementById('division2');
    var registerButton = document.getElementById('registerButton');
    
    division1.style.display = 'block';
    division2.style.display = 'none';
    registerButton.innerHTML = '<i class="bi bi-arrow-left"></i><span> Back</span>';
    registerButton.setAttribute('onclick', 'toggleRegisterButton()');
}

function toggleDivision2() {
    var division1 = document.getElementById('division1');
    var division2 = document.getElementById('division2');
    
    division1.style.display = 'block';
    division2.style.display = 'block';
}
/*
function toggleRegisterButton() {
    var division1 = document.getElementById('division1');
    var registerButton = document.getElementById('registerButton');
    
    division1.style.display = 'none';
    division2.style.display = 'none';
    registerButton.innerHTML = '<i class="bi bi-plus-square"></i><span> Register your business here!</span>';
    registerButton.setAttribute('onclick', 'toggleDivision1()');
}*/

function toggleEditBusiness() {
    var inputs = document.querySelectorAll('#division1 input');
    var editButton = document.getElementById('editButton');
    var saveButton = document.getElementById('saveButton');
    var cancelButton = document.getElementById('cancelButton');
    
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = !inputs[i].readOnly;
    }
    
    editButton.style.display = 'none';
    saveButton.style.display = 'block';
    cancelButton.style.display = 'block';
}


function saveChanges() {
    // Logic to save changes goes here
    // For demo purposes, we'll just alert a message
    // Toggle back to read-only mode and hide save and cancel buttons
    toggleEditBusiness();
    toggleEdit2();
}

function cancelEditBusiness() {
    var inputs = document.querySelectorAll('#division1 input');
    var editButton = document.getElementById('editButton');
    var saveButton = document.getElementById('saveButton');
    var cancelButton = document.getElementById('cancelButton');
    
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = true;
    }
    
    editButton.style.display = 'block';
    saveButton.style.display = 'none';
    cancelButton.style.display = 'none';
}

function toggleEdit2() {
    var inputs = document.querySelectorAll('#division2 input');
    var editButton = document.getElementById('editButton2');
    var saveButton = document.getElementById('saveButton2');
    var cancelButton = document.getElementById('cancelButton2');
    
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = !inputs[i].readOnly;
    }
    
    editButton.style.display = 'none';
    saveButton.style.display = 'block';
    cancelButton.style.display = 'block';
}

function saveChanges2() {
    // Logic to save changes goes here
    
    // For demo purposes, we'll just alert a message 
    // Toggle back to read-only mode and hide save and cancel buttons
    toggleEdit2();
}

function cancelEdit2() {
    var inputs = document.querySelectorAll('#division2 input');
    var editButton = document.getElementById('editButton2');
    var saveButton = document.getElementById('saveButton2');
    var cancelButton = document.getElementById('cancelButton2');
    
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = true;
    }
    
    editButton.style.display = 'block';
    saveButton.style.display = 'none';
    cancelButton.style.display = 'none';
}

