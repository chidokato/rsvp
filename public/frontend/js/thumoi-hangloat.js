document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('bulk-invitation-form');
    var previewRoot = document.getElementById('invitation-preview');
    var canvas = document.getElementById('invitation-canvas');
    var feedback = document.getElementById('generator-feedback');
    var generateButton = document.getElementById('generate-bulk');
    var progressContainer = document.getElementById('progress-container');
    var progressBar = document.getElementById('progress-bar');
    var progressText = document.getElementById('progress-text');

    if (!form || !previewRoot || !canvas || !feedback || !generateButton) {
        return;
    }

    var templateImage = new Image();
    templateImage.crossOrigin = 'anonymous';
    templateImage.src = previewRoot.getAttribute('data-template-src');

    var ctx = canvas.getContext('2d');
    var invitationLayout = {
        nameX: Number(previewRoot.getAttribute('data-name-x')) || 864,
        nameY: Number(previewRoot.getAttribute('data-name-y')) || 390,
        nameMaxWidth: Number(previewRoot.getAttribute('data-name-max-width')) || 1500,
        nameLineHeight: Number(previewRoot.getAttribute('data-name-line-height')) || 90,
        nameFontSize: Number(previewRoot.getAttribute('data-name-font-size')) || 80,
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
        var salutationFont = 'italic ' + Math.round(invitationLayout.nameFontSize * 1.2) + 'px Ghiocity, sans-serif';

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

    function showFeedback(message, type) {
        feedback.classList.remove('d-none', 'alert-warning', 'alert-success');
        feedback.classList.add(type === 'success' ? 'alert-success' : 'alert-warning');
        feedback.innerHTML = message;
    }

    async function handleGenerateBulk(event) {
        event.preventDefault();

        var bulkData = form.querySelector('#bulk_data').value.trim();

        if (!bulkData) {
            showFeedback('Vui lòng nhập danh sách khách mời.', 'warning');
            return;
        }

        if (!templateImage.complete) {
            showFeedback('Phôi thư mời đang tải. Vui lòng thử lại sau vài giây.', 'warning');
            return;
        }

        if (typeof JSZip === 'undefined' || typeof saveAs === 'undefined') {
            showFeedback('Đang tải thư viện xử lý ZIP, vui lòng đợi thêm 1 lát rồi thử lại.', 'warning');
            return;
        }

        generateButton.disabled = true;
        progressContainer.classList.remove('d-none');
        feedback.classList.add('d-none');
        
        var lines = bulkData.split('\n').map(line => line.trim()).filter(line => line.length > 0);
        
        var zip = new JSZip();
        var folder = zip.folder("Thu_Moi");
        
        for (var i = 0; i < lines.length; i++) {
            var parts = lines[i].split('|').map(p => p.trim());
            var salutation = parts.length > 0 ? parts[0] : '';
            var fullName = parts.length > 1 ? parts[1] : '';
            var jobTitle = parts.length > 2 ? parts[2] : '';
            
            // If they didn't put a salutation but put a name (e.g. just "Nguyễn Văn A")
            if (parts.length === 1) {
                fullName = parts[0];
                salutation = '';
            }

            if (!fullName) {
                fullName = "Khách Mời";
            }

            drawInvitation(salutation, fullName, jobTitle);
            var blob = await canvasToBlob();
            
            var fileName = slugify(fullName) || ('khach-moi-' + (i+1));
            // Ensure unique filenames if there are duplicates
            folder.file(fileName + '_' + (i+1) + '.jpg', blob);

            var percent = Math.round(((i + 1) / lines.length) * 100);
            progressBar.style.width = percent + '%';
            progressBar.innerText = percent + '%';
            progressText.innerText = 'Đang xử lý: ' + (i + 1) + '/' + lines.length;
        }

        progressText.innerText = 'Đang nén file ZIP...';
        
        zip.generateAsync({type:"blob"}).then(function(content) {
            saveAs(content, "danh-sach-thu-moi.zip");
            showFeedback('Đã tạo và tải xuống file ZIP thành công!', 'success');
            generateButton.disabled = false;
            setTimeout(() => {
                progressContainer.classList.add('d-none');
                progressBar.style.width = '0%';
                progressBar.innerText = '0%';
            }, 3000);
        }).catch(function(err) {
            showFeedback('Có lỗi khi tạo file ZIP: ' + err.message, 'warning');
            generateButton.disabled = false;
        });
    }

    generateButton.addEventListener('click', handleGenerateBulk);
});
