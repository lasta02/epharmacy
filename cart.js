
  // Define your cart as before
  let cart = [];

  const cartSidebar = document.getElementById('cartSidebar');
  const cartItemsContainer = document.getElementById('cartItems');
  const cartTotal = document.getElementById('cartTotal');
  const cartCount = document.getElementById('cart-count'); // optional if used

  function addToCart(product) {
    const existingProduct = cart.find(item => item.id === product.id);
    if (existingProduct) {
      existingProduct.quantity++;
    } else {
      cart.push({ ...product, quantity: 1 });
    }
    updateCart();
  }

  function updateCart() {
    cartItemsContainer.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
      total += item.price * item.quantity;
      const cartItem = document.createElement('div');
      cartItem.className = 'cart-item';
      cartItem.innerHTML = `
        <img src="${item.image}" alt="${item.name}">
        <div class="cart-item-details">
          <div class="cart-item-title">${item.name}</div>
          <div class="cart-item-price">Rs ${item.price} x ${item.quantity}</div>
          <div class="cart-item-quantity">
            <button class="quantity-btn" onclick="changeQuantity(${item.id}, -1)">-</button>
            <span>${item.quantity}</span>
            <button class="quantity-btn" onclick="changeQuantity(${item.id}, 1)">+</button>
          </div>
        </div>
      `;
      cartItemsContainer.appendChild(cartItem);
    });

    cartTotal.innerText = `Rs ${total.toFixed(2)}`;
    if (cartCount) {
      cartCount.innerText = cart.reduce((acc, item) => acc + item.quantity, 0);
    }
  }

  function changeQuantity(id, delta) {
    const product = cart.find(item => item.id == id);
    if (product) {
      product.quantity += delta;
      if (product.quantity <= 0) {
        cart = cart.filter(item => item.id != id);
      }
      updateCart();
    }
  }

  function toggleCart() {
    cartSidebar.classList.toggle('active');
    cartItemsContainer.scrollTop = 0;
  }

  // Add product buttons
  document.querySelectorAll('.cart-btn').forEach(button => {
    button.addEventListener('click', (event) => {
      const productBox = event.target.closest('.box');
      const product = {
        id: productBox.dataset.id,
        name: productBox.dataset.name,
        price: parseFloat(productBox.dataset.price),
        image: productBox.dataset.image
      };
      addToCart(product);
      toggleCart();
    });
  });

  // Cart open/close buttons
  document.getElementById('cartIcon')?.addEventListener('click', (e) => {
    e.preventDefault();
    toggleCart();
  });

  document.getElementById('cartClose')?.addEventListener('click', toggleCart);

  // Khalti configuration
  const khaltiConfig = {
    publicKey: "test_public_key_xxxxx", // replace with your actual Khalti public key
    productIdentity: "cart-products",
    productName: "My Shop Order",
    productUrl: "http://localhost:8000", // change to your site URL
    eventHandler: {
      onSuccess(payload) {
        console.log("Payment success:", payload);

        // Example: Send payload to backend for verification
        fetch('/payment/verification', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token
          },
          body: JSON.stringify({
            token: payload.token,
            amount: payload.amount
          })
        })
        .then(res => res.json())
        .then(data => {
          console.log("Server verification response:", data);
          alert("Payment successful!");
        })
        .catch(err => {
          console.error("Verification failed", err);
          alert("Payment verification failed.");
        });
      },
      onError(error) {
        console.error("Khalti error:", error);
        alert("Something went wrong during payment.");
      },
      onClose() {
        console.log("Khalti widget is closing");
      }
    }
  };

  const checkout = new KhaltiCheckout(khaltiConfig);

  // ✅ Proceed to Checkout button handler
  document.querySelector('.checkout-btn').addEventListener('click', function () {
    let total = 0;
    cart.forEach(item => {
      total += item.price * item.quantity;
    });

    if (total <= 0) {
      alert("Your cart is empty!");
      return;
    }

    // Convert to paisa before sending to Khalti (Rs → paisa)
    checkout.show({ amount: total * 100 });
  });

