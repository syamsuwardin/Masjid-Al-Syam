document.addEventListener('DOMContentLoaded', function() {
    const countdown = document.querySelector('.countdown');
    if (!countdown) return;

    const prayerTime = countdown.dataset.time;
    const [hours, minutes] = prayerTime.split(':');
    
    function updateCountdown() {
        const now = new Date();
        const target = new Date();
        target.setHours(parseInt(hours));
        target.setMinutes(parseInt(minutes));
        target.setSeconds(0);

        if (now > target) {
            target.setDate(target.getDate() + 1);
        }

        const diff = target - now;
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        countdown.querySelector('.hours').textContent = h.toString().padStart(2, '0');
        countdown.querySelector('.minutes').textContent = m.toString().padStart(2, '0');
        countdown.querySelector('.seconds').textContent = s.toString().padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
});