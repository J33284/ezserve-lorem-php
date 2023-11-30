   <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            border: 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            text-align: center;
        }

        .item-form {
            margin-top: 10px;
        }

        #items-container {
            max-height: 70vh; 
            overflow-y: auto; 
        }
    </style>
</head>
<body>

<div class="card-container" style="width: 70vw; margin: 90px 0 0 15%; height: 100vh">
    <div class="card pt-4" style="height: 100vh; margin-top: 120px">
        <form action="?action=add_packageAction" method="post">
            <h2>Add A Package</h2>
            <table class="table table-hover table-responsive">
                <tbody>
                    <tr>
                        <td>Package Name:</td>
                        <td colspan="3"><input type="text" name="packName" class="form-control" required></td>
                    </tr>
                </tbody>
            </table>

            <div id="items-container">
            </div>

            <div class="mt-3" style="text-align: center;">
                <button type="button" class="btn btn-primary" onclick="addItemForm()">Add Item</button>
                <button button id="save-package-btn" type="submit" class="btn btn-secondary">Save Package</button>
            </div>
        </form>
    

    <!-- Item Form Template -->
    <div id="item-form-template" class="item-form" style="display: none;">
       
        <h2 class="pt-2" style="border-top: 3px solid #fb7e00;">Add Item</h2>
        <table class="table table-hover table-responsive">
            
            <tbody>
                <tr>
                    <td>Category:</td>
                    <td><input type="text" name="categoryName[]" class="form-control" required></td>
                    <td>Service:</td>
                    <td><input type="text" name="serviceName[]" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><input type="text" name="Description[]" class="form-control" required></td>
                    <td>Color:</td>
                    <td><input type="text" name="color[]" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Quantity:</td>
                    <td>
                        <input type="number" min="1" name="quantity[]" class="form-control" required>
                    </td>
                    <td>Unit:</td>
                    <td>
                        <input type="text" name="unit[]" class="form-control" placeholder="" required>
                    </td>
                </tr>
                <tr>
                    <td>Size:</td>
                    <td><input type="text" name="size[]" class="form-control" required></td>
                    
                    <td>Price:</td>
                    <td colspan="2"><input type="number" name="price[]" class="form-control" step="0.01" placeholder="price per unit" required></td>
                </tr>
                <tr>
                    <td colspan="4"><input type="hidden" name="branchcode" value="<?= isset($_GET['branchcode']) ? $_GET['branchcode'] : ''; ?>"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
  document.getElementById('save-package-btn').disabled = true;
  
  var itemCount = 0;

    function addItemForm() {

        itemCount++;
        // Clone the item form template
        var template = document.getElementById('item-form-template');
        var clone = template.cloneNode(true);

        // Remove the 'item-form' class from the clone
        clone.classList.remove('item-form');

        // Make the clone visible
        clone.style.display = 'block';

        clone.querySelector('h2').innerText = 'Add Item #' + itemCount;
        // Reset values in the cloned form
        resetForm(clone);


        // Append the clone to the items container
        document.getElementById('items-container').appendChild(clone);

        document.getElementById('save-package-btn').disabled = false;
        document.getElementById('save-package-btn').classList.remove('btn-secondary');
        document.getElementById('save-package-btn').classList.add('btn-primary');
    }

    function resetForm(form) {
        // Reset values in the form
        var inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(function(input) {
            if (input.type !== 'hidden') {
                input.value = '';
            }
        });
    }
</script>