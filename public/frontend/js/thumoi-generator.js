document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('invitation-form');
    var previewRoot = document.getElementById('invitation-preview');
    var samplePreview = document.getElementById('sample-preview');
    var canvas = document.getElementById('invitation-canvas');
    var feedback = document.getElementById('generator-feedback');
    var generateButton = document.getElementById('generate-invitation') || (form ? form.querySelector('[type="submit"]') : null);
    var downloadWebButton = document.getElementById('download-web');
    var downloadMobileButton = document.getElementById('download-mobile');

    if (!form || !previewRoot || !samplePreview || !canvas || !feedback || !generateButton || !downloadWebButton || !downloadMobileButton) {
        return;
    }

    var templateImage = new Image();
    templateImage.crossOrigin = 'anonymous';
    templateImage.src = previewRoot.getAttribute('data-template-src');

    var ctx = canvas.getContext('2d');
    var filePrefix = previewRoot.getAttribute('data-file-prefix') || 'thu-moi';
    var generatorType = previewRoot.getAttribute('data-generator-type') || 'invitation';
    var generatedFileName = filePrefix + '.jpg';
    var isGenerating = false;
    var latestDataUrl = '';
    var invitationLayout = {
        nameX: Number(previewRoot.getAttribute('data-name-x')) || 640,
        nameY: Number(previewRoot.getAttribute('data-name-y')) || 560,
        nameMaxWidth: Number(previewRoot.getAttribute('data-name-max-width')) || 1180,
        nameLineHeight: Number(previewRoot.getAttribute('data-name-line-height')) || 74,
        nameFontSize: Number(previewRoot.getAttribute('data-name-font-size')) || 78,
        textColor: previewRoot.getAttribute('data-text-color') || '#ffffff'
    };

    function canvasToBlob() {
        return new Promise(function (resolve) {
            if (canvas.toBlob) {
                canvas.toBlob(function (blob) {
                    resolve(blob);
                }, 'image/jpeg', 0.95);
                return;
            }

            var dataUrl = canvas.toDataURL('image/jpeg', 0.95);
            var binary = atob(dataUrl.split(',')[1]);
            var bytes = new Uint8Array(binary.length);

            for (var i = 0; i < binary.length; i += 1) {
                bytes[i] = binary.charCodeAt(i);
            }

            resolve(new Blob([bytes], { type: 'image/jpeg' }));
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

        var nameText = fullName.trim().toUpperCase();
        var salutationText = salutation ? salutation.trim() + ' ' : '';

        ctx.fillStyle = invitationLayout.textColor;
        var nameFont = '700 ' + invitationLayout.nameFontSize + 'px Montserrat, Arial, sans-serif';
        var salutationFont = 'italic ' + Math.round(invitationLayout.nameFontSize * 1.5) + 'px Ghiocity, sans-serif';

        ctx.font = nameFont;
        var nameWidth = ctx.measureText(nameText).width;
        
        ctx.font = salutationFont;
        var salWidth = ctx.measureText(salutationText).width;

        var startY = invitationLayout.nameY;
        var lineHeight = invitationLayout.nameLineHeight;
        var linesLength = 1;

        if (salWidth + nameWidth <= invitationLayout.nameMaxWidth) {
            var totalWidth = salWidth + nameWidth;
            var startX = invitationLayout.nameX - (totalWidth / 2);
            
            ctx.textAlign = 'left';
            ctx.font = salutationFont;
            ctx.fillText(salutationText, startX, startY);
            
            ctx.font = nameFont;
            ctx.fillText(nameText, startX + salWidth, startY);
        } else {
            ctx.font = nameFont;
            var lines = wrapText(ctx, nameText, invitationLayout.nameMaxWidth);
            
            var firstLineNameWidth = ctx.measureText(lines[0]).width;
            var firstLineTotalWidth = salWidth + firstLineNameWidth;
            var startX = invitationLayout.nameX - (firstLineTotalWidth / 2);
            
            ctx.textAlign = 'left';
            ctx.font = salutationFont;
            ctx.fillText(salutationText, startX, startY);
            
            ctx.font = nameFont;
            ctx.fillText(lines[0], startX + salWidth, startY);
            
            ctx.textAlign = 'center';
            for (var i = 1; i < lines.length; i++) {
                ctx.fillText(lines[i], invitationLayout.nameX, startY + (i * lineHeight));
            }
            linesLength = lines.length;
        }

        if (jobTitle) {
            var jobFontSize = Math.round(invitationLayout.nameFontSize * 0.55);
            var jobLineHeight = Math.round(lineHeight * 0.7);
            ctx.textAlign = 'center';
            ctx.font = '500 ' + jobFontSize + 'px Montserrat, Arial, sans-serif';
            var jobY = startY + ((linesLength - 1) * lineHeight) + jobFontSize + 24;
            var jobLines = wrapText(ctx, jobTitle.trim(), invitationLayout.nameMaxWidth);
            
            jobLines.forEach(function (line, index) {
                ctx.fillText(line, invitationLayout.nameX, jobY + (index * jobLineHeight));
            });
        }
    }

    function drawVoucher(apartmentCode, phoneLast4) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(templateImage, 0, 0, canvas.width, canvas.height);

        var voucherCode = phoneLast4 + '-' + apartmentCode.toUpperCase();
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = '#6a281a';
        ctx.font = '700 48px Montserrat, Arial, sans-serif';
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
                Accept: 'application/json'
            },
            body: formData
        }).then(function (response) {
            return response.text().then(function (text) {
                var data = {};

                try {
                    data = text ? JSON.parse(text) : {};
                } catch (error) {
                    data = { message: 'Server response is invalid.' };
                }

                if (!response.ok) {
                    throw data;
                }

                return data;
            });
        });
    }

    function refreshPreviewData() {
        try {
            latestDataUrl = canvas.toDataURL('image/jpeg', 0.95);
        } catch (error) {
            latestDataUrl = '';
        }
    }

    function finishGenerate(fileNameSeed) {
        samplePreview.classList.add('d-none');
        canvas.classList.remove('d-none');
        downloadWebButton.disabled = false;
        downloadMobileButton.disabled = false;
        generatedFileName = filePrefix + '-' + slugify(fileNameSeed) + '.jpg';
        refreshPreviewData();
    }

    function handleGenerate(event) {
        if (event) {
            event.preventDefault();
        }

        if (isGenerating) {
            return;
        }

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

            isGenerating = true;
            generateButton.disabled = true;
            downloadWebButton.disabled = true;
            downloadMobileButton.disabled = true;

            var formData = new FormData(form);
            formData.set('apartment_code', apartmentCode);
            formData.set('phone_last4', phoneLast4);
            formData.set('project_name', projectName);

            postVoucher(formData)
                .then(function (data) {
                    drawVoucher(apartmentCode, phoneLast4);
                    fileNameSeed = apartmentCode + '-' + phoneLast4;
                    finishGenerate(fileNameSeed);
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
                })
                .finally(function () {
                    isGenerating = false;
                    generateButton.disabled = false;
                });

            return;
        }

        var salutation = form.querySelector('[name="salutation"]').value;
        var fullName = form.querySelector('[name="full_name"]').value.trim();
        var jobTitleEl = form.querySelector('[name="job_title"]');
        var jobTitle = jobTitleEl ? jobTitleEl.value.trim() : '';

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
        finishGenerate(fileNameSeed);
        showFeedback('Đã tạo thư mời thành công. Bạn có thể tải ảnh về máy.', 'success');
    }

    function bindTap(button, handler) {
        button.addEventListener('click', handler);
        button.addEventListener('touchend', function (event) {
            event.preventDefault();
            handler(event);
        }, { passive: false });
    }

    bindTap(generateButton, handleGenerate);
    form.addEventListener('submit', handleGenerate);

    bindTap(downloadWebButton, async function (event) {
        if (event) {
            event.preventDefault();
        }

        if (downloadWebButton.disabled) {
            return;
        }

        var blob = await canvasToBlob();

        if (!blob) {
            showFeedback('Không thể tạo file ảnh để tải xuống. Vui lòng thử lại.', 'warning');
            return;
        }

        var blobUrl = URL.createObjectURL(blob);
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

    bindTap(downloadMobileButton, function (event) {
        if (event) {
            event.preventDefault();
        }

        if (downloadMobileButton.disabled) {
            return;
        }

        if (!latestDataUrl) {
            refreshPreviewData();
        }

        if (!latestDataUrl) {
            showFeedback('Không thể mở ảnh trên mobile. Vui lòng thử lại.', 'warning');
            return;
        }

        var mobileWindow = window.open('', '_blank');

        if (!mobileWindow) {
            window.location.href = latestDataUrl;
            return;
        }

        mobileWindow.document.write('<!doctype html><html><head><meta name="viewport" content="width=device-width, initial-scale=1"><title>' + generatedFileName + '</title><style>html,body{margin:0;background:#111;height:100%;display:flex;align-items:center;justify-content:center}img{max-width:100%;height:auto}</style></head><body><img src="' + latestDataUrl + '" alt="thu-moi"></body></html>');
        mobileWindow.document.close();
        showFeedback('Đã mở ảnh cho mobile. Bạn có thể nhấn giữ để lưu vào Ảnh.', 'success');
    });
});
