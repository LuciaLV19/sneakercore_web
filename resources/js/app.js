import "./bootstrap";
import Choices from "choices.js";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// ===============================
// Form image preview 
// ===============================
window.previewImage = function (event) {
    const file = event.target.files[0];
    
    if (!file || !file.type.startsWith('image/')) return; 
    let output = document.getElementById("main-preview");
    const placeholder = document.getElementById("text-placeholder");

    if (output && output.src.startsWith('blob:')) {
        URL.revokeObjectURL(output.src);
    }
    const imageUrl = URL.createObjectURL(file);

    if (!output) {
        output = document.createElement("img");
        output.id = "main-preview";
        output.className = "w-full h-full object-cover rounded-xl"; 
        
        if (placeholder) {
            placeholder.replaceWith(output);
        } else {
            event.target.parentElement.appendChild(output);
        }
    }
    
    output.src = imageUrl;
};

// ===============================
// Notification toast
// ===============================
window.showNotification = function (message, type = "neutral") {
    const container = document.getElementById("notification-container");
    if (!container) return;

    container.querySelectorAll(".wishlist-toast").forEach((n) => n.remove());

    const alert = document.createElement("div");

    let bgClass = "bg-gray-200 text-gray-800";

    if (type === "add") {
        bgClass = "bg-success text-dark";
    } else if (type === "remove") {
        bgClass = "bg-error text-dark";
    }

    alert.className = `
            wishlist-toast
            ${bgClass}
            rounded-lg px-4 py-3 shadow-md text-[16px]
            transition-all duration-300
            opacity-0 translate-y-2
        `;

    alert.textContent = message;
    container.appendChild(alert);

    requestAnimationFrame(() => {
        alert.classList.remove("opacity-0", "translate-y-2");
    });

    setTimeout(() => {
        alert.classList.add("opacity-0", "translate-y-2");
        setTimeout(() => alert.remove(), 300);
    }, 4000);
};

// ===============================
// Wishlist logic
// ===============================
window.addToWishlist = function (productId) {
    const heart = document.getElementById(`heart-${productId}`);

    fetch(`/wishlist/toggle/${productId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                if (heart) {
                    if (data.added) {
                        heart.classList.replace("fa-regular", "fa-solid");
                        heart.classList.add("text-red-500");
                        window.showNotification(data.message, "add");
                    } else {
                        heart.classList.replace("fa-solid", "fa-regular");
                        heart.classList.remove("text-red-500");
                        window.showNotification(data.message, "remove");
                    }
                }

                const productCard = document.getElementById(
                    `wishlist-item-${productId}`
                );
                if (!data.added && productCard) {
                    productCard.classList.add("opacity-0", "scale-95"); // Efecto de desvanecimiento
                    setTimeout(() => {
                        productCard.remove();
                        // Si ya no quedan productos, recargamos para mostrar el mensaje de "Vacío"
                        if (data.count === 0) location.reload();
                    }, 300);
                }

                // Actualizar contador del Nav
                const countBadge = document.getElementById("wishlist-count");
                if (countBadge) {
                    countBadge.innerText = data.count;
                    countBadge.classList.toggle("hidden", data.count === 0);
                }
            }
        })
        .catch((err) => console.error(err));
};

// ===============================
// Remove notifications on page show (browsing back)
// ===============================
window.addEventListener("pageshow", () => {
    const notifications = document.querySelectorAll(".notification-card");
    notifications.forEach((alert) => alert.remove());
});


// ===============================
// DOMContentLoaded — Only code that should run after the DOM is ready
// ===============================
document.addEventListener("DOMContentLoaded", function () {
    const feedback = document.getElementById("product-feedback");
    const toggleBtn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");
    const html = document.documentElement;
    const togglePassword = document.querySelectorAll(".togglePassword");
    const password = document.querySelectorAll(".password-input");
    const eyeIcon = document.querySelectorAll(".eyeIcon");
    const categoriesSelect = document.getElementById("categories");

    if (feedback) {
        feedback.classList.remove("opacity-0");
        feedback.classList.add("opacity-100");

        setTimeout(() => {
            feedback.classList.remove("opacity-100");
            feedback.classList.add("opacity-0");
        }, 2500);
    }

    // ===============================
    // Categories select (Choices.js)
    // ===============================
    if (categoriesSelect) {
        new Choices(categoriesSelect, {
            removeItemButton: true,
            searchEnabled: true,
            shouldSort: false,
            placeholderValue:
                window.i18n?.selectCategories || "Select categories",
        });
    }

    // ===============================
    // Dark/Light mode toggle icons
    // ===============================
    function updateThemeIcons() {
        if (!toggleBtn || !darkIcon || !lightIcon) return;
        const isDark = html.classList.contains("dark");
        darkIcon.classList.toggle("hidden", isDark);
        lightIcon.classList.toggle("hidden", !isDark);
    }
    updateThemeIcons();

    // Update button text on toggle
    toggleBtn?.addEventListener("click", () => {
        html.classList.toggle("dark");

        if (html.classList.contains("dark")) {
            localStorage.setItem("color-theme", "dark");
        } else {
            localStorage.setItem("color-theme", "light");
        }
        updateThemeIcons();
    });

    // ===============================
    // Password visibility toggle
    // ===============================
    document.addEventListener("click", function(e) {
        if (e.target.closest(".togglePassword")) {
            const toggle = e.target.closest(".togglePassword");
            const input = toggle.parentElement.querySelector(".password-input");
            const icon = toggle.querySelector("i");

            // Cambiar tipo de input
            const type = input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", type);

            // Cambiar ícono
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        }
    });

    // ===============================
    // Auto remove PHP notifications
    // ===============================
    document.querySelectorAll(".notification-card").forEach((alert) => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
});
