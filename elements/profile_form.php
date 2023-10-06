<div id="profile" class="profile">
  <div class="d-flex justify-content-between p-3">
    <h1>My Profile</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4">
      <i class="bi bi-pencil-fill"></i>
    </a>
  </div>

  <form method="POST" action="">
    <div class="form"> <!-- naka only read format dapat, unless gn edit-->
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
      <button type="submit" name="update" class="btn-update btn-primary me-2">Update</button>
      <button type="submit" name="cancel" class="btn-cancel btn-secondary">Cancel</button>
    </div>
  </form>