
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input, textarea, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        button:hover:enabled {
            background-color: #45a049;
        }

        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .category {
            margin-bottom: 20px;
        }

        .item {
            margin-bottom: 10px;
        }

        .details {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <form method="post" action="?action=add_packageAction">
        <label for="packageName">Package Name:</label>
        <input type="text" name="packageName" required>

        <label for="packageDescription">Package Description:</label>
        <textarea name="packageDescription" required></textarea>

        <!-- Add Category Button -->
        <button type="button" onclick="addCategory()">Add Item Category</button>

        <div id="categoriesContainer"></div>

        <button type="submit" id="submitButton" disabled>Submit</button>
    </form>

    <script>
        let categoryId = 0;
        let categoryAdded = false; // Track if category is added
        let itemAdded = false; // Track if item is added
        let submitButton = document.getElementById("submitButton");

        function addCategory() {
            categoryId++;

            const container = document.getElementById("categoriesContainer");

            const categoryDiv = document.createElement("div");
            categoryDiv.classList.add("category");
            categoryDiv.innerHTML = `<hr><label>Category Name:</label><input type="text" name="category[${categoryId}][categoryName]" required>`;

            // Add Item Button
            categoryDiv.innerHTML += `<button type="button" onclick="addItem(${categoryId})">Add Item</button>`;

            container.appendChild(categoryDiv);

            // Enable the submit button if both category and item are added
            categoryAdded = true;
            enableSubmitButton();
        }

        function addItem(categoryId) {
            const container = document.getElementById("categoriesContainer");

            const itemDiv = document.createElement("div");
            itemDiv.classList.add("item");
            itemDiv.innerHTML = `<label>Item Name:</label><input type="text" name="category[${categoryId}][items][][itemName]" required>
                                 <label>Item Description:</label><textarea name="category[${categoryId}][items][][itemDescription]" required></textarea>
                                 <label>Quantity:</label><input type="number" name="category[${categoryId}][items][][quantity]" required>
                                 <label>Price:</label><input type="number" name="category[${categoryId}][items][][price]" required>`;

            // Add Item Details Button
            itemDiv.innerHTML += `<button type="button" onclick="addItemDetails(${categoryId}, ${itemDiv.children.length - 4})">Add Item Details</button>`;

            container.appendChild(itemDiv);

            // Enable the submit button if both category and item are added
            itemAdded = true;
            enableSubmitButton();
        }

        function addItemDetails(categoryId, itemCount) {
            const container = document.getElementById("categoriesContainer");

            const detailsDiv = document.createElement("div");
            detailsDiv.classList.add("details");
            detailsDiv.innerHTML = `<label>Item Detail:</label><input type="text" name="category[${categoryId}][items][${itemCount}][details][][fieldName]" required>
                                    <label>Value:</label><input type="text" name="category[${categoryId}][items][${itemCount}][details][][fieldValue]" required>`;

            container.appendChild(detailsDiv);
        }

        function enableSubmitButton() {
            // Enable the submit button if both category and item are added
            if (categoryAdded && itemAdded) {
                submitButton.disabled = false;
            }
        }
    </script>
</body>
</html>
