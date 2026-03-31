document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('invitation-form');
    var previewRoot = document.getElementById('invitation-preview');
    var samplePreview = document.getElementById('sample-preview');
    var canvas = document.getElementById('invitation-canvas');
    var feedback = document.getElementById('generator-feedback');
    var downloadButton = document.getElementById('download-invitation');

    if (!form || !previewRoot || !samplePreview || !canvas || !feedback || !downloadButton) {
        return;
    }

    var templateImage = new Image();
    templateImage.crossOrigin = 'anonymous';
    templateImage.src = previewRoot.getAttribute('data-template-src');

    var ctx = canvas.getContext('2d');
    var generatedFileName = 'thu-moi.png';

    function wrapText(context, text, maxWidth) {
        var words = text.trim().split(/\s+/);
        var lines = [];
        var currentLine = '';

        words.forEach(function (word) {
            var testLine = currentLine ? currentLine + ' ' + word : word;
            var testWidth = context.measureText(testLine).width;

            if (testWidth > maxWidth && currentLine) {
                lines.push(currentLine);
                currentLine = word;
                return;
            }

            currentLine = testLine;
        });

        if (currentLine) {
            lines.push(currentLine);
        }

        return lines;
    }

    function drawInvitation(salutation, fullName, jobTitle) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(templateImage, 0, 0, canvas.width, canvas.height);

        var inviteeName = (salutation + ' ' + fullName).trim();

        ctx.textAlign = 'center';
        ctx.fillStyle = '#ffffff';
        ctx.font = '35px Montserrat, Arial, sans-serif';
        // ctx.fillText('Trân trọng kính mời', canvas.width / 2, 215);

        ctx.font = '60px Montserrat, Arial, sans-serif';
        var lines = wrapText(ctx, inviteeName, 900);
        var startY = 395;
        var lineHeight = 78;

        lines.forEach(function (line, index) {
            ctx.fillText(line, canvas.width / 2, startY + (index * lineHeight));
        });

        if (jobTitle) {
            ctx.font = '500 32px Montserrat, Arial, sans-serif';
            ctx.fillStyle = 'rgba(233, 241, 255, 0.94)';
            ctx.fillText(jobTitle, canvas.width / 2, startY + (lines.length * lineHeight) - 24);
        }

        ctx.font = '500 32px Montserrat, Arial, sans-serif';
        ctx.fillStyle = 'rgba(233, 241, 255, 0.94)';
        // ctx.fillText(
        //     'đến tham dự sự kiện cùng INDOCHINE',
        //     canvas.width / 2,
        //     startY + (lines.length * lineHeight) + (jobTitle ? 52 : 12)
        // );
    }

    function showFeedback(message, type) {
        feedback.classList.remove('d-none', 'alert-warning', 'alert-success');
        feedback.classList.add(type === 'success' ? 'alert-success' : 'alert-warning');
        feedback.textContent = message;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var salutation = form.querySelector('[name="salutation"]').value;
        var fullName = form.querySelector('[name="full_name"]').value.trim();
        var jobTitle = form.querySelector('[name="job_title"]').value.trim();

        if (!fullName) {
            showFeedback('Vui lòng nhập Họ và Tên trước khi tạo thư mời.', 'warning');
            form.querySelector('[name="full_name"]').focus();
            return;
        }

        if (!templateImage.complete) {
            showFeedback('Phôi thư mời đang tải. Vui lòng thử lại sau vài giây.', 'warning');
            return;
        }

        drawInvitation(salutation, fullName, jobTitle);
        samplePreview.classList.add('d-none');
        canvas.classList.remove('d-none');
        downloadButton.disabled = false;
        generatedFileName = 'thu-moi-' + fullName.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') + '.png';
        showFeedback('Đã tạo thư mời thành công. Bạn có thể tải ảnh về máy.', 'success');
    });

    downloadButton.addEventListener('click', function () {
        if (downloadButton.disabled) {
            return;
        }

        var link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = generatedFileName;
        link.click();
    });
});
