<?php

namespace FinalProject\View\Event;

require_once('utils/useRegister.php');
require_once('utils/useDateTime.php');
require_once('utils/useTags.php');

require_once('components/texteditor/texteditor.php');

use DateTime;
use FinalProject\Components\TextEditor;
use FinalProject\Utils\Register;

$detail = new TextEditor();
$detail->updatetextarea(description: $eventObj['description'], isEdit: false);

$detailDescription = new TextEditor();
$detailDescription->updatetextarea(description: $eventObj['description'], isEdit: false);

$location = new TextEditor();
$location->updatetextarea(description: $eventObj['location'], isEdit: false);

// print_r($eventObj);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Attendance</title>
</head>

<body class="bg-primary">
    <div
        class="flex flex-col justify-center items-center gap-12 py-[200px] pr-10 pl-10 w-full h-fit">
        <section class="flex flex-col justify-start items-center gap-6 w-full shadow-sm p-4">
            <div
                class="relative flex flex-col lg:flex-row justify-between items-end lg:items-center py-6 px-6 lg:px-8 gap-6 lg:gap-10 w-full max-w-[1650px] h-auto lg:h-[700px] rounded-3xl bg-cover bg-center overflow-hidden"
                style="background-image: url('public/images/uploads/<?= $eventObj['cover'] ?>');">
                <!-- Left Section -->
                <div class="flex flex-col justify-start items-start h-auto lg:h-[620px] w-full lg:w-auto z-10">
                    <!-- Back Button -->
                    <a href="../" class="flex flex-row justify-center items-center gap-2 py-2 px-4 rounded-lg h-11 shadow-sm bg-white min-w-[119px]">
                        <img width="16px" height="16px" src="public/icons/drop.svg" alt="Back" class="transform rotate-90" />
                        <span class="font-kanit text-lg min-w-[72px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-light">
                            ย้อนกลับ
                        </span>
                    </a>

                    <!-- Content -->
                    <div class="flex flex-col justify-start items-start gap-2.5 mt-8 lg:mt-[91px] h-full max-h-[400px] w-full lg:w-[440px]">
                        <div class="font-kanit text-2xl lg:text-3xl min-w-full lg:min-w-[440px] whitespace-nowrap text-white text-opacity-100 leading-none font-medium">
                            <?= $eventObj['title'] ?>
                        </div>
                        <!-- <div class="font-kanit text-sm lg:text-base w-full lg:w-[440px] text-white text-opacity-100 leading-none font-normal">
                            "Eat with Me: How to Eat for Health"<br />มาร่วมงาน "Eat with Me" กับเรา! 🌿✨<br />งานที่จะพาคุณเรียนรู้เกี่ยวกับการรับประทานอาหารอย่างถูกต้อง เพื่อสุขภาพที่ดีและสมดุล พบกับแนวทางการเลือกอาหารที่มีประโยชน์ เคล็ดลับการกินเพื่อสุขภาพ และไอเดียเมนูอร่อยที่ดีต่อร่างกาย<br /><br />📅 วันและเวลา: 12 มกราคาม 2568📍 สถานที่: Coworking space ท่าขอนยาง<br /><br />ร่วมสัมผัสประสบการณ์การกินอย่างมีสติ และค้นพบวิธีดูแลสุขภาพผ่านอาหารที่อร่อยและมีคุณค่าทางโภชนาการ! 🥗🍎
                        </div> -->
                        <?php
                        $detail->render();
                        ?>
                    </div>

                    <!-- Map Link -->
                    <!-- <button type="button" onclick="scrollToView();" class="mt-8 lg:mt-14 flex justify-start items-center gap-2 w-auto lg:w-[150px] h-7">
                        <img width="19.3px" height="20px" src="public/icons/pin.svg" alt="Map pin" />
                        <div class="font-kanit text-base lg:text-[18px] min-w-[120px] whitespace-nowrap text-white text-opacity-100 leading-none font-normal">
                            ดูแผนที่
                        </div>
                    </button> -->
                </div>

                <!-- Right Section -->
                <div class="flex w-full lg:w-fit h-full items-end z-10">
                    <div class="flex flex-col justify-start items-start gap-8 p-4 lg:p-8 rounded-2xl w-full lg:w-[385px] h-fit max-h-1/2 shadow-md bg-white">
                        <div class="flex flex-col justify-start items-start gap-2.5 w-full lg:w-[325px] h-fit">
                            <div class="font-kanit text-lg lg:text-xl min-w-full lg:min-w-[325px] whitespace-nowrap text-neutral-800 text-opacity-100 leading-none font-normal">
                                เวลาจัดงาน
                            </div>
                            <div class="flex flex-col font-kanit text-base w-full h-full gap-2 whitespace-nowrap text-gray-500 text-opacity-100 leading-none font-normal">
                                <span>เริ่มงาน: <?= dateFormat($eventObj['start']) ?></span>
                                <span>สิ้นสุด: <?= dateFormat($eventObj['end']) ?></span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col justify-end gap-2.5 h-full w-full">
                            <form
                                action="../?action=request&on=event&form=register"
                                method="post"
                                class="flex flex-col gap-2.5"
                                id="regForm">
                                <?php if (!empty($_SESSION['user']) && isset($_SESSION['user']['userId'])): ?>
                                    <input type="hidden" name="eventId" value="<?= htmlspecialchars($eventObj['eventId']) ?>">
                                    <input type="hidden" name="joined" value="<?= (isset($_GET['joined']) ? $_GET['joined'] : 0) ?>">
                                    <input type="hidden" name="userId" value="<?= htmlspecialchars($_SESSION['user']['userId']) ?>">

                                    <?php

                                    $status = (isset($regObj['status']) ? trim($regObj['status']) : null) ?? 'default';
                                    $status = in_array($status, Register::REGISTER_STATUS) ? $status : 'default';

                                    // print_r($eventId);
                                    // echo '<br>';
                                    // print_r($userId);
                                    // echo '<br>';
                                    // print_r($regObj);

                                    if (new DateTime() > new DateTime($eventObj['end'])) {
                                    ?>
                                        <button type='button' class='btn-gray' id=''><span>หมดเวลาเข้าร่วม</span></button>
                                    <?php
                                    } else {
                                        if (!isset($regObj['status']) && $_GET['joined'] >= $eventObj['maximum']) {
                                            foreach ($attButtons['full'] as $button) {
                                                echo "<button type='button' class='{$button['class']}' id='{$button['id']}'><span>{$button['label']}</span></button>";
                                            }
                                        } elseif ((isset($_SESSION['user']['userId']) && $eventObj['organizeId'] === $_SESSION['user']['userId'])) {
                                            foreach ($attButtons['owned'] as $button) {
                                                echo "<button type='button' class='{$button['class']}' id='{$button['id']}'><span>{$button['label']}</span></button>";
                                            }
                                        } 
                                        else {
                                            foreach ($attButtons[$status] as $button) {
                                                echo "<button type='button' class='{$button['class']}' id='{$button['id']}'><span>{$button['label']}</span></button>";
                                            }
                                        }
                                    }

                                    // unset($regObj);
                                    ?>

                                <?php else : ?>
                                    <a href="../?action=login" class="btn-gray">เข้าสู่ระบบก่อน</a>
                                <?php endif ?>
                            </form>
                            <!-- <a href="#" class="btn-primary-outline w-full group no-underline">
                                <span class="group-hover:text-white">สนใจ</span>
                            </a> -->
                        </div>
                    </div>
                </div>

                <!-- Cover -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm z-1"></div>
            </div>
        </section>

        <!-- Detail -->
        <section class="flex flex-col justify-start items-start gap-12 lg:gap-24 w-full max-w-[1200px] h-fit p-4" id="detail-section">
            <div class="flex w-full max-w-content h-full overflow-auto gap-8" id="imageContainer">
                <?php foreach (json_decode($eventObj['morePics'], true) as $item) : ?>
                    <div class="flex bg-dark-primary h-[180px] min-w-[320px] bg-cover bg-center rounded-lg"
                        style="background-image: url('public/images/uploads/<?= htmlspecialchars($item) ?>');">
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex flex-col lg:flex-row justify-between items-start gap-6 w-full *:max-w-none *:lg:max-w-[512px]">
                <!-- Description -->
                <div class="flex flex-col justify-start items-start gap-2.5 w-full lg:w-1/2">
                    <h1 class="text-white font-semibold">คำอธิบาย</h1>

                    <?php
                    $detailDescription->render();
                    ?>
                </div>

                <!-- Event Location -->
                <div class="flex flex-col justify-start items-start gap-2.5 w-full h-full lg:w-1/2 relative">
                    <h1 class="text-white font-semibold">สถานที่จัดงาน</h1>

                    <?php
                    $location->render();
                    ?>
                </div>
            </div>

            <div class="flex flex-col justify-start items-start gap-5 w-full h-fit lg:w-1/2 relative">
                <h1 class="text-white font-semibold">เวลาจัดงาน</h1>
                <div class="flex flex-col font-kanit text-base w-full h-full gap-2 whitespace-nowrap text-light-green text-opacity-100 leading-none font-normal">
                    <span>เริ่มงาน: <?= dateFormat($eventObj['start']) ?></span>
                    <span>สิ้นสุด: <?= dateFormat($eventObj['end']) ?></span>
                </div>
            </div>
        </section>

        <section class="flex flex-col items-center justify-center gap-2 mt-20 card w-full hover:cursor-pointer hover:scale-[101%]">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-primary text-white text-xl font-bold">
                <?= htmlspecialchars(strtoupper(substr($organizeInfo['name'], 0, 1))) ?>
            </div>

            <span> <?= htmlspecialchars($organizeInfo['name']) ?> </span>

            <div class="flex w-full gap-4 mt-2 *:bg-dark-primary/40">
                <div class="flex flex-col w-full rounded-lg py-2 px-4 text-center">
                    <p class="text-xl font-bold text-white"><?= $organizeInfo['total_events_created'] ?></p>
                    <span class="text-sm text-white">อีเวนท์ที่สร้าง</span>s
                </div>
                <div class="flex flex-col w-full rounded-lg py-2 px-4 text-center">
                    <p class="text-xl font-bold text-white"><?= $organizeInfo['total_events_joined'] ?></p>
                    <span class="text-sm text-white">อีเวนท์ที่เข้าร่วม</span>
                </div>
            </div>
        </section>
    </div>

    <div id="ticketModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-[9999] mt-24 hidden">
        <div class="bg-white shadow-2xl rounded-xl w-full max-w-[350px] p-5 h-fit *:w-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-kanit text-center w-full text-dark-secondary">บัตรเข้างานของคุณ</h3>
                <button type="button" id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Ticket -->
            <div id="ticket-canvas" class="h-[400px] rounded-md overflow-y-auto hover:scale-105">
                <section class="flex relative flex-col p-5 w-full">
                    <img
                        src="public/images/tickets.svg"
                        class="object-cover absolute inset-0 size-full"
                        alt="Ticket background" />

                    <section
                        class="flex relative gap-2.5 justify-center items-center text-base text-center text-white">
                        <div class="flex flex-col gap-1 items-center self-stretch my-auto">
                            <img
                                src="public/images/white-logo.svg"
                                class="object-cover aspect-square w-12"
                                alt="ACT GATE logo" />
                            <span>ACT GATE</span>
                        </div>
                    </section>

                    <section
                        class="flex relative flex-col justify-center self-center mt-4 w-full text-base font-medium text-center text-white max-w-[310px]">
                        <div id="ticket-code" class="bg-dark-primary flex self-center aspect-square min-h-[225px] w-[225px]" aria-label="QR Code"></div>

                        <p class="mt-2.5"><?= htmlspecialchars($_SESSION['user']['name'] ?? '???') ?></p>
                    </section>

                    <div class="relative flex items-center justify-center rounded-full bg-primary text-white text-[36px] font-bold border-2 border-white object-contain self-center mt-4 max-w-full aspect-square w-[100px] z-[50]">
                        <span class="flex items-center justify-center">
                            <?= htmlspecialchars(strtoupper(substr(($_SESSION['user']['username'] ?? '?'), 0, 1))) ?>
                        </span>
                    </div>

                    <section class="flex relative flex-col mt-2 p-4">
                        <h2 class="text-2xl font-bold text-center text-white mb-2"><?= htmlspecialchars($eventObj['title']) ?></h2>

                        <div class="flex flex-col items-center gap-4">
                            <div class="flex flex-col items-center gap-1.5">
                                <h3 class="text-lg font-semibold text-amber-100">ช่วงเวลางาน</h3>
                                <div class="flex flex-col items-start font-kanit text-sm text-white leading-none font-normal">
                                    <span class="font-medium">เริ่มงาน: <span class="font-kanit font-light text-sm"><?= dateFormat($eventObj['start']) ?></span></span>
                                    <span class="font-medium">สิ้นสุด: <span class="font-kanit font-light text-sm"><?= dateFormat($eventObj['end']) ?></span></span>
                                </div>
                            </div>
                        </div>
                    </section>

                </section>
            </div>

            <button type="button" id="downloadTickets" class="btn-primary-outline mt-5">
                <img src="public/icons/" alt="">
                <span>ดาวน์โหลดบัตร</span>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (isset($_GET['status'])) : ?>
            document.addEventListener('DOMContentLoaded', () => {
                const status = <?= $_GET['status'] ?>;

                const url = new URL(window.location.href);
                url.searchParams.delete("status");
                window.history.replaceState({}, document.title, url.toString());

                switch (status) {
                    case 409:
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "คุณเป็นผู้สร้างกิจกรรม, คุณมีสิทธิ์เข้าร่วมอยู่แล้ว",
                            icon: "error",
                            timerProgressBar: true,
                            timer: 3500,
                            confirmButtonText: "ปิด"
                        });
                        break;
                    case 403:
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "จำเป็นต้องกรอกข้อมูลส่วนตัวให้เรียบร้อย",
                            icon: "warning",
                            showDenyButton: true,
                            confirmButtonText: "เพิ่มข้อมูลตอนนี้",
                            denyButtonText: "ยังก่อน"
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.href = "../?action=profile&isEdit=true";

                            }

                        });
                        break;

                    default:
                        break;
                }

            })
        <?php endif ?>
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const registerButton = document.getElementById("registerEvent");
            const rejectButton = document.getElementById("rejectEvent");

            const ticketModal = document.getElementById('ticketModal');

            const closeModalBtn = document.getElementById('closeModalBtn');
            const ticketBtn = document.getElementById('acceptEvent');
            const downloadTicketBtn = document.getElementById('downloadTickets');

            if (ticketBtn) {
                ticketBtn.addEventListener('click', () => {
                    ticketModal.classList.toggle('hidden')

                })

                closeModalBtn.addEventListener('click', () => {
                    ticketModal.classList.toggle('hidden')

                })

                // ================================================

                function generateQRCode(element, data, options = {}) {
                    element.innerHTML = '';

                    const defaultOptions = {
                        width: 225,
                        height: 225,
                        colorDark: '#232323',
                        colorLight: '#226E6A',
                        // L (7%), M (15%), Q (25%), and H (30%)
                        correctLevel: QRCode.CorrectLevel.L
                    };

                    const mergedOptions = {
                        ...defaultOptions,
                        ...options
                    };

                    new QRCode(element, {
                        text: data,
                        width: mergedOptions.width,
                        height: mergedOptions.height,
                        colorDark: mergedOptions.colorDark,
                        colorLight: mergedOptions.colorLight,
                        correctLevel: mergedOptions.correctLevel
                    });
                }

                const ticketCode = document.getElementById('ticket-code');

                const ticketData = JSON.stringify({
                    userId: '<?= $_SESSION['user']['userId'] ?>',
                    regId: '<?= $regObj['regId'] ?>',
                    eventId: '<?= $eventObj['eventId'] ?>'
                });

                <?php  unset($regObj); ?>

                // generateQRCode(ticketCode, ticketData, {
                //     colorDark: '#FBF8EE',
                //     colorLight: '#104B48'
                // });

                if (ticketCode) {
                    generateQRCode(ticketCode, ticketData);

                }

                // ================================================

                downloadTicketBtn.addEventListener('click', () => {
                    const ticketDiv = document.getElementById('ticket-canvas');

                    const originalOverflow = ticketDiv.style.overflow;
                    const originalHeight = ticketDiv.style.height;

                    ticketDiv.style.overflow = 'visible';
                    ticketDiv.style.height = 'auto';

                    html2canvas(ticketDiv).then(canvas => {
                        ticketDiv.style.overflow = originalOverflow;
                        ticketDiv.style.height = originalHeight;

                        const link = document.createElement('a');
                        link.download = 'U_<?= $userId ?>-E_<?= $eventId ?>-ticket.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    }).catch(error => {
                        ticketDiv.style.overflow = originalOverflow;
                        ticketDiv.style.height = originalHeight;
                        console.error('Error capturing ticket:', error);
                    });

                })

            }

            const form = document.getElementById('regForm');

            if (registerButton) {
                registerButton.addEventListener("click", function() {
                    // console.log("Clicked work!")

                    Swal.fire({
                        title: "ยืนยันการเข้าร่วม",
                        text: "คุณต้องการเข้าร่วมกิจกรรมนี้หรือไม่?",
                        icon: "warning",
                        showDenyButton: true,
                        confirmButtonText: "เข้าร่วมทันที",
                        denyButtonText: "ไม่่ใช่ตอนนี้"
                    }).then(async (res) => {
                        if (res.isConfirmed) {
                            console.log("Clicked work!")

                            const response = await fetch('../?action=request&on=user&form=profileVerify', {
                                method: 'post',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    userId: '<?= $_SESSION['user']['userId'] ?>'
                                })
                            }).then((res) => {
                                const status = res?.status ?? 404;

                                form.submit();

                            });

                        }

                    });
                });
            }

            if (rejectButton) {
                rejectButton.addEventListener("click", function() {
                    Swal.fire({
                        title: "การเข้าร่วมถูกปฏิเสธ",
                        text: "เหตุผล: <?= htmlspecialchars($regObj['reject_reason'] ?? 'ไม่ระบุ, ติดต่อผู้สร้างกิจกรรม') ?>",
                        icon: "error",
                        confirmButtonText: "ปิด"
                    });
                });
            }
        });

        function scrollToView() {
            const mapSection = document.getElementById('detail-section');
            const navbarHeight = document.getElementById('navbar').offsetHeight;
            window.scrollTo({
                top: mapSection.offsetTop - navbarHeight,
                behavior: 'smooth'
            });
        }

        const container = document.getElementById("imageContainer");

        container.addEventListener("wheel", function(event) {
            event.preventDefault();
            container.scrollLeft += event.deltaY;
        });
    </script>

</body>