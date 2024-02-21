
<title>Create a Package</title>

<?= element( 'header' ) ?>

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('assets/images/6060363.jpg'); /* Replace 'background-image.jpg' with your image file */
      background-size: cover;
      background-position: center;
      height: 90vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
	  
    }
    .form-container {
      background-color: rgba(255, 255, 255, 0.8); 
      padding: 20px;
      border-radius: 10px;
		
    }
  </style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h1 class="text-center mb-4">Pre-made Package</h1>
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Package</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

