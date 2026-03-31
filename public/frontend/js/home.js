document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('rsvp-form');
    var feedback = document.getElementById('rsvp-feedback');
    var countdown = document.querySelector('[data-countdown]');

    if (countdown) {
        var targetTime = countdown.getAttribute('data-countdown');
        var dayNode = countdown.querySelector('[data-unit="days"]');
        var hourNode = countdown.querySelector('[data-unit="hours"]');
        var minuteNode = countdown.querySelector('[data-unit="minutes"]');
        var secondNode = countdown.querySelector('[data-unit="seconds"]');

        var renderCountdown = function () {
            var distance = new Date(targetTime).getTime() - Date.now();

            if (distance <= 0) {
                if (dayNode) dayNode.textContent = '00';
                if (hourNode) hourNode.textContent = '00';
                if (minuteNode) minuteNode.textContent = '00';
                if (secondNode) secondNode.textContent = '00';
                return;
            }

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
            var minutes = Math.floor((distance / (1000 * 60)) % 60);
            var seconds = Math.floor((distance / 1000) % 60);

            if (dayNode) dayNode.textContent = String(days).padStart(2, '0');
            if (hourNode) hourNode.textContent = String(hours).padStart(2, '0');
            if (minuteNode) minuteNode.textContent = String(minutes).padStart(2, '0');
            if (secondNode) secondNode.textContent = String(seconds).padStart(2, '0');
        };

        renderCountdown();
        window.setInterval(renderCountdown, 1000);
    }

    if (!form || !feedback) {
        return;
    }

    form.addEventListener('submit', function (event) {
        var guestName = form.querySelector('[name="guest_name"]');

        if (guestName && guestName.value.trim() === '') {
            event.preventDefault();
            guestName.focus();
            feedback.classList.remove('d-none', 'alert-success');
            feedback.classList.add('alert-warning');
            feedback.textContent = 'Vui lòng nhập tên khách mời trước khi xác nhận.';
        }
    });
});
