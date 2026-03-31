document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('rsvp-form');
    var feedback = document.getElementById('rsvp-feedback');

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
            feedback.textContent = 'Vui long nhap ten khach moi truoc khi xac nhan.';
        }
    });
});
