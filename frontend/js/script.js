window.onscroll = () => {
    if (window.scrollY > 60) {
        document.querySelector('#scroll-top').classList.add('active');
    } else {
        document.querySelector('#scroll-top').classList.remove('active');
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const profileButton = document.getElementById("profileButton");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const cartIcon = document.querySelector(".card-shopping");
    const cartDropdown = document.querySelector(".cart-dropdown");

    // Profile dropdown toggle
    if (profileButton && dropdownMenu) {
        profileButton.addEventListener("click", function (event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle("show");

            // Close the cart dropdown if it's open
            if (cartDropdown) cartDropdown.classList.remove("show");
        });

        document.addEventListener("click", function (event) {
            if (!profileButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove("show");
            }
        });
    }

    // Cart dropdown toggle
    if (cartIcon && cartDropdown) {
        cartIcon.addEventListener("click", function (event) {
            event.stopPropagation();
            cartDropdown.classList.toggle("show");

            // Close the profile dropdown if it's open
            if (dropdownMenu) dropdownMenu.classList.remove("show");
        });

        document.addEventListener("click", function (event) {
            if (!cartIcon.contains(event.target) && !cartDropdown.contains(event.target)) {
                cartDropdown.classList.remove("show");
            }
        });
    }
});

