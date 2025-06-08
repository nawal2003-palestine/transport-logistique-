// Menu mobile
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.querySelector('.menu-btn');
    const nav = document.querySelector('nav');
    
    if(menuBtn) {
        menuBtn.addEventListener('click', function() {
            nav.classList.toggle('show');
        });
    }
    
    // Autres fonctions globales
});

// Estimation de volume (exemple)
function estimateVolume() {
    const items = document.querySelectorAll('.item-select');
    let totalVolume = 0;
    
    items.forEach(item => {
        if(item.checked) {
            totalVolume += parseInt(item.dataset.volume);
        }
    });
    
    document.getElementById('volume-estimate').textContent = totalVolume + ' m³';
}
