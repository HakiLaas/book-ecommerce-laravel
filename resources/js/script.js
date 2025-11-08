document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById("theme");
    const body = document.body;

    // Event listener untuk klik tombol
    themeToggle.addEventListener("click", () => {
        // Toggle class "dark-mode" pada body
        body.classList.toggle("dark");

        // Ganti ikon berdasarkan tema aktif
        if (body.classList.contains("dark")) {
            themeToggle.classList.remove("bx-moon");
            themeToggle.classList.add("bx-sun");
        } else {
            themeToggle.classList.remove("bx-sun");
            themeToggle.classList.add("bx-moon");
        }
    });
});

window.addEventListener('scroll', function() {
    const navbar = document.getElementById('navbar');
    
    if (window.scrollY > 10) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');

    }
});

window.addEventListener('scroll', function() {
    const heroSearch = document.getElementById('heroSearch');
    const navSearch = document.getElementById('navSearch');
    if (window.scrollY > 380) {
        heroSearch.style.display = 'flex';
        navSearch.style.display = 'flex';
    }else{
        heroSearch.style.display = 'flex';
        navSearch.style.display = 'none';
    }
});

// Slider
document.addEventListener("DOMContentLoaded", () => {
    const nextSection = document.querySelector(".next-section a");
    const aboutSection = document.getElementById("about");
    const arrowIcon = nextSection.querySelector("i");
    
    window.addEventListener("scroll", () => {
        const aboutTop = aboutSection.getBoundingClientRect().top;
    
        if (aboutTop <= 100) {
            arrowIcon.classList.remove("bx-chevron-down");
            arrowIcon.classList.add("bx-chevron-up");
            nextSection.href = "#"; 
        } else {
            arrowIcon.classList.remove("bx-chevron-up");
            arrowIcon.classList.add("bx-chevron-down");
            nextSection.href = "#about"; 
        }
    });
});


// Slider
const container = document.querySelector(".product-container");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const scrollAmount = 250; // Jarak scroll setiap klik

function checkScroll() {
    const maxScrollLeft = container.scrollWidth - container.clientWidth;
    prevBtn.style.display = container.scrollLeft > 0 ? "block" : "none";
    nextBtn.style.display = container.scrollLeft >= maxScrollLeft ? "none" : "block";
}

nextBtn.addEventListener("click", () => {
    container.scrollBy({ left: scrollAmount, behavior: "smooth" });
    setTimeout(checkScroll, 500); // Beri jeda agar efek smooth scroll selesai sebelum mengecek batas
});

prevBtn.addEventListener("click", () => {
    container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    setTimeout(checkScroll, 500);
});

container.addEventListener("scroll", checkScroll);
window.addEventListener("load", checkScroll);

// Dropdown menu block
document.addEventListener("DOMContentLoaded", function () {
    const dropdowns = document.querySelectorAll(".dropdown");
    let hideTimeout;

    dropdowns.forEach(dropdown => {
        const menu = dropdown.querySelector(".dropdown-menu");

        dropdown.addEventListener("mouseenter", function () {
            clearTimeout(hideTimeout); // Hentikan timeout saat hover
            menu.style.display = "block";
            setTimeout(() => menu.classList.add("show"), 10); // Tambahkan animasi
        });

        dropdown.addEventListener("mouseleave", function () {
            hideTimeout = setTimeout(() => {
                menu.classList.remove("show");
                setTimeout(() => (menu.style.display = "none"), 100); // Sembunyikan dengan delay
            }, 300); // Delay sebelum hilang
        });

        menu.addEventListener("mouseenter", function () {
            clearTimeout(hideTimeout); // Jika masuk ke dropdown, batal sembunyikan
        });

        menu.addEventListener("mouseleave", function () {
            hideTimeout = setTimeout(() => {
                menu.classList.remove("show");
                setTimeout(() => (menu.style.display = "none"), 300);   
            }, 300);
        });
    });
});


// Test product
// document.addEventListener("DOMContentLoaded", function () {
//     const cartItems = document.getElementById("cart-items");
//     const favoriteItems = document.getElementById("favorite-items");

//     let cart = [
//         { name: "Astronaut T-Shirt", price: "$78" },
//         { name: "Floral Shirt", price: "$85" }
//     ];

//     let favorites = [
//         { name: "Denim Jacket", price: "$120" }
//     ];

//     function updateCart() {
//         cartItems.innerHTML = cart.length
//             ? cart.map(item => `<li>${item.name} - ${item.price}</li>`).join("")
//             : "<li>Cart is empty</li>";
//     }

//     function updateFavorites() {
//         favoriteItems.innerHTML = favorites.length
//             ? favorites.map(item => `<li>${item.name} - ${item.price}</li>`).join("")
//             : "<li>No favorites yet</li>";
//     }

//     updateCart();
//     updateFavorites();
// });

