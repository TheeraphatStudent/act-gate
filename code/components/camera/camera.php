<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../component.php');

class QrCodeReader extends Component
{
    public function render()
    {
?>
        <div id="camera-container" class="relative w-full h-full max-h-[500px] rounded-xl overflow-hidden">
            <video id="qr-video" width="1200" height="500" class="object-fit bg-black/50 overflow-hidden" autoplay></video>
            <canvas class="absolute w-full" id="qr-canvas"></canvas>

            <div id="camera-bg" class="flex p-5 top-0 left-0 absolute w-full h-fit gap-4">
                <div id="suggested" class="text-center w-fit min-w-[128px] h-fit px-3 py-1 rounded-lg font-medium text-lg"></div>
                <div id="reload" class="group text-center h-fit bg-yellow px-2 py-2 rounded-lg font-medium text-lg hover:cursor-pointer">
                    <img
                        width="20"
                        height="20"
                        src="public/icons/reload.svg"
                        alt="reload"
                        class="transition-transform duration-300 ease-in-out group-hover:rotate-180" />
                </div>

            </div>
        </div>

        <span id="qr-result"></span>

        <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
        <script type="module">
            import {
                CameraInit
            } from './components/camera/camera.js';

            document.addEventListener('DOMContentLoaded', () => {
                const cameraInit = new CameraInit();
            });
        </script>
<?php

    }
    public function getResponse() {}
}
