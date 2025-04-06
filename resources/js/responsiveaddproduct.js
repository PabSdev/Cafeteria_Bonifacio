document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mobileMenuButton = document.getElementById('mobile-menu-button');

    mobileMenuButton.addEventListener('click', function () {
        sidebar.classList.toggle('-translate-x-full');
    });
});
