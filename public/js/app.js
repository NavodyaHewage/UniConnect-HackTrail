document.addEventListener('DOMContentLoaded', () => {
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
