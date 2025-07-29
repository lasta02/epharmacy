// User Auth
function register(username, password) {
  fetch('php/register.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
  }).then(res => res.json()).then(data => {
    if (data.success) alert('Registered! Please log in.');
    else alert(data.error);
  });
}

function login(username, password) {
  fetch('php/login.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
  }).then(res => res.json()).then(data => {
    if (data.success) location.reload();
    else alert(data.error);
  });
}

function logout() {
  fetch('php/logout.php').then(() => location.reload());
}

// Product Rendering
function loadProducts() {
  fetch('php/products.php')
    .then(res => res.json())
    .then(products => {
      // Render products dynamically in your HTML
    });
}

// Cart
function addToCart(id, qty=1) {
  fetch('php/cart.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `action=add&id=${id}&qty=${qty}`
  }).then(res => res.json()).then(cart => {
    // Update cart UI
  });
}

function updateCart(id, qty) {
  fetch('php/cart.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `action=update&id=${id}&qty=${qty}`
  }).then(res => res.json()).then(cart => {
    // Update cart UI
  });
}

function removeFromCart(id) {
  fetch('php/cart.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `action=remove&id=${id}`
  }).then(res => res.json()).then(cart => {
    // Update cart UI
  });
}

// Checkout
function checkout() {
  fetch('php/checkout.php', { method: 'POST' })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Redirect to PayPal
        window.location.href = `https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&business=YOUR_PAYPAL_EMAIL&item_name=Order+${data.order_id}&amount=${data.total}&currency_code=USD`;
      } else {
        alert(data.error);
      }
    });
}

// Order History
function loadOrderHistory() {
  fetch('php/order_history.php')
    .then(res => res.json())
    .then(orders => {
      // Render orders in your HTML
    });
}