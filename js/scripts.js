document.addEventListener("DOMContentLoaded", function() {
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    const products = [
        { id: '1', name: 'Smartphone A', price: 299.99, image: 'smartphone_a.jpg' },
        { id: '2', name: 'Laptop B', price: 999.99, image: 'laptop_b.jpg' },
        { id: '3', name: 'Headphones C', price: 199.99, image: 'headphones_c.jpg' },
        { id: '4', name: 'Smartwatch D', price: 149.99, image: 'smartwatch_d.jpg' },
        { id: '5', name: 'Camera E', price: 599.99, image: 'camera_e.jpg' }
    ];

    addToCartButtons.forEach(button => {
        button.addEventListener("click", function() {
            const productId = this.dataset.productId;
            addToCart(productId);
        });
    });

    function addToCart(productId) {
        const existingProduct = cart.find(item => item.id === productId);
        if (existingProduct) {
            existingProduct.quantity++;
        } else {
            cart.push({ id: productId, quantity: 1 });
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        alert("Product added to cart!");
    }

    const cartItemsContainer = document.querySelector(".cart-items");
    if (cartItemsContainer) {
        renderCartItems();
    }

    function renderCartItems() {
        cartItemsContainer.innerHTML = "";
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = "<p>Your cart is empty.</p>";
            return;
        }
        cart.forEach(item => {
            const product = products.find(p => p.id === item.id);
            if (product) {
                const cartItem = document.createElement("div");
                cartItem.classList.add("cart-item");
                cartItem.innerHTML = `
                    <img src="images/${product.image}" alt="${product.name}">
                    <h4>${product.name}</h4>
                    <p>Quantity: ${item.quantity}</p>
                    <p class="price">$${(product.price * item.quantity).toFixed(2)}</p>
                    <button class="remove-from-cart" data-product-id="${item.id}">Remove</button>
                `;
                cartItemsContainer.appendChild(cartItem);
            }
        });

        const removeFromCartButtons = document.querySelectorAll(".remove-from-cart");
        removeFromCartButtons.forEach(button => {
            button.addEventListener("click", function() {
                const productId = this.dataset.productId;
                removeFromCart(productId);
            });
        });
    }

    function removeFromCart(productId) {
        const index = cart.findIndex(item => item.id === productId);
        if (index !== -1) {
            cart.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCartItems();
        }
    }

    const checkoutButton = document.getElementById("checkout-button");
    if (checkoutButton) {
        checkoutButton.addEventListener("click", function() {
            checkout();
        });
    }

    function checkout() {
        fetch("checkout.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                cart: cart
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Checkout successful!");
                localStorage.removeItem("cart");
                renderCartItems();
            } else {
                alert("Checkout failed: " + data.message);
            }
        });
    }
});
