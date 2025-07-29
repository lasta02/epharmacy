//  let cart = [];

//   // Function to add items to the cart
//   function addToCart(medicineId, name, price) {
//       const item = {
//           id: medicineId,
//           name: name,
//           price: price,
//           quantity: 1
//       };
//       const existingItem = cart.find(itm => itm.id === medicineId);
//       if (existingItem) {
//           existingItem.quantity++;
//       } else {
//           cart.push(item);
//       }
//       alert(`${name} added to cart!`);
//       updateCartCount();
//   }

//   // Function to update cart item count
//   function updateCartCount() {
//       document.querySelector('.cart-count').innerText = cart.length;
//   }

//   // Example usage in the HTML
//   // <a href="javascript:addToCart('1', 'Sinex', 27);" class="cart-btn">Add to cart</a>


  const medicines = [
    { name: 'Sinex', price: 27, image: 'https://nepmed-uat.s3.ap-southeast-1.amazonaws.com/products/600x600/90576/sinex_tablet_10_s_BTNxNA%241.jpg' },
    { name: 'Flexon', price: 27, image: 'https://www.nepmeds.com.np/public/files/flexon-2-20200123084207-fmMXeu.jpg' },
    // Add more medicines...
  ];

  const medicineList = document.getElementById('medicine-list');
  medicines.forEach(medicine => {
    const card = document.createElement('div');
    card.classList.add('medicine-card');
    card.innerHTML = `
      <img src="${medicine.image}" alt="${medicine.name}">
      <h3>${medicine.name}</h3>
      <p>Rs ${medicine.price}</p>
      <button>Add to cart</button>
    `;
    medicineList.appendChild(card);
  });
  