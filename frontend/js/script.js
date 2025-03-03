window.onscroll = () =>{
    if (window.scrollY > 60) {
        document.querySelector('#scroll-top').classList.add('active');
        
    } else {
        document.querySelector('#scroll-top').classList.remove('active');
    }
}




document.addEventListener("DOMContentLoaded", function () {
    const profileButton = document.getElementById("profileButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    // Ensure the elements exist before adding event listeners
    if (profileButton && dropdownMenu) {
        profileButton.addEventListener("click", function (event) {
            event.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
        });

        // Close dropdown if clicking outside
        document.addEventListener("click", function (event) {
            if (!profileButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = "none";
            }
        });
    }

    const cartIcon = document.querySelector(".card-shopping");
    const cartDropdown = document.querySelector(".cart-dropdown");

    if (cartIcon && cartDropdown) {
        cartIcon.addEventListener("click", function (event) {
            event.stopPropagation();
            if (cartDropdown.style.display === "none" || cartDropdown.style.display === "") {
                cartDropdown.style.display = "block";
            } else {
                cartDropdown.style.display = "none";
            }
        });

        document.addEventListener("click", function (event) {
            if (!cartIcon.contains(event.target) && !cartDropdown.contains(event.target)) {
                cartDropdown.style.display = "none";
            }
        });
    }
});
