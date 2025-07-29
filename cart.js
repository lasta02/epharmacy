let cart = [];
    const cartSidebar = document.getElementById('cartSidebar');
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const cartCount = document.getElementById('cart-count');

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
      cartCount.innerText = cart.reduce((acc, item) => acc + item.quantity, 0);
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
      if (cartSidebar.classList.contains('active')) {
        cartItemsContainer.scrollTop = 0;
      }
    }

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

    document.getElementById('cartIcon').addEventListener('click', (e) => {
      e.preventDefault();
      toggleCart();
    });

    document.getElementById('cartClose').addEventListener('click', toggleCart);