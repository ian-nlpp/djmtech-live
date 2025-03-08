document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab");
    const suggestProductSection = document.querySelector(".suggest-product .suggestcards");

    const productData = {
        new: [
            { name: "Cute Earpods keme", price: "₱1000", img: "assets/galaxybuds.png" },
            { name: "AMD Ryzen 7 5700X", price: "₱1200", img: "assets/images/ryzen.png" },
            { name: "LG 25MS500-B 24.5", price: "₱1300", img: "assets/images/monitor.png" },
            { name: "Team Elite Vulcan", price: "₱1400", img: "assets/images/ram.png" }
        ],
        "best-sellers": [
            { name: "Nintendo Switch", price: "₱1500", img: "assets/nintendoswitch.png" },
            { name: "RGB Keyboard", price: "₱1700", img: "assets/images/rgb-keyboard.png" },
            { name: "CPU Cooler", price: "₱1800", img: "assets/images/cpu-cooler.png" },
            { name: "Headphone", price: "₱1900", img: "assets/images/headphone.png" }
        ],
        recommended: [
            { name: "Dell Monitor", price: "₱1000", img: "assets/images/dellmonitor.png" },
            { name: "Microphone", price: "₱1200", img: "assets/images/microphone.png" },
            { name: "Mouse", price: "₱1300", img: "assets/images/gmouse.png" },
            { name: "Headset", price: "₱1400", img: "assets/images/Headset.png" }
        ]
    };

    function updateSuggestedProducts(products) {
        suggestProductSection.innerHTML = "";
        products.forEach(product => {
            const productCard = document.createElement("div");
            productCard.classList.add("suggestcard");
            productCard.innerHTML = `
                <div class="wishlist-btn">
                    <a href="#"><i class="bx bx-heart"></i></a>
                </div>
                <div class="card-header">
                    <div>
                        <img src="${product.img}" alt="${product.name}">
                    </div>
                </div>
                <div class="card-body">
                    <div class="rating">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                    <h3>${product.name}</h3>
                    <p class="price">${product.price}</p>
                    <button class="add-to-cart">ADD TO CART</button>
                </div>
            `;
            suggestProductSection.appendChild(productCard);
        });

        // Attach rating functionality for each card after rendering
        document.querySelectorAll(".suggestcard").forEach(card => {
            const stars = card.querySelectorAll(".star");
            let selectedRating = 0;

            stars.forEach((star, index) => {
                star.addEventListener("click", function () {
                    if (selectedRating === index + 1) {
                        selectedRating = 0; // Reset rating if the same star is clicked again
                    } else {
                        selectedRating = index + 1;
                    }

                    stars.forEach((s, i) => {
                        s.classList.toggle("filled", i < selectedRating);
                    });
                });
            });
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener("click", function (event) {
            event.preventDefault();
            document.querySelector(".tab.active").classList.remove("active");
            tab.classList.add("active");
            const selectedTab = tab.getAttribute("data-tab");
            updateSuggestedProducts(productData[selectedTab]);
        });
    });

    // Display initial content for the default active tab
    updateSuggestedProducts(productData["new"]);
});
