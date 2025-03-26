// class CameraInit {
//     video = null;
//     content = null;
//     // result = null;
//     suggested = null;
//     reloadBtn = null;
//     cameraBg = null;
//     container = null;

//     canvas = null;
//     context = null;

//     constructor() {
//         this.container = document.getElementById("camera-container");
//         this.video = document.getElementById("qr-video");

//         // this.result = document.getElementById("qr-result");

//         this.cameraBg = document.getElementById('camera-bg');
//         this.suggested = document.getElementById('suggested');
//         this.reloadBtn = document.getElementById('reload');

//         this.canvas = document.getElementById("qr-canvas");
//         this.context = this.canvas.getContext("2d");

//         this.initializeCamera();
//     }

//     initializeCamera() {
//         this.updateSuggested("อย่าลืมเชื่อมต่อกับกล้อง", "bg-red/40");
//         navigator.mediaDevices.getUserMedia({
//             video: { facingMode: "environment" }
//         })
//             .then(this.permissionAccept.bind(this))
//             .catch(this.permissionError.bind(this));
//     }

//     drawLine(begin, end, color) {
//         this.context.beginPath();
//         this.context.moveTo(begin.x, begin.y);
//         this.context.lineTo(end.x, end.y);
//         this.context.lineWidth = 4;
//         this.context.strokeStyle = color;
//         this.context.stroke();
//     }

//     updateSuggested(text, bgClass = "bg-red/40") {
//         this.suggested.textContent = text;
//         this.suggested.className = `${bgClass} text-white text-center w-fit min-w-[128px] h-fit px-3 py-1 rounded-lg font-medium text-lg`;
//     }

//     permissionAccept(stream) {
//         this.video.srcObject = stream;
//         this.video.setAttribute("playsinline", true);
//         this.video.play();

//         this.cameraBg.classList.replace("bg-black/20", "bg-red/20");
//         this.updateSuggested("วาง QR Code ไว่ในกรอบ", "bg-black/40");
//         this.reloadBtn.classList.add('hidden');

//         requestAnimationFrame(this.tick.bind(this));
//     }

//     permissionError() {
//         this.cameraBg.classList.replace("bg-red/20", "bg-black/20");
//         this.updateSuggested("อย่าลืมเชื่อมต่อกับกล้อง");
//         this.reloadBtn.classList.remove('hidden');

//         this.reloadBtn.addEventListener('click', () => {
//             navigator.mediaDevices.getUserMedia({
//                 video: true
//             })
//             window.location.reload();
//         })
//     }

//     tick() {
//         if (this.video.readyState === this.video.HAVE_ENOUGH_DATA) {
//             this.canvas.hidden = false;

//             this.canvas.height = this.video.videoHeight;
//             this.canvas.width = this.video.videoWidth;

//             this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);

//             const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);
//             const code = jsQR(imageData.data, imageData.width, imageData.height, {
//                 inversionAttempts: "invert",
//             });

//             if (code) {
//                 const location = code.location;

//                 this.drawLine(location.topLeftCorner, location.topRightCorner, "#FF3B58");
//                 this.drawLine(location.topRightCorner, location.bottomRightCorner, "#FF3B58");
//                 this.drawLine(location.bottomRightCorner, location.bottomLeftCorner, "#FF3B58");
//                 this.drawLine(location.bottomLeftCorner, location.topLeftCorner, "#FF3B58");

//                 // this.result.innerText = "QR Code detected: " + code.data;
//                 alert("QR Code detected: " + code.data);
//             }
//         }

//         requestAnimationFrame(this.tick.bind(this));
//     }
// }

// export { CameraInit };

import QrScanner from 'https://cdn.jsdelivr.net/npm/qr-scanner/qr-scanner.min.js';

class CameraInit {
    authorId = "";
    processing = false;

    constructor(authorId) {
        this.container = document.getElementById("camera-container");
        this.video = document.getElementById("qr-video");
        this.cameraBg = document.getElementById('camera-bg');
        this.suggested = document.getElementById('suggested');
        this.reloadBtn = document.getElementById('reload');
        this.canvas = document.getElementById("qr-canvas");
        this.context = this.canvas ? this.canvas.getContext("2d") : null;

        this.scanner = null;
        this.authorId = authorId;

        this.initializeCamera();
        this.handleReload();
    }

    initializeCamera() {
        this.updateSuggested("อย่าลืมเชื่อมต่อกับกล้อง", "bg-red/40");

        if (QrScanner && QrScanner.hasCamera()) {
            if (this.video) {
                this.scanner = new QrScanner(
                    this.video,
                    this.handleScan.bind(this),
                    {
                        returnDetailedScanResult: true,
                        highlightScanRegion: true,
                        maxScansPerSecond: 3
                    }
                );

                this.scanner.start()
                    .then(() => {
                        console.log("Camera started successfully.");
                        this.cameraBg.classList.replace("bg-black/20", "bg-red/20");
                        this.updateSuggested("วาง QR Code ไว่ในกรอบ", "bg-black/40");
                    })
                    .catch(error => {
                        console.error('Camera start error:', error);
                        this.handleCameraError();
                    });
            } else {
                console.error("Video element (#qr-video) not found!");
                this.handleCameraError();
            }
        } else {
            console.error("No camera available or QrScanner not loaded.");
            this.handleCameraError();
        }
    }

    handleScan(result) {
        if (result) {
            try {
                const parsedData = JSON.parse(result.data);
                this.qrDataProcessing(parsedData);
            } catch (e) {
                this.qrDataProcessing(result.data);
            }
        }
    }

    qrDataProcessing(data) {
        if (this.processing) return;
        this.processing = true;

        this.scanner.stop();

        Swal.fire({
            title: 'พบผู้เข้าร่วม',
            text: `คูณยืนยันที่จะให้เข้าร่วมหรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน'
        }).then(async (result) => {
            if (result.isConfirmed) {
                await fetch('../?action=request&on=attend&form=accept', {
                    method: 'POST',
                    body: JSON.stringify({
                        ...data,
                        authorId: this.authorId
                    })
                }).then((res) => {
                    console.log("Request response:", res);
                });
            }
        }).finally(() => {
            this.processing = false;
            this.scanner.start().catch(error => {
                console.error('Error restarting scanner:', error);
                this.handleCameraError();
            });
        });
    }

    handleCameraError() {
        this.cameraBg.classList.replace("bg-red/20", "bg-black/20");
        this.updateSuggested("อย่าลืมเชื่อมต่อกับกล้อง");

        if (this.reloadBtn) {
            this.reloadBtn.classList.remove('hidden');
        }
    }

    handleReload() {
        if (this.reloadBtn) {
            this.reloadBtn.addEventListener('click', () => {
                window.location.reload();
            });
        }
    }

    updateSuggested(text, bgClass = "bg-red/40") {
        if (this.suggested) {
            this.suggested.textContent = text;
            this.suggested.className = `${bgClass} text-white text-center w-fit min-w-[128px] h-fit px-3 py-1 rounded-lg font-medium text-lg`;
        }
    }
}

export { CameraInit };
