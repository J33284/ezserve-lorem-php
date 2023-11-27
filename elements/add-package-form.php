   <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .card-container {
            width: 700px;
            margin-left: 200px;
        }

        .card {
            border: 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
            padding: 20px;
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
            max-height: 200px; 
            overflow-y: auto; 
        }
    </style>
</head>
<body>

<div class="card-container">
    <div class="card">
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

            <div style="text-align: center;">
                <button type="button" class="btn btn-secondary" onclick="addItemForm()">Add Item</button>
                <button button id="save-package-btn" type="submit" class="btn btn-primary">Save Package</button>
            </div>
        </form>
    

    <!-- Item Form Template -->
    <div id="item-form-template" class="item-form" style="display: none;">
        <hr>
        <h2>Add Item</h2>
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
                    <td colspan="3"><input type="text" name="Description[]" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Quantity:</td>
                    <td>
                        <input type="number" name="quantity[]" class="form-control" placeholder="by piece" required>
                    </td>
                    <td>Color:</td>
                    <td><input type="text" name="color[]" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Size:</td>
                    <td><input type="text" name="size[]" class="form-control" required></td>
                    <td>Price:</td>
                    <td colspan="2"><input type="number" name="price[]" class="form-control" step="0.01" required></td>
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
  
    function addItemForm() {
        // Clone the item form template
        var template = document.getElementById('item-form-template');
        var clone = template.cloneNode(true);

        // Remove the 'item-form' class from the clone
        clone.classList.remove('item-form');

        // Make the clone visible
        clone.style.display = 'block';

        // Reset values in the cloned form
        resetForm(clone);

        // Append the clone to the items container
        document.getElementById('items-container').appendChild(clone);

        document.getElementById('save-package-btn').disabled = false;
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