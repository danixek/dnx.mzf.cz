document.addEventListener('DOMContentLoaded', () => {  
    const radios = document.querySelectorAll('input[name="wallpaper"]');
    const positionSelect = document.getElementById('wallpaper-position');
    const background = document.getElementById('background-overlay');

    function updateBackground() {
        const selectedRadio = document.querySelector('input[name="wallpaper"]:checked');
        const selectedPosition = positionSelect.value;

        if (selectedRadio && background) {
            const imageUrl = selectedRadio.value;
            background.style.background = `url('dashboard/img/${imageUrl}') no-repeat ${selectedPosition} / cover`;
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', updateBackground);
    });

    positionSelect.addEventListener('change', updateBackground);
});
