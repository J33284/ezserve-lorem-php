<div id="profile" class="profile">
  <div class="d-flex justify-content-between p-3">
    <h1>My Profile</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4" onclick="toggleEdit()">
      <i id="pencilIcon" class="bi bi-pencil-fill"></i>
    </a>
  </div>

<form id="profileForm" method="POST" action="usersAction.php">
  <div class="form">
    <div class="row g-3 p-4">
      <input type="text" class="form-control" name="fname" placeholder="First Name" required readonly>
      <input type="text" class="form-control" name="lname" placeholder="Last Name" required readonly>
      <input type="date" class="date form-control" name="birthday" placeholder="Birthday" required readonly>
      <input type="email" class="form-control" name="email" placeholder="Email Address" required readonly>
      <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" required readonly>
      <input type="text" class="form-control" name="username" placeholder="Username" required readonly>
      <input type="password" class="form-control" name="password" placeholder="Password" required readonly>
    </div>
  </div>
  <div class="d-flex justify-content-end p-3">
    <input type="hidden" name="action" value="update_user">
    <button type="submit" name="update" id="updateButton" class="btn-update btn btn-primary me-2" style="display: none">Update</button>
    <button type="button" name="cancel" id="cancelButton" class="btn-cancel btn btn-secondary" style="display: none" onclick="cancelEdit()">Cancel</button>
  </div>
</form>

  <script>
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
    
  </script>
</body>
</html>






<!--<div id="profile" class="profile">
  <div class="d-flex justify-content-between p-3">
    <h1>My Profile</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4">
      <i class="bi bi-pencil-fill"></i>
    </a>
  </div>

  <form method="POST" action="">
    <div class="form"> naka only read format dapat, unless gn edit
      <div class="row g-3 p-4">
        <input type="text"     class="form-control"       name="fname"    placeholder="First Name"    required>
        <input type="text"     class="form-control"       name="lname"    placeholder="Last Name"     required>
        <input type="date"     class="date form-control"  name="birthday" placeholder="Birthday"      required>
        <input type="email"    class="form-control"       name="email"    placeholder="Email Address" required>
        <input type="text"     class="form-control"       name="mobile"   placeholder="Mobile Number" required>
        <input type="text"     class="form-control"       name="username" placeholder="Username"      required>
        <input type="password" class="form-control"       name="password" placeholder="Password"      required>
      </div>
    </div>
    <div class="d-flex justify-content-end p-3">
      <button type="submit" name="update" class="btn-update btn btn-primary me-2">Update</button>
      <button type="submit" name="cancel" class="btn-cancel btn btn-secondary">Cancel</button>
    </div>
  </form>-->