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
  