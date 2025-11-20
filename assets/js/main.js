// main js    console.log('NextGen E-Commerce');

/* ------------------------------
   GLOBAL TOAST / ALERT SYSTEM
------------------------------ */
function showAlert(message, type = "success") {
    const alertBox = document.createElement("div");
    alertBox.className = `alert alert-${type}`;
    alertBox.innerText = message;

    document.body.appendChild(alertBox);

    setTimeout(() => {
        alertBox.style.opacity = "0";
        setTimeout(() => alertBox.remove(), 500);
    }, 2000);
}

/* ------------------------------
   MOBILE NAVIGATION TOGGLE
------------------------------ */
const menuBtn = document.querySelector("#menu-btn");
const navMenu = document.querySelector(".navbar ul");

if (menuBtn) {
    menuBtn.addEventListener("click", () => {
        navMenu.style.display =
            navMenu.style.display === "flex" ? "none" : "flex";
    });
}

/* ------------------------------
   ADD TO CART SYSTEM (LocalStorage)
------------------------------ */
function addToCart(productId, name, price, image) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Check if product already exists
    const exists = cart.find(item => item.id === productId);
    if (exists) {
        exists.qty += 1;
    } else {
        cart.push({
            id: productId,
            name,
            price,
            image,
            qty: 1
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    showAlert("Product added to cart!", "success");
}

/* ------------------------------
   LOAD CART ITEMS ON CART PAGE
------------------------------ */
function loadCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartContainer = document.getElementById("cart-items");

    if (!cartContainer) return;

    cartContainer.innerHTML = "";

    if (cart.length === 0) {
        cartContainer.innerHTML = "<p>Your cart is empty.</p>";
        return;
    }

    let total = 0;

    cart.forEach(item => {
        total += item.price * item.qty;

        cartContainer.innerHTML += `
            <div class="product-card">
                <img src="${item.image}">
                <h4>${item.name}</h4>
                <p>Price: ${item.price} BDT</p>
                <p>Qty: ${item.qty}</p>
                <button class="btn-danger" onclick="removeFromCart(${item.id})">Remove</button>
            </div>
        `;
    });

    document.getElementById("cart-total").innerText = total + " BDT";
}

/* ------------------------------
   REMOVE ITEM FROM CART
------------------------------ */
function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart();
}

/* ------------------------------
   REALTIME SEARCH
------------------------------ */
const searchInput = document.querySelector("#search");

if (searchInput) {
    searchInput.addEventListener("keyup", function () {
        const keyword = this.value.toLowerCase();
        const items = document.querySelectorAll(".product-card");

        items.forEach(item => {
            const name = item.querySelector("h3, h4, h2").innerText.toLowerCase();
            item.style.display = name.includes(keyword) ? "block" : "none";
        });
    });
}

/* ------------------------------
   INIT PAGE FUNCTIONS
------------------------------ */
document.addEventListener("DOMContentLoaded", () => {
    loadCart();
});
