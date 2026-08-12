document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    if (sidebar && toggle && overlay) {
        const closeSidebar = () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
        };
        const openSidebar = () => {
            sidebar.classList.add('open');
            overlay.classList.add('open');
            toggle.setAttribute('aria-expanded', 'true');
        };

        toggle.addEventListener('click', () => {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });
        overlay.addEventListener('click', closeSidebar);
    }

    const geoInputs = document.querySelectorAll('input[name="latitude"], input[name="longitude"]');
    if (geoInputs.length && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            document.querySelectorAll('input[name="latitude"]').forEach((el) => {
                if (!el.value) el.value = position.coords.latitude;
            });
            document.querySelectorAll('input[name="longitude"]').forEach((el) => {
                if (!el.value) el.value = position.coords.longitude;
            });
        });
    }
});
