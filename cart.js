  // Define a global variable to store the cart items
  var cartItems = [];

  // Function to add an item to the cart
  function addToCart(button) {
      var productReference = button.getAttribute('data-product-reference');
      var productName = button.getAttribute('data-product-name');
      var productPrice = button.getAttribute('data-product-price');

      // Check if the item is already in the cart
      var existingItem = cartItems.find(item => item.reference === productReference);

      if (existingItem) {
          // If the item is already in the cart, increase the quantity
          existingItem.quantity += 1;
      } else {
          // If the item is not in the cart, add a new item
          var cartItem = {
              reference: productReference,
              name: productName,
              price: productPrice,
              quantity: 1
          };
          cartItems.push(cartItem);
      }

      // Update the cart modal with the current items
      updateCartModal();
  }

  // Function to update the cart modal with current items
  function updateCartModal() {
      // Clear the existing content
      var cartItemsContainer = document.getElementById('cartItems');
      cartItemsContainer.innerHTML = '';

      // Add each item to the cart modal
      cartItems.forEach(function (item) {
          var cartItemDiv = document.createElement('div');
          cartItemDiv.classList.add('cart-item');
          cartItemDiv.innerHTML = `
              <p>${item.name} - DH${item.price} x ${item.quantity}</p>
              <button class="btn btn-sm btn-info" onclick="modifyQuantity('${item.reference}', 1)">+</button>
              <button class="btn btn-sm btn-warning" onclick="modifyQuantity('${item.reference}', -1)">-</button>
              <button class="btn btn-sm btn-danger" onclick="removeItem('${item.reference}')">Remove</button>
          `;
          cartItemsContainer.appendChild(cartItemDiv);
      });
  }

  // Function to modify the quantity of an item in the cart
  function modifyQuantity(reference, amount) {
      var item = cartItems.find(item => item.reference === reference);

      if (item) {
          // Increase or decrease the quantity
          item.quantity += amount;

          // If the quantity becomes zero or less, remove the item from the cart
          if (item.quantity <= 0) {
              removeItem(reference);
          }
      }

      // Update the cart modal with the current items
      updateCartModal();
  }

  // Function to remove an item from the cart
  function removeItem(reference) {
      cartItems = cartItems.filter(item => item.reference !== reference);

      // Update the cart modal with the current items
      updateCartModal();
  }

  // Function to handle the checkout button click
  function checkout() {
       function checkout() {
        // Check if the user is logged in (replace with your actual authentication logic)
        var isLoggedIn = checkUserLoggedIn();

        if (isLoggedIn) {
            // Calculate total price
            var totalPrice = calculateTotalPrice();

            // Create an order object
            var order = {
                creation_date: getCurrentDate(),
                total_price: totalPrice,
                bl: 0 // Assuming bl should be set to 0 by default
                // Add other fields as needed
            };

            // Add the order to the database (replace with your server-side logic)
            addOrderToDatabase(order);

            // Clear the cart
            cartItems = [];
            updateCartModal();

            // Display a success message or redirect to a confirmation page
            alert('Order placed successfully!');

        } else {
            // User is not logged in, display a login prompt or redirect to the login page
            alert('Please log in before checking out.');
            // You can redirect to the login page using window.location.href = 'login.php';
        }
    }

    // Function to check if the user is logged in (replace with your actual authentication logic)
    function checkUserLoggedIn() {
        // Assuming you have a session variable named 'user_id'
        return (typeof user_id !== 'undefined' && user_id !== null);
    }

    // Function to calculate the total price of items in the cart
    function calculateTotalPrice() {
        var totalPrice = 0;

        cartItems.forEach(function (item) {
            totalPrice += item.price * item.quantity;
        });

        return totalPrice;
    }

    // Function to get the current date in the format YYYY-MM-DD
    function getCurrentDate() {
        var currentDate = new Date();
        var year = currentDate.getFullYear();
        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        var day = ('0' + currentDate.getDate()).slice(-2);
        return year + '-' + month + '-' + day;
    }

    function addOrderToDatabase(order) {
      
        console.log('Order added to the database:', order);
    }
}