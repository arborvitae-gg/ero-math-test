// Navbar functionality
export function initializeNavbar() {
    const navbarToggle = document.getElementById('navbar-toggle');
    const navbarMenu = document.getElementById('navbar-menu');

    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener('click', function() {
            navbarMenu.classList.toggle('active');
        });
    }
}

// Initialize when the module is imported
document.addEventListener('DOMContentLoaded', initializeNavbar); 