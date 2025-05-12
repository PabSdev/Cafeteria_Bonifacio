document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const mobileMenuButton = document.getElementById('mobile-menu-button')
    const sidebar = document.getElementById('sidebar')

    // Toggle sidebar on mobile
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full')

            // Optional: add overlay when sidebar is open on mobile
            const sidebarIsOpen =
                !sidebar.classList.contains('-translate-x-full')

            // Handle body scroll when sidebar is open
            document.body.style.overflow = sidebarIsOpen ? 'hidden' : ''

            // Update aria attributes for accessibility
            mobileMenuButton.setAttribute('aria-expanded', sidebarIsOpen)
        })
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function (event) {
        const isSmallScreen = window.innerWidth < 1024 // lg breakpoint in Tailwind

        if (
            isSmallScreen &&
            !sidebar.contains(event.target) &&
            !mobileMenuButton.contains(event.target) &&
            !sidebar.classList.contains('-translate-x-full')
        ) {
            sidebar.classList.add('-translate-x-full')
            document.body.style.overflow = ''
            mobileMenuButton.setAttribute('aria-expanded', 'false')
        }
    })

    // Handle resize events
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
            // lg breakpoint in Tailwind
            document.body.style.overflow = ''
        }
    })
})
