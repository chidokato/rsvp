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
    var filePrefix = previewRoot.getAttribute('data-file-prefix') || 'thu-moi';
    var generatorType = previewRoot.getAttribute('data-generator-type') || 'invitation';
    var generatedFileName = filePrefix + '.jpg';

    function isIOS() {
        return /iPad|iPhone|iPod/.test(window.navigator.userAgent);
    }

    function canvasToBlob() {
        return new Promise(function (resolve) {
            canvas.toBlob(function (blob) {
                resolve(blob);
            }, 'image/jpeg', 0.95);
        });
    }

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

    function slugify(text) {
        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
    }

    function drawInvitation(salutation, fullName, jobTitle) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(templateImage, 0, 0, canvas.width, canvas.height);

        var inviteeName = (salutation + ' ' + fullName).trim();

        ctx.textAlign = 'center';
        ctx.fillStyle = '#ffffff';
        ctx.font = '35px Montserrat, Arial, sans-serif';

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
    }

    function drawVoucher(apartmentCode, phoneLast4) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(templateImage, 0, 0, canvas.width, canvas.height);

        var voucherCode = phoneLast4 + '-' + apartmentCode.toUpperCase();

        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = '#6a281a';
        ctx.font = '700 42px Montserrat, Arial, sans-serif';
        ctx.fillText(voucherCode, 1610, 94);
    }

    function showFeedback(message, type) {
        feedback.classList.remove('d-none', 'alert-warning', 'alert-success');
        feedback.classList.add(type === 'success' ? 'alert-success' : 'alert-warning');
        feedback.textContent = message;
    }

    function postVoucher(formData) {
        return fetch(form.getAttribute('action'), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        }).then(function (response) {
            return response.json().then(function (data) {
                if (!response.ok) {
                    throw data;
                }

                return data;
            });
        });
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var fileNameSeed = '';

        if (generatorType === 'voucher') {
            var apartmentCode = form.querySelector('[name="apartment_code"]').value.trim();
            var phoneLast4Input = form.querySelector('[name="phone_last4"]');
            var phoneLast4 = phoneLast4Input.value.replace(/\D/g, '').slice(0, 4);
            var projectName = form.querySelector('[name="project_name"]').value.trim();

            phoneLast4Input.value = phoneLast4;

            if (!apartmentCode) {
                showFeedback('Vui lòng nhập mã căn trước khi tạo voucher.', 'warning');
                form.querySelector('[name="apartment_code"]').focus();
                return;
            }

            if (phoneLast4.length !== 4) {
                showFeedback('Vui lòng nhập đúng 4 số cuối số điện thoại.', 'warning');
                phoneLast4Input.focus();
                return;
            }

            if (!projectName) {
                showFeedback('Vui lòng nhập tên dự án đã mua.', 'warning');
                form.querySelector('[name="project_name"]').focus();
                return;
            }

            if (!templateImage.complete) {
                showFeedback('Ảnh voucher đang tải. Vui lòng thử lại sau vài giây.', 'warning');
                return;
            }

            var formData = new FormData(form);
            formData.set('apartment_code', apartmentCode);
            formData.set('phone_last4', phoneLast4);
            formData.set('project_name', projectName);

            downloadButton.disabled = true;

            postVoucher(formData)
                .then(function (data) {
                    drawVoucher(apartmentCode, phoneLast4);
                    samplePreview.classList.add('d-none');
                    canvas.classList.remove('d-none');
                    downloadButton.disabled = false;
                    fileNameSeed = apartmentCode + '-' + phoneLast4;
                    generatedFileName = filePrefix + '-' + slugify(fileNameSeed) + '.jpg';
                    showFeedback('Đã tạo voucher thành công. Mã: ' + data.voucher.voucher_code, 'success');
                })
                .catch(function (error) {
                    var message = 'Không thể lưu voucher. Vui lòng thử lại.';

                    if (error && error.errors) {
                        var firstKey = Object.keys(error.errors)[0];
                        if (firstKey && error.errors[firstKey] && error.errors[firstKey][0]) {
                            message = error.errors[firstKey][0];
                        }
                    } else if (error && error.message) {
                        message = error.message;
                    }

                    showFeedback(message, 'warning');
                });
            return;
        } else {
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
            fileNameSeed = fullName;
            showFeedback('Đã tạo thư mời thành công. Bạn có thể tải ảnh về máy.', 'success');
        }

        samplePreview.classList.add('d-none');
        canvas.classList.remove('d-none');
        downloadButton.disabled = false;
        generatedFileName = filePrefix + '-' + slugify(fileNameSeed) + '.jpg';
    });

    downloadButton.addEventListener('click', async function () {
        if (downloadButton.disabled) {
            return;
        }

        var blob = await canvasToBlob();

        if (!blob) {
            showFeedback('Không thể tạo file ảnh để tải xuống. Vui lòng thử lại.', 'warning');
            return;
        }

        var blobUrl = URL.createObjectURL(blob);

        if (isIOS()) {
            window.open(blobUrl, '_blank', 'noopener');
            showFeedback('Ảnh đã được mở ở tab mới. Hãy nhấn giữ vào ảnh để lưu về máy.', 'success');
            window.setTimeout(function () {
                URL.revokeObjectURL(blobUrl);
            }, 60000);
            return;
        }

        var link = document.createElement('a');
        link.href = blobUrl;
        link.download = generatedFileName;
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.setTimeout(function () {
            URL.revokeObjectURL(blobUrl);
        }, 1000);
    });
});
