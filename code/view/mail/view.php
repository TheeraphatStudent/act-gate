<?php

namespace FinalProject\View;

require_once('components/texteditor/texteditor.php');
require_once('components/breadcrumb.php');

require_once('utils/useTags.php');
require_once('utils/useDateTime.php');

use FinalProject\Components\TextEditor;

use FinalProject\Components\Breadcrumb;

$navigate = new Breadcrumb();

?>

<!DOCTYPE html>
<html lang en>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style/main.css">

    <title>History</title>
</head>

<body class="flex flex-col justify-start items-center bg-primary">
    <div class="flex flex-col w-full gap-14 max-w-content py-[200px] px-10 xl:px-0">

        <div class="rounded-lg overflow-hidden">
            <div class="flex flex-col p-2.5 gap-2.5">
                <?php if (!empty($aboutmail)) : ?>
                    <?php foreach (array_reverse($aboutmail) as $about):

                        // print_r($about);
                        // print_r($about['reg_status']);
                    ?>
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4 p-4 rounded-xl bg-white w-full shadow-sm">
                            <div class="flex flex-col justify-start items-start gap-3 w-full md:w-3/5">
                                <div class="flex items-center gap-2.5 w-full">
                                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white text-xl font-bold">
                                        <?= htmlspecialchars(strtoupper(substr($about['organizeName'], 0, 1))) ?>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <div class="font-bold text-lg text-dark-primary"><?= $about['organizeName'] ?></div>
                                        <div class="font-light text-sm text-neutral-800"><?= dateFormat($about['start']) ?> - <?= dateFormat($about['end']) ?></div>
                                    </div>
                                </div>

                                <div class="w-full h-14 max-h-14 overflow-y-auto">
                                    <h2 class="font-bold text-base text-dark-primary mb-1"><?= $about['title'] ?></h2>
                                    <?php
                                    $editor = new TextEditor();
                                    $editor->updatetextarea($about['description'], false);
                                    ?>
                                    <?php $editor->render(); ?>
                                    <?php
                                    ?>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2.5 w-full md:w-2/5">
                                <div
                                    class="flex flex-col justify-between items-stretch bg-center bg-cover rounded w-full h-36 overflow-hidden bg-dark-primary/50 border-dashed border-primary/60 border-2"
                                    style="background-image: url(public/images/uploads/<?= $about['cover'] ?>);">
                                    <!-- Tag -->
                                    <div class="flex flex-row justify-start items-start gap-2.5 p-2.5 pb-3.5 w-full h-fit bg-gradient-to-b from-dark-primary/50 via-dark-primary/25 to-transparent">
                                        <?php
                                        $selectedTags = [];

                                        if ($about['type'] === 'online' || $about['type'] === 'any') {
                                            $selectedTags[] = "online";
                                        }

                                        if ($about['type'] === 'onsite' || $about['type'] === 'any') {
                                            $selectedTags[] = "onsite";
                                        }

                                        if ($about['venue'] > 0) {
                                            $selectedTags[] = "paid";
                                        } else {
                                            $selectedTags[] = "free";
                                        }

                                        ?>
                                        <?php foreach ($selectedTags as $tag): ?>
                                            <div class='flex justify-center items-center rounded w-16 h-8 shadow-sm <?= $tags[$tag]['background'] ?>'>
                                                <span class='font-kanit text-sm text-center whitespace-nowrap text-opacity-100 leading-none font-normal <?= $tags[$tag]['color'] ?>'>
                                                    <?= $tags[$tag]['text'] ?>
                                                </span>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>

                                <div class="flex flex-row justify-start items-center gap-2.5 w-full">
                                    <!-- <button type="button" class="flex justify-center items-center gap-1 p-2 rounded-lg bg-light-red hover:bg-red/50">
                                        <img
                                            src="public/icons/delete.svg"
                                            alt="Cancel"
                                            class="w-5 h-5" />
                                        <span class="text-red">ยกเลิกการเข้าร่วม</span>
                                    </button> -->

                                    <?php
                                    $statuses = [
                                        'pending' => [
                                            'bg' => 'bg-yellow hover:bg-dark-yellow',
                                            'text' => 'รออนุมัติ',
                                            'icon' => null
                                        ],
                                        'accepted_pending' => [
                                            'bg' => 'bg-primary hover:bg-dark-primary/50',
                                            'text' => 'ดูกิจกรรม/บัตร',
                                            'icon' => 'public/icons/ticket.svg'
                                        ],
                                        'accepted_accepted' => [
                                            'bg' => 'bg-gray-400 hover:bg-gray-800',
                                            'text' => 'เข้าร่วมแล้ว',
                                            'icon' => null
                                        ]
                                    ];

                                    $key = match (true) {
                                        $about['reg_status'] === 'pending' => 'pending',
                                        $about['reg_status'] === 'accepted' && $about['att_status'] === 'pending' => 'accepted_pending',
                                        $about['reg_status'] === 'accepted' && $about['att_status'] === 'accepted' => 'accepted_accepted',
                                        default => null
                                    };

                                    if ($key): ?>
                                        <a href="../?action=event.attendee&id=<?= $about['eventId'] ?>"
                                            class="flex justify-between items-center px-4 py-2 rounded-lg <?= $statuses[$key]['bg'] ?> hover:cursor-pointer flex-grow">
                                            <div class="flex items-center gap-2">
                                                <?php if ($statuses[$key]['icon']): ?>
                                                    <img class="w-6 h-6" src="<?= $statuses[$key]['icon'] ?>" alt="Icon" />
                                                <?php endif; ?>
                                                <span class="text-sm text-white font-medium" lang="th"><?= $statuses[$key]['text'] ?></span>
                                            </div>
                                            <?php if ($key !== 'accepted_accepted'): ?>
                                                <div class="flex justify-center items-center w-6 h-6">
                                                    <img class="w-3 h-3" src="public/icons/arrow-right.svg" alt="Arrow" />
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                    <?php endforeach ?>

                <?php else : ?>
                    <div class="flex flex-col gap-6 text-container justify-center items-center min-h-[450px] drop-shadow-2xl">
                        <div class="animated-text text-white gap-0.5">
                            <?php
                            $text = "คุณยังไม่เคยเข้าร่วมกิจกรรม";
                            $textArray = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

                            foreach ($textArray as $key => $value) {
                                echo "<span class='text-6xl' style='--i:" . ($key + 1) . "'>$value</span>";
                            }
                            ?>
                        </div>
                        <a href="../"
                            class="relative text-white font-semibold text-3xl underline group overflow-hidden">
                            <span class="absolute left-0 bottom-0 w-full h-0 rounded-tl-sm rounded-tr-sm bg-white transition-all duration-300 ease-out group-hover:h-full"></span>
                            <span class="relative group-hover:text-dark-primary px-1 transition-colors duration-300">ค้นหากิจกรรมเลย!</span>
                        </a>
                    </div>

                <?php endif ?>
            </div>
        </div>

        <div id="editProfileModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden mt-24">
            <div class="bg-white rounded-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold font-kanit text-dark-secondary">บัตรเข้างาน</h3>
                    <button type="button" id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Edit User -->
                <form id="editProfileForm" class="space-y-6" action="../?action=request&on=user&form=update" method="post">

                </form>
            </div>
        </div>

    </div>
    <!-- </div> -->

</body>

</html>