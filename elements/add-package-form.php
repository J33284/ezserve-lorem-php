
    <div class="container form-container">
        <form method="post" action="add_packageAction.php">
            <label for="packageName">Package Name:</label>
            <input type="text" name="packageName" id="packageName" class="form-control" required>

            <h2 style ="margin-left: 170px; margin-top:100px;">Add A Package</h2>
            <table class="table table-hover table-responsive" style="width: 90%; height: 100px; margin-top:150px; margin-left: 170px;">
                <thead>
                    <tr>
                        <th scope="col">Package Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Service</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Color</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        
                        <td><input type="text" name="packName" class="form-control" required></td>
                        <td><input type="text" name="categoryName" class="form-control" required></td>
                        <td><input type="text" name="seviceName" class="form-control" required></td>
                        <td><input type="text" name="Description" class="form-control" required></td>
                        <td><input type="number" name="quantity" class="form-control" required></td>
                        <td><input type="text" name="color" class="form-control" required></td>
                        <td><input type="number" name="price" class="form-control" step="0.01" required></td>
                    </tr>
                </tbody>
            </table>
            <div>
            <button type="submit" class="btn btn-primary" style ="margin-left: 170px;">Save Package</button>
        </div>
        </form>
    </div>


