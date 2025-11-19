<?php get_header(); ?>

<body style="background-color: #F9F9F9;">

    <?php
    // شروع حلقه وردپرس برای نمایش محتوای صفحه
    if (have_posts()):
        while (have_posts()):
            the_post();

            ?>

            <!-- svg icons -->
            <svg class="hidden">
                <symbol id="chevron-left" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </symbol>

                <symbol id="humberger" viewBox="0 0 25 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_915_1009)">
                        <path d="M23.291 8.58331L1.70768 8.58331" stroke="#1F41A4" stroke-width="3" stroke-linecap="round" />
                        <path d="M23.291 16L1.70768 16" stroke="#1F41A4" stroke-width="3" stroke-linecap="round" />
                        <path d="M23.291 2L1.70768 2" stroke="#1F41A4" stroke-width="3" stroke-linecap="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_915_1009">
                            <rect width="25" height="18" fill="white" />
                        </clipPath>
                    </defs>
                </symbol>
                <symbol id="Magnifer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none">
                    <g clip-path="url(#clip0_24_99)">
                        <circle cx="9.62496" cy="9.62499" r="8.70833" stroke="white" stroke-width="2" />
                        <path opacity="0.5" d="M18.3334 18.3333L20.1667 20.1667" stroke="white" stroke-width="2.5"
                            stroke-linecap="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_24_99">
                            <rect width="22" height="22" fill="white" />
                        </clipPath>
                    </defs>
                </symbol>

                <symbol id="User" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                    <ellipse cx="14" cy="7.00001" rx="4.66667" ry="4.66667" fill="#1F41A4" />
                    <path
                        d="M23.3333 20.4167C23.3333 23.3162 23.3333 25.6667 14 25.6667C4.66663 25.6667 4.66663 23.3162 4.66663 20.4167C4.66663 17.5172 8.8453 15.1667 14 15.1667C19.1546 15.1667 23.3333 17.5172 23.3333 20.4167Z"
                        fill="#C5D4FF" />
                </symbol>

                <symbol id="cartCheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                    <path
                        d="M26.2993 2.30753C26.1266 1.79284 25.5884 1.5223 25.0973 1.70325L24.7184 1.84282C23.9435 2.12828 23.2853 2.37073 22.7673 2.63705C22.2135 2.92182 21.7385 3.27262 21.3813 3.82036C21.0269 4.36386 20.8806 4.96014 20.813 5.61393C20.7828 5.9066 20.7668 6.23053 20.7584 6.58659H7.38671C5.26881 6.58659 3.36228 6.58659 2.80427 7.34668C2.24626 8.10676 2.46441 9.25204 2.90072 11.5426L3.52889 14.7362C3.92498 16.75 4.12303 17.7568 4.81651 18.349C5.51 18.9412 6.49106 18.9412 8.45319 18.9412H15.1187C18.6242 18.9412 20.3769 18.9412 21.466 17.7376C22.555 16.5339 22.6345 15.2553 22.6345 11.3809L22.6345 7.95418C22.6345 6.97958 22.6358 6.32732 22.6875 5.82655C22.7369 5.34797 22.8245 5.10901 22.938 4.93504C23.0487 4.76531 23.2167 4.60669 23.5978 4.41073C24.0036 4.20208 24.5551 3.99721 25.3943 3.68805L25.7226 3.5671C26.2138 3.38614 26.472 2.82222 26.2993 2.30753Z"
                        fill="#C5D4FF" />
                    <path
                        d="M17.0153 10.6822C17.4002 10.298 17.3846 9.68983 16.9804 9.32388C16.5762 8.95793 15.9365 8.97277 15.5515 9.35701L12.4331 12.4696L11.6249 11.6629C11.2399 11.2786 10.6002 11.2638 10.196 11.6298C9.79178 11.9957 9.77618 12.6039 10.1611 12.9881L11.7012 14.5254C11.892 14.7158 12.1565 14.8235 12.4331 14.8235C12.7097 14.8235 12.9742 14.7158 13.165 14.5254L17.0153 10.6822Z"
                        fill="#1F41A4" />
                    <circle cx="10.2942" cy="22.647" r="2.05882" fill="#1F41A4" />
                    <circle cx="17.7059" cy="22.647" r="2.05882" fill="#1F41A4" />
                </symbol>


                <symbol id="chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                    <path d="M14.25 6.75L9 11.25L3.75 6.75" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </symbol>


                <symbol id="phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M6.03759 1.31617L6.6866 2.4791C7.2723 3.52858 7.03718 4.90532 6.11471 5.8278C6.11471 5.8278 6.11471 5.8278 6.11471 5.8278C6.11459 5.82792 4.99588 6.94685 7.02451 8.97548C9.05248 11.0035 10.1714 9.8861 10.1722 9.88529C10.1722 9.88527 10.1722 9.88528 10.1722 9.88525C11.0947 8.96281 12.4714 8.7277 13.5209 9.31339L14.6838 9.96241C16.2686 10.8468 16.4557 13.0692 15.0628 14.4622C14.2258 15.2992 13.2004 15.9505 12.0669 15.9934C10.1588 16.0658 6.91828 15.5829 3.6677 12.3323C0.417128 9.08172 -0.0657854 5.84122 0.00655165 3.93309C0.0495219 2.7996 0.700803 1.77423 1.53781 0.937232C2.93076 -0.455718 5.15317 -0.268563 6.03759 1.31617Z"
                        fill="white" />
                </symbol>

                <symbol id="Sarrowleft" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 37" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M31.6591 5.34105C29.4014 3.08333 25.7677 3.08333 18.5002 3.08333C11.2327 3.08333 7.59893 3.08333 5.34122 5.34105C3.0835 7.59877 3.0835 11.2325 3.0835 18.5C3.0835 25.7675 3.0835 29.4012 5.34121 31.6589C7.59893 33.9167 11.2327 33.9167 18.5002 33.9167C25.7677 33.9167 29.4014 33.9167 31.6591 31.6589C33.9168 29.4012 33.9168 25.7675 33.9168 18.5C33.9168 11.2325 33.9168 7.59877 31.6591 5.34105ZM21.6303 13.0574C22.0818 13.5089 22.0818 14.241 21.6303 14.6926L17.8228 18.5L21.6303 22.3074C22.0818 22.7589 22.0818 23.491 21.6303 23.9426C21.1787 24.3941 20.4466 24.3941 19.9951 23.9426L15.3701 19.3176C15.1532 19.1008 15.0314 18.8067 15.0314 18.5C15.0314 18.1933 15.1532 17.8992 15.3701 17.6824L19.9951 13.0574C20.4466 12.6059 21.1787 12.6059 21.6303 13.0574Z"
                        fill="#C32D2F" />
                </symbol>

                <symbol id="SarrowRight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 37" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.34122 31.6589C7.59893 33.9167 11.2327 33.9167 18.5002 33.9167C25.7677 33.9167 29.4014 33.9167 31.6591 31.6589C33.9168 29.4012 33.9168 25.7675 33.9168 18.5C33.9168 11.2325 33.9168 7.59876 31.6591 5.34105C29.4014 3.08333 25.7677 3.08333 18.5002 3.08333C11.2327 3.08333 7.59893 3.08333 5.34121 5.34105C3.0835 7.59877 3.0835 11.2325 3.0835 18.5C3.0835 25.7675 3.0835 29.4012 5.34122 31.6589ZM15.3701 23.9426C14.9185 23.491 14.9185 22.7589 15.3701 22.3074L19.1775 18.5L15.3701 14.6926C14.9185 14.241 14.9185 13.5089 15.3701 13.0574C15.8216 12.6059 16.5537 12.6059 17.0053 13.0574L21.6303 17.6824C21.8471 17.8992 21.9689 18.1933 21.9689 18.5C21.9689 18.8067 21.8471 19.1007 21.6303 19.3176L17.0053 23.9426C16.5537 24.3941 15.8216 24.3941 15.3701 23.9426Z"
                        fill="#C32D2F" />
                </symbol>


                <symbol id="arrowleft3" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.02018 3.64645C7.21544 3.84171 7.21544 4.15829 7.02018 4.35355L3.87373 7.5H13.3333C13.6094 7.5 13.8333 7.72386 13.8333 8C13.8333 8.27614 13.6094 8.5 13.3333 8.5H3.87373L7.02018 11.6464C7.21544 11.8417 7.21544 12.1583 7.02018 12.3536C6.82492 12.5488 6.50833 12.5488 6.31307 12.3536L2.31307 8.35355C2.11781 8.15829 2.11781 7.84171 2.31307 7.64645L6.31307 3.64645C6.50833 3.45118 6.82492 3.45118 7.02018 3.64645Z"
                        fill="#1F41A4" stroke="#1F41A4" />
                </symbol>

                <symbol id="bag" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M3.79424 14.9709C4.33141 17.6567 4.59999 18.9996 5.48746 19.8646C5.65149 20.0244 5.82894 20.1699 6.01786 20.2994C7.04004 21 8.40956 21 11.1486 21H12.8515C15.5906 21 16.9601 21 17.9823 20.2994C18.1712 20.1699 18.3486 20.0244 18.5127 19.8646C19.4001 18.9996 19.6687 17.6567 20.2059 14.9709C20.9771 11.1149 21.3627 9.18686 20.475 7.82067C20.3143 7.5733 20.1267 7.34447 19.9157 7.13836C18.7501 6 16.7839 6 12.8515 6H11.1486C7.21622 6 5.25004 6 4.08447 7.13836C3.87342 7.34447 3.68582 7.5733 3.5251 7.82067C2.63744 9.18686 3.02304 11.1149 3.79424 14.9709Z"
                        stroke="#282828" stroke-width="1.5" />
                    <circle cx="15" cy="10" r="1" fill="#282828" />
                    <circle cx="9" cy="10" r="1" fill="#282828" />
                    <path d="M9 6V5C9 3.34315 10.3431 2 12 2C13.6569 2 15 3.34315 15 5V6" stroke="#282828" stroke-width="1.5"
                        stroke-linecap="round" />
                </symbol>

                <symbol id="vector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122 115" fill="none">
                    <path
                        d="M117.262 0.04879C112.361 0.472015 107.642 2.38147 103.945 5.4425C102.789 6.39722 99.2065 10.0783 97.9837 11.5646C88.7746 22.726 83.7975 37.6571 83.7879 54.1335C83.7879 61.6729 84.7432 68.7891 86.7111 75.9151C86.9022 76.5844 87.0359 77.1651 87.0168 77.2143C86.9691 77.3422 84.8005 79.2418 83.0237 80.7084C76.2984 86.2596 69.2291 90.482 62.1503 93.1592C59.0838 94.3206 57.0681 94.7832 54.9856 94.7734C53.3711 94.7734 52.7597 94.6454 51.6993 94.0942C50.467 93.4643 49.2156 92.2734 48.671 91.2399L48.4991 90.9052L50.7536 88.5627C54.164 85.0292 56.4854 82.293 58.8545 79.0351C67.3185 67.4013 69.124 58.2083 64.3762 51.0036C63.5451 49.7536 61.8255 48.0016 60.6219 47.165C58.8641 45.9642 57.1637 45.2457 54.9378 44.7634C53.887 44.537 53.524 44.4977 51.9286 44.4977C50.4097 44.4977 49.9511 44.5371 49.1391 44.7142C42.6144 46.1709 38.1341 51.6827 35.698 61.2694C34.8383 64.6552 34.1313 69.0154 33.6824 73.671C33.3289 77.4111 33.3289 82.3029 33.6919 85.5804L33.8543 86.9978L33.52 87.3029C33.3385 87.4604 32.2207 88.5135 31.0362 89.6257C24.0625 96.1808 15.4648 103.395 8.63435 108.415L7.3638 109.35L0 115H7.3638H14.3295H21.4943L23.1167 113.858C28.2658 109.734 36.0324 103.031 38.4684 100.62L38.9556 100.138L39.739 101.073C42.4998 104.37 46.5407 106.811 50.6581 107.677C52.3967 108.031 53.887 108.159 55.7021 108.09C59.1889 107.953 62.6184 107.165 66.9364 105.502C75.1902 102.342 83.3103 97.4997 90.9527 91.2005C91.7074 90.5706 92.4047 90.0096 92.4907 89.9407C92.6245 89.8324 92.7295 89.9308 93.2168 90.5804C97.143 95.7773 102.875 98.3068 109.342 97.6867C112.877 97.3423 116.985 96.1021 121.006 94.1434L122 93.6612V85.9249V78.1788L121.102 78.8284C116.784 81.9092 111.415 84.2123 107.976 84.4584C105.712 84.6257 104.203 83.7792 102.76 81.5155L102.206 80.6493L103.286 79.4977C108.626 73.8186 115.026 65.7576 120.777 57.4898L122 55.7379L121.99 41.7418V27.7555L121.532 29.0843C118.867 36.8303 113.861 45.3048 105.005 57.0371C101.604 61.5351 97.7735 66.2202 97.6876 65.9741C97.6016 65.7182 97.1621 62.5587 97.0189 61.1709C96.6845 57.8245 96.5794 53.3461 96.78 50.1965C97.5251 38.5626 101.289 28.1689 107.565 20.4721C109.333 18.2969 112.036 15.6591 113.202 14.9504C115.781 13.3953 119.296 12.8342 121.484 13.6216L122 13.8087V6.99763V0.176743L121.561 0.107849C120.768 -0.000411987 118.246 -0.0397949 117.262 0.04879ZM52.7502 57.8835C53.3902 58.0804 53.9443 58.6316 54.0398 59.1729C54.0781 59.3796 54.0589 59.8914 54.0016 60.3146C53.6864 62.5587 51.9477 66.1808 49.4735 69.7536C48.6137 71.0036 46.7222 73.5036 46.6745 73.4544C46.6267 73.4052 47.1712 69.5765 47.4291 68.1099C47.7539 66.2792 48.3462 63.8284 48.7761 62.5489C49.4926 60.4032 50.6199 58.3658 51.3363 57.9229C51.7089 57.6867 52.0624 57.6768 52.7502 57.8835Z"
                        fill="#1F41A4" fill-opacity="0.1" />
                </symbol>


                <symbol id="vectorleft" xmlns="http://www.w3.org/2000/svg" width="122" height="115" viewBox="0 0 122 115"
                    fill="none">
                    <path
                        d="M4.73831 0.04879C9.63901 0.472015 14.3582 2.38147 18.0552 5.4425C19.2111 6.39722 22.7935 10.0783 24.0163 11.5646C33.2254 22.726 38.2025 37.6571 38.2121 54.1335C38.2121 61.6729 37.2568 68.7891 35.2889 75.9151C35.0978 76.5844 34.9641 77.1651 34.9832 77.2143C35.0309 77.3422 37.1995 79.2418 38.9763 80.7084C45.7016 86.2596 52.7709 90.482 59.8497 93.1592C62.9162 94.3206 64.9319 94.7832 67.0144 94.7734C68.6289 94.7734 69.2403 94.6454 70.3007 94.0942C71.533 93.4643 72.7844 92.2734 73.329 91.2399L73.5009 90.9052L71.2464 88.5627C67.836 85.0292 65.5146 82.293 63.1455 79.0351C54.6815 67.4013 52.876 58.2083 57.6238 51.0036C58.4549 49.7536 60.1745 48.0016 61.3781 47.165C63.1359 45.9642 64.8363 45.2457 67.0622 44.7634C68.113 44.537 68.476 44.4977 70.0714 44.4977C71.5903 44.4977 72.0489 44.5371 72.8609 44.7142C79.3856 46.1709 83.8659 51.6827 86.302 61.2694C87.1617 64.6552 87.8687 69.0154 88.3176 73.671C88.6711 77.4111 88.6711 82.3029 88.3081 85.5804L88.1457 86.9978L88.48 87.3029C88.6615 87.4604 89.7793 88.5135 90.9638 89.6257C97.9375 96.1808 106.535 103.395 113.366 108.415L114.636 109.35L122 115H114.636H107.67H100.506L98.8833 113.858C93.7342 109.734 85.9676 103.031 83.5316 100.62L83.0444 100.138L82.261 101.073C79.5002 104.37 75.4593 106.811 71.3419 107.677C69.6033 108.031 68.113 108.159 66.2979 108.09C62.8111 107.953 59.3816 107.165 55.0636 105.502C46.8098 102.342 38.6897 97.4997 31.0473 91.2005C30.2926 90.5706 29.5953 90.0096 29.5093 89.9407C29.3755 89.8324 29.2705 89.9308 28.7832 90.5804C24.857 95.7773 19.1251 98.3068 12.6578 97.6867C9.12314 97.3423 5.01534 96.1021 0.993515 94.1434L7.62939e-06 93.6612V85.9249V78.1788L0.897995 78.8284C5.21596 81.9092 10.5847 84.2123 14.0238 84.4584C16.2879 84.6257 17.7973 83.7792 19.2398 81.5155L19.7939 80.6493L18.7144 79.4977C13.3742 73.8186 6.97372 65.7576 1.2228 57.4898L7.62939e-06 55.7379L0.00956726 41.7418V27.7555L0.468109 29.0843C3.1334 36.8303 8.13918 45.3048 16.9948 57.0371C20.3957 61.5351 24.2265 66.2202 24.3124 65.9741C24.3984 65.7182 24.8379 62.5587 24.9811 61.1709C25.3155 57.8245 25.4206 53.3461 25.22 50.1965C24.4749 38.5626 20.711 28.1689 14.4346 20.4721C12.6673 18.2969 9.9638 15.6591 8.79833 14.9504C6.21902 13.3953 2.70351 12.8342 0.515877 13.6216L7.62939e-06 13.8087V6.99763V0.176743L0.439453 0.107849C1.23235 -0.000411987 3.75435 -0.0397949 4.73831 0.04879ZM69.2498 57.8835C68.6098 58.0804 68.0557 58.6316 67.9602 59.1729C67.9219 59.3796 67.9411 59.8914 67.9984 60.3146C68.3136 62.5587 70.0523 66.1808 72.5265 69.7536C73.3863 71.0036 75.2778 73.5036 75.3255 73.4544C75.3733 73.4052 74.8288 69.5765 74.5709 68.1099C74.2461 66.2792 73.6538 63.8284 73.2239 62.5489C72.5074 60.4032 71.3801 58.3658 70.6637 57.9229C70.2911 57.6867 69.9376 57.6768 69.2498 57.8835Z"
                        fill="#1F41A4" fill-opacity="0.1" />
                </symbol>

                <symbol id="clock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 36" fill="none">
                    <rect x="0.40625" y="0.203125" width="36.2032" height="35.3613" rx="5.05161" fill="#F0F4FF" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M19 27.1446C23.8362 27.1446 27.7567 23.4226 27.7567 18.8314C27.7567 14.2401 23.8362 10.5181 19 10.5181C14.1638 10.5181 10.2433 14.2401 10.2433 18.8314C10.2433 23.4226 14.1638 27.1446 19 27.1446ZM19 14.4438C19.403 14.4438 19.7297 14.754 19.7297 15.1366V18.5444L21.9484 20.6507C22.2334 20.9213 22.2334 21.3599 21.9484 21.6304C21.6634 21.901 21.2014 21.901 20.9164 21.6304L18.484 19.3212C18.3472 19.1913 18.2703 19.0151 18.2703 18.8314V15.1366C18.2703 14.754 18.597 14.4438 19 14.4438Z"
                        fill="#1F41A4" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.2405 8.3036C15.4541 8.62805 15.3502 9.05545 15.0084 9.25823L11.1166 11.5675C10.7748 11.7702 10.3246 11.6716 10.111 11.3472C9.89742 11.0227 10.0013 10.5953 10.3431 10.3925L14.2349 8.0833C14.5767 7.88052 15.0269 7.97915 15.2405 8.3036Z"
                        fill="#1F41A4" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M22.7595 8.3036C22.9731 7.97915 23.4233 7.88052 23.7651 8.0833L27.6569 10.3925C27.9987 10.5953 28.1026 11.0227 27.889 11.3472C27.6754 11.6716 27.2252 11.7702 26.8834 11.5675L22.9916 9.25823C22.6498 9.05545 22.5459 8.62805 22.7595 8.3036Z"
                        fill="#1F41A4" />
                </symbol>

                <symbol id="location" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 36" fill="none">
                    <rect x="0.40625" y="0.306641" width="36.2032" height="35.3613" rx="5.05161" fill="#F0F4FF" />
                    <path
                        d="M18.5001 28.0839C23.7928 28.0839 28.0834 26.1531 28.0834 23.7714C28.0834 22.5575 26.9689 21.4608 25.1753 20.6771C24.0808 22.6856 22.4117 24.4169 20.2917 25.3229C19.1522 25.8098 17.848 25.8098 16.7085 25.3229C14.5884 24.4169 12.9194 22.6856 11.8249 20.6771C10.0312 21.4608 8.91675 22.5575 8.91675 23.7714C8.91675 26.1531 13.2074 28.0839 18.5001 28.0839Z"
                        fill="#1F41A4" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.7915 15.1602C11.7915 11.7122 14.7949 8.91699 18.4998 8.91699C22.2047 8.91699 25.2082 11.7122 25.2082 15.1602C25.2082 18.5812 23.0671 22.5732 19.7266 24.0007C18.9478 24.3335 18.0518 24.3335 17.2731 24.0007C13.9326 22.5732 11.7915 18.5812 11.7915 15.1602ZM18.4998 17.542C19.5584 17.542 20.4165 16.6839 20.4165 15.6253C20.4165 14.5668 19.5584 13.7087 18.4998 13.7087C17.4413 13.7087 16.5832 14.5668 16.5832 15.6253C16.5832 16.6839 17.4413 17.542 18.4998 17.542Z"
                        fill="#1F41A4" />
                </symbol>

                <symbol id="call" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 36" fill="none">
                    <rect x="0.40625" width="36.2032" height="35.3613" rx="5.05161" fill="#F0F4FF" />
                    <path
                        d="M23.5832 17.9999C26.1145 17.9999 28.1665 15.9479 28.1665 13.4166C28.1665 10.8853 26.1145 8.83325 23.5832 8.83325C21.0519 8.83325 18.9998 10.8853 18.9998 13.4166C18.9998 14.1498 19.172 14.8428 19.4781 15.4573C19.5594 15.6206 19.5865 15.8073 19.5393 15.9835L19.2664 17.0038C19.1479 17.4467 19.5531 17.8519 19.996 17.7334L21.0162 17.4604C21.1925 17.4132 21.3791 17.4403 21.5425 17.5217C22.157 17.8278 22.85 17.9999 23.5832 17.9999Z"
                        fill="#1F41A4" />
                    <path
                        d="M15.3677 13.7064L15.9626 14.7724C16.4995 15.7344 16.284 16.9964 15.4384 17.842C15.4384 17.842 15.4384 17.842 15.4384 17.842C15.4383 17.8421 14.4128 18.8678 16.2724 20.7274C18.1314 22.5864 19.1571 21.5621 19.1578 21.5614C19.1578 21.5614 19.1578 21.5614 19.1578 21.5614C20.0034 20.7158 21.2654 20.5003 22.2274 21.0372L23.2934 21.6321C24.7461 22.4428 24.9177 24.48 23.6408 25.7569C22.8735 26.5241 21.9336 27.1211 20.8946 27.1605C19.1455 27.2268 16.175 26.7842 13.1953 23.8045C10.2156 20.8248 9.77295 17.8543 9.83926 16.1052C9.87865 15.0662 10.4757 14.1263 11.2429 13.359C12.5198 12.0821 14.557 12.2537 15.3677 13.7064Z"
                        fill="#1F41A4" />
                </symbol>

                <symbol id="ArrowLeft2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.02018 3.64645C7.21544 3.84171 7.21544 4.15829 7.02018 4.35355L3.87373 7.5H13.3333C13.6094 7.5 13.8333 7.72386 13.8333 8C13.8333 8.27614 13.6094 8.5 13.3333 8.5H3.87373L7.02018 11.6464C7.21544 11.8417 7.21544 12.1583 7.02018 12.3536C6.82492 12.5488 6.50833 12.5488 6.31307 12.3536L2.31307 8.35355C2.11781 8.15829 2.11781 7.84171 2.31307 7.64645L6.31307 3.64645C6.50833 3.45118 6.82492 3.45118 7.02018 3.64645Z"
                        fill="#1F41A4" stroke="#1F41A4" />
                </symbol>


                <symbol id="arrow3" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M3.17568 3.17592C4.51811 1.8335 6.67871 1.8335 10.9999 1.8335C15.3211 1.8335 17.4817 1.8335 18.8242 3.17592C20.1666 4.51835 20.1666 6.67895 20.1666 11.0002C20.1666 15.3214 20.1666 17.482 18.8242 18.8244C17.4817 20.1668 15.3211 20.1668 10.9999 20.1668C6.67871 20.1668 4.51811 20.1668 3.17568 18.8244C1.83325 17.482 1.83325 15.3214 1.83325 11.0002C1.83325 6.67895 1.83325 4.51835 3.17568 3.17592Z"
                        fill="#C32D2F" />
                    <path
                        d="M7.71973 8.40772C7.71973 8.02802 8.02753 7.72022 8.40723 7.72022L12.2963 7.72021C12.676 7.72021 12.9838 8.02802 12.9838 8.40771C12.9838 8.78741 12.676 9.09521 12.2963 9.09521H10.067L14.0788 13.107C14.3473 13.3755 14.3473 13.8108 14.0788 14.0793C13.8103 14.3478 13.375 14.3478 13.1065 14.0793L9.09473 10.0675L9.09473 12.2968C9.09473 12.6765 8.78692 12.9843 8.40723 12.9843C8.02753 12.9843 7.71973 12.6765 7.71973 12.2968L7.71973 8.40772Z"
                        fill="white" />
                </symbol>


            </svg>

            <!-- Swiper -->

            <style>
                .swiper-pagination-bullet {
                    background-color: #DBE4FF;
                    opacity: 1;
                }
            </style>

            <?php
            $dollar_enabled = get_option('dollar_enabled', false); // مقدار پیش‌فرض false
    
            $dollar_price = get_option('dollar_price', '');
            $dollar = ($dollar_enabled === 'true') ? $dollar_price : 1;
            $dollar = number_format((float) $dollar, 0, '.', '');
            ?>



            <?php
            $slider_data = get_option('front_page_slider', []);
            // echo '<pre>';
            // var_dump($slider_data);
            // echo '</pre>';
            if (!empty($slider_data)):
                ?>
                <div class="lg:w-[1348px] w-[90%] 2xl:container mx-auto mt-24 lg:mt-6 px-6">

                    <div class="swiper mySwiper max-h-[500px] rounded-3xl block mx-auto">

                        <div class="swiper-wrapper ">
                            <?php foreach ($slider_data as $slider): ?>
                                <div class="swiper-slide rounded-3xl relative">
                                    <?php if (!wp_is_mobile()): ?>
                                        <img class="w-full rounded-3xl lg:h-full" src="<?php echo esc_url($slider['image']); ?>">
                                    <?php else: ?>
                                        <img class="w-full rounded-3xl h-[220px]" src="<?php echo esc_url($slider['mobile_image']); ?>">
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url($slider['url']); ?>"
                                        class="bg-red-600 lg:px-5 px-3 py-3 absolute top-[48%] xl:top-[70%] left-[4%] font-sansBold text-white rounded-xl">مشاهده
                                        محصولات</a>
                                </div>

                            <?php endforeach; ?>



                        </div>

                        <div class="">
                            <div class="swiper-pagination bg-white w-fit"></div>
                        </div>

                    </div>


                </div>
            <?php endif; ?>



            <!-- category 1 for Desktop -->
            <?php
            $shortcuts = get_option('frontpage_shortcuts', array());
            if (!empty($shortcuts)):
                ?>
                <div class="mt-12 w-[90%] 2xl:container font-sansFanumBold mx-auto lg:px-6">

                    <div class="relative px-3 lg:px-[70px] pt-9 lg:pb-9 pb-2 bg-nili-100 rounded-3xl">

                        <div class="swiper CategoryProducts1 w-full  z-10 ">

                            <div class="swiper-wrapper h-full">


                                <?php foreach ($shortcuts as $shortcut): ?>
                                    <div class="swiper-slide h-full">
                                        <a href="<?php echo esc_url($shortcut['url']); ?>"
                                            class=" flex flex-col justify-between items-center gap-y-8 bg-white py-6 px-2 lg:px-4 rounded-2xl h-[206px]">
                                            <img class="min-h-[72px] my-auto" src="<?php echo esc_url($shortcut['image']); ?>">
                                            <div class="text-dark_title text-center font-[13px] lg:font-[14px]">
                                                <?php echo esc_html($shortcut['caption']); ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>





                            </div>

                        </div>


                        <div
                            class="h-10 w-[97%] bg-nili-300 rounded-br-3xl rounded-bl-3xl mx-auto  -bottom-3 lg:-bottom-6 absolute -z-10 left-0 right-0">

                        </div>



                        <div class="flex lg:hidden items-center justify-center mt-4 gap-x-2">


                            <div class="swiper-button-next-1">
                                <svg class="w-9 h-9">
                                    <use href="#SarrowRight"></use>
                                </svg>
                            </div>

                            <div class="swiper-button-prev-1">
                                <svg class="w-9 h-9">
                                    <use href="#Sarrowleft"></use>
                                </svg>
                            </div>


                        </div>

                    </div>

                </div>
            <?php endif; ?>


            <!-- category 2 for Desktop -->
            <?php
            $saved_categories = get_option('hompage-first-categories', []);
            $section_title = get_option('hompage-first-categories-title', 'عنوان پیش‌فرض');


            if (!empty($saved_categories) && is_array($saved_categories)) {
                ?>
                <div class="mt-[63px] w-[90%] 2xl:container mx-auto bg-white shadow-2xl rounded-3xl lg:px-6">


                    <div class="flex flex-col items-center pt-8 pb-4 lg:py-10 gap-y-9 px-3 lg:px-[70px]">

                        <div class="font-sansFanumBold text-xl flex items-center gap-x-1 justify-start text-center">
                            <div>خرید انواع</div>
                            <div class="text-mainBlue"><?php echo $section_title ? $section_title : ''; ?></div>
                            <div>برای انواع فلزات</div>
                        </div>


                        <div class="swiper CategoryProducts2 self-start font-sansFanumBold w-full  p-8">

                            <div class="swiper-wrapper h-full">



                                <?php

                                foreach ($saved_categories as $cat_id) {
                                    // دریافت شیء ترم بر اساس آیدی و taxonomy مربوطه
                                    $term = get_term($cat_id, 'product_cat');
                                    if (!is_wp_error($term) && $term) {
                                        // لینک دسته‌بندی
                                        $term_link = get_term_link($term);
                                        // دریافت آیدی تصویر بند انگشتی دسته‌بندی
                                        $thumbnail_id = get_term_meta($cat_id, 'thumbnail_id', true);
                                        // اگر تصویر موجود باشد، آدرس آن را می‌گیریم، در غیر این صورت از تصویر placeholder ووکامرس استفاده می‌کنیم
                                        if ($thumbnail_id) {
                                            $image_url = wp_get_attachment_url($thumbnail_id);
                                        } else {
                                            $image_url = wc_placeholder_img_src();
                                        }
                                        ?>
                                        <a href="<?php echo esc_url($term_link); ?>" class="swiper-slide py-2 px-3 h-full">
                                            <div
                                                class="outline outline-2 outline-offset-0 outline-nili-100 rounded-2xl shadow relative h-full">
                                                <div
                                                    class="flex flex-col items-center bg-white rounded-2xl py-3 lg:py-5 px-3 h-[220px] relative z-[1]">
                                                    <img class="min-h-[72px] my-auto" src="<?php echo esc_url($image_url); ?>"
                                                        alt="<?php echo esc_attr($term->name); ?>">
                                                    <div class="text-dark_title text-center lg:mt-5 text-[13px] lg:text-[14px]">
                                                        <?php echo esc_html($term->name); ?>
                                                    </div>
                                                </div>
                                                <div class="w-[110%] h-[100%] -right-[5%] left-0 top-0 py-8 -z-0 rounded-2xl absolute">
                                                    <div class="bg-nili-100 h-full rounded-2xl"></div>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                }

                                ?>


                            </div>


                            <div class="flex lg:hidden items-center justify-center mt-4 gap-x-2">


                                <div class="swiper-button-next-2">
                                    <svg class="w-9 h-9">
                                        <use href="#SarrowRight"></use>
                                    </svg>
                                </div>

                                <div class="swiper-button-prev-2">
                                    <svg class="w-9 h-9">
                                        <use href="#Sarrowleft"></use>
                                    </svg>
                                </div>


                            </div>


                        </div>



                    </div>
                </div>
                <?php
            }
            ?>


            <!-- new products -->

            <div class="bg-white overflow-x-hidden mt-24">

                <div class="w-[90%] 2xl:container mx-auto py-[40px]  rounded-3xl  bg-white relative">

                    <div class="flex items-center justify-between px-3 lg:px-[70px]">
                        <div class="lg:text-[22px] text-lg flex items-start justify-start gap-x-1">
                            <p class="font-sansBold text-mainBlue">جدید ترین</p>
                            <p class="font-sansBold text-black">محصولات</p>
                        </div>

                        <a href="<?php echo esc_url(get_home_url()); ?>/shop"
                            class="text-base flex items-center justify-start gap-x-1 border-4 rounded-xl border-[#D2DDFE] p-2 lg:p-4">
                            <div class="font-sansRegular text-mainBlue">
                                مشاهده محصولات
                            </div>

                            <div class="">
                                <svg class="w-4 h-4">
                                    <use href="#arrowleft3"></use>
                                </svg>
                            </div>
                        </a>
                    </div>




                    <div class="px-3 lg:px-[70px] ">

                        <div class="swiper CategoryProducts3 w-full z-10 p-8">

                            <div class="swiper-wrapper h-full ">



                                <?php
                                // کوئری برای دریافت حداکثر ۴ محصول مرتبط با دسته‌بندی
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 8,
                                    'post_status' => 'publish',
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                );

                                $query = new WP_Query($args);

                                if ($query->have_posts()) {
                                    while ($query->have_posts()) {
                                        $query->the_post();
                                        global $product;

                                        // دریافت اطلاعات محصول
                                        $product_id = get_the_ID();
                                        $product_title = get_the_title();
                                        $product_price = $product->get_price_html();
                                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium')[0] ?? '';
                                        $inventory = false;
                                        if ($product->is_in_stock()) {
                                            $inventory = true;
                                        } else {
                                            $inventory = false;
                                        }
                                        // قالب HTML برای هر محصول
                                        ?>

                                        <div class="swiper-slide h-full shadow-lg">


                                            <?php
                                            // این تابع دقیقاً content-product.php قالب شما رو بارگذاری می‌کنه
                                            wc_get_template_part('content', 'product');
                                            ?>


                                        </div>

                                        <?php
                                    }

                                    // ریست کردن کوئری
                                    wp_reset_postdata();
                                } else {
                                    echo '<p>هیچ محصولی برای نمایش وجود ندارد.</p>';
                                }

                                ?>








                            </div>

                            <div class="lg:hidden mt-4 gap-x-2 flex justify-center">

                                <div class="swiper-button-next-3 h-9">
                                    <svg class="w-9 h-9">
                                        <use href="#SarrowRight"></use>
                                    </svg>
                                </div>

                                <div class="swiper-button-prev-3">
                                    <svg class="w-9 h-9">
                                        <use href="#Sarrowleft"></use>
                                    </svg>
                                </div>


                            </div>
                        </div>

                    </div>


                    <div
                        class="absolute w-full lg:w-[98%] h-[167px] bottom-2 lg:bottom-0 bg-[#9BB5FF] rounded-[18px] left-[1%]">

                        <div class="relative w-full h-full">

                            <div class="absolute bottom-0 right-0">
                                <svg class="w-[90px] h-[90px] lg:w-[122px] lg:h-[115px]">
                                    <use href="#vector"></use>
                                </svg>
                            </div>

                            <div class="absolute bottom-0 left-0">
                                <svg class="w-[90px] h-[90px] lg:w-[122px] lg:h-[115px]">
                                    <use href="#vectorleft"></use>
                                </svg>
                            </div>


                        </div>
                    </div>



                    <div class="">


                        <div class="swiper-button-next-31 hidden lg:flex absolute top-2/4 right-0">
                            <svg class="w-9 h-9">
                                <use href="#SarrowRight"></use>
                            </svg>
                        </div>


                        <div class="swiper-button-prev-31 hidden lg:flex absolute top-2/4 left-0">
                            <svg class="w-9 h-9">
                                <use href="#Sarrowleft"></use>
                            </svg>
                        </div>


                    </div>






                </div>

            </div>


            <?php
            // دریافت شناسه‌های ذخیره شده برندها
            $saved_brands = get_option('selected_brands', array());
            $brand_title = get_option('brands_section_title', '');

            if (!empty($saved_brands)) {
                ?>
                <div class="w-[90%] 2xl:container mt-9 px-3 lg:px-[70px] lg:mt-12 rounded-3xl bg-white shadow-lg mx-auto py-7">

                    <div class="flex items-center justify-center font-sansBold text-black gap-x-2 text-base lg:text-[22px]">خرید<p
                            class="text-mainBlue"><?php echo $brand_title ? $brand_title : '' ?></p>از برند های مطرح بن المللی</div>

                    <div class="mt-5 lg:mt-9">

                        <div class="swiper CategoryProducts4 w-full  z-10 h-[128px] lg:h-[196px] ">

                            <div class="swiper-wrapper h-full">

                                <?php

                                foreach ($saved_brands as $brand_id) {
                                    $brand = get_term($brand_id, 'product_brand');
                                    if (!is_wp_error($brand)) {
                                        // دریافت لینک برند
                                        $brand_link = get_term_link($brand);

                                        // بررسی تصویر بندانگشتی برند
                                        $thumbnail_id = get_term_meta($brand_id, 'thumbnail_id', true);
                                        if ($thumbnail_id) {
                                            $image_url = wp_get_attachment_image_url($thumbnail_id, 'full');
                                        } else {
                                            // استفاده از تصویر placeholder ووکامرس
                                            $image_url = wc_placeholder_img_src();
                                        }
                                        ?>
                                        <a href="<?php echo esc_url($brand_link); ?>" class="swiper-slide py-4">
                                            <div
                                                class="bg-gradient-category py-[14px] lg:py-[22px] my-auto rounded-2xl h-full w-full shadow-lg">
                                                <div class="flex justify-between items-center w-full h-full my-auto">
                                                    <div class="flex flex-col items-center justify-between gap-y-2 w-full h-full my-auto">
                                                        <img class="max-h-10 lg:max-h-[65px]" src="<?php echo esc_url($image_url); ?>"
                                                            alt="<?php echo esc_attr($brand->name); ?>">
                                                        <div class="flex items-center gap-x-1">
                                                            <div class="font-sansBold text-mainBlue text-[12px] lg:text-[14px]">مشاهده
                                                                محصولات</div>
                                                            <div>
                                                                <svg class="w-6 h-6">
                                                                    <use href="#Sarrowleft"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                }

                                ?>


                            </div>

                        </div>


                        <div class="flex lg:hidden items-center justify-center mt-4 gap-x-2">


                            <div class="swiper-button-next-4">
                                <svg class="w-9 h-9">
                                    <use href="#SarrowRight"></use>
                                </svg>
                            </div>

                            <div class="swiper-button-prev-4">
                                <svg class="w-9 h-9">
                                    <use href="#Sarrowleft"></use>
                                </svg>
                            </div>


                        </div>
                    </div>

                </div>
                <?php
            }
            ?>

            <?php
            $second_saved_categories = get_option('hompage-second-categories', []);
            $second_section_title = get_option('hompage-second-categories-title', 'عنوان پیش‌فرض');


            if (!empty($second_saved_categories) && is_array($second_saved_categories)):
                ?>
                <div
                    class="w-[90%] 2xl:container px-3 lg:px-[70px] mx-auto mt-9 lg:mt-12 rounded-3xl py-8 shadow-lg bg-usefull-products text-black font-sansBold">

                    <div class="flex items-center justify-center font-sansBold text-black gap-x-2 text-base lg:text-[22px] ">کاربردی
                        ترین دستگاه های<p class="text-mainBlue"><?php echo $second_section_title ? $second_section_title : ''; ?>
                        </p>
                    </div>


                    <div class="mt-5 lg:mt-9">

                        <div class="relative">

                            <div class="swiper CategoryProducts5 w-full  z-10 ">

                                <div class="swiper-wrapper h-full">
                                    <?php

                                    foreach ($second_saved_categories as $cat_id) {
                                        // دریافت شیء ترم بر اساس آیدی و taxonomy مربوطه
                                        $term = get_term($cat_id, 'product_cat');
                                        if (!is_wp_error($term) && $term) {
                                            // لینک دسته‌بندی
                                            $term_link = get_term_link($term);
                                            // دریافت آیدی تصویر بند انگشتی دسته‌بندی
                                            $thumbnail_id = get_term_meta($cat_id, 'thumbnail_id', true);
                                            // اگر تصویر موجود باشد، آدرس آن را می‌گیریم، در غیر این صورت از تصویر placeholder ووکامرس استفاده می‌کنیم
                                            if ($thumbnail_id) {
                                                $image_url = wp_get_attachment_url($thumbnail_id);
                                            } else {
                                                $image_url = wc_placeholder_img_src();
                                            }
                                            ?>
                                            <a href="<?php echo esc_url($term_link); ?>"
                                                class="swiper-slide h-full border-b-[6px] border-nili-100 rounded-xl">
                                                <div
                                                    class=" flex flex-col justify-between items-center gap-y-8 bg-white py-6 px-2 lg:px-4 rounded-2xl h-[206px]">
                                                    <img class="min-h-[72px] my-auto" src="<?php echo esc_url($image_url); ?>"
                                                        alt="<?php echo esc_attr($term->name); ?>">
                                                    <div class="text-dark_title text-center font-[13px] lg:font-[14px]">
                                                        <?php echo esc_html($term->name); ?>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    }

                                    ?>
                                </div>
                            </div>





                            <div class="flex lg:hidden items-center justify-center mt-4 gap-x-2">


                                <div class="swiper-button-next-5">
                                    <svg class="w-9 h-9">
                                        <use href="#SarrowRight"></use>
                                    </svg>
                                </div>

                                <div class="swiper-button-prev-5">
                                    <svg class="w-9 h-9">
                                        <use href="#Sarrowleft"></use>
                                    </svg>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            <?php endif; ?>


            <div
                class="w-[90%] 2xl:container px-3 lg:px-[70px] mx-auto mt-9 lg:mt-12 rounded-3xl py-8 shadow-lg font-sansFanumBold text-[12px] lg:text-lg">

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-x-7">

                    <div class="col-span-3 px-4 lg:px-12 bg-white py-8 rounded-xl">
                        <?php
                        // دریافت اطلاعات ذخیره شده (اگر موجود باشد)
                        $hompage_addresses_saved_data = get_option('homepage-addresses', array(
                            'address' => '',
                            'phone1' => '',
                            'phone2' => '',
                            'working_hours' => ''
                        ));
                        ?>
                        <div class="space-y-4 lg:space-y-6">
                            <div class="flex items-start gap-x-2 lg:gap-x-4 ">
                                <div>
                                    <svg class="w-9 h-9">
                                        <use href="#location"></use>
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <p>آدرس</p>
                                    <div class="font-sansRegular">
                                        <?php echo wpautop($hompage_addresses_saved_data['address']); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-x-2 lg:gap-x-4 space-y-2">
                                <div>
                                    <svg class="w-9 h-9">
                                        <use href="#call"></use>
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <p>شماره های تماس : </p>
                                    <?php
                                    // ۱. شماره‌ی خام
                                    $raw1 = $hompage_addresses_saved_data['phone1'] ?? '';
                                    $raw2 = $hompage_addresses_saved_data['phone2'] ?? '';

                                    // ۲. نگاشت اعداد فارسی/عربی به لاتین
                                    $fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                                    $ar = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                                    $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                                    $map_from = array_merge($fa, $ar);
                                    $map_to = array_merge($en, $en);

                                    $norm1 = str_replace($map_from, $map_to, $raw1);
                                    $norm2 = str_replace($map_from, $map_to, $raw2);

                                    // ۳. حذف همه‌ی فضاهای خالی (space, \t, NBSP و…)
                                    $norm1 = preg_replace('/\s+/u', '', $norm1);
                                    $norm2 = preg_replace('/\s+/u', '', $norm2);

                                    // ۴. حذف همه‌چیز به جز اعداد و + (اگر لازم دارید)
                                    $tel1 = preg_replace('/[^0-9\+]/', '', $norm1);
                                    $tel2 = preg_replace('/[^0-9\+]/', '', $norm2);
                                    ?>
                                    <div class="flex gap-x-2">
                                        <a href="<?php echo esc_url('tel:' . $tel1); ?>"
                                            style="direction: ltr; text-align: left;" class="font-sansRegular">
                                            <?php echo esc_html($raw1); ?>
                                        </a>
                                        <div class="w-1 h-5 bg-orange-500 rounded-md"></div>
                                        <a href="<?php echo esc_url('tel:' . $tel2); ?>"
                                            style="direction: ltr; text-align: left;" class="font-sansRegular">
                                            <?php echo esc_html($raw2); ?>
                                        </a>
                                    </div>

                                </div>
                            </div>


                            <div class="flex items-start gap-x-2 lg:gap-x-4 space-y-2">
                                <div>
                                    <svg class="w-9 h-9">
                                        <use href="#location"></use>
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <p>ساعت پاسخگویی تلفنی:</p>
                                    <div class="font-sansRegular text-mainBlue">
                                        <?php echo wpautop($hompage_addresses_saved_data['working_hours']); ?>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <?php
                        $homepage_addresses = get_option('homepage-addresses', array());
                        $latitude = !empty($homepage_addresses['latitude']) ? $homepage_addresses['latitude'] : '35.6892';
                        $longitude = !empty($homepage_addresses['longitude']) ? $homepage_addresses['longitude'] : '51.3890';
                        ?>

                        <div
                            class="w-full h-[224px] lg:h-[285px] lg:w-[578px] bg-sky-100 mt-3 lg:mt-7 rounded-lg overflow-hidden">
                            <iframe width="100%" height="100%" frameborder="0" style="border:0"
                                src="https://maps.google.com/maps?q=<?php echo urlencode($latitude . ',' . $longitude); ?>&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                allowfullscreen>
                            </iframe>
                        </div>


                    </div>
                    <style>
                        .toast {
                            position: fixed;
                            bottom: 20px;
                            right: -300px;
                            background: #4CAF50;
                            color: white;
                            padding: 16px;
                            border-radius: 8px;
                            z-index: 9999;
                            transition: all 0.5s ease-in-out;
                            opacity: 0;
                            max-width: 300px;
                        }

                        .toast.show {
                            right: 20px;
                            opacity: 1;
                        }

                        .toast.error {
                            background: #f44336;
                        }
                    </style>
                    <div class="col-span-2 bg-form-call px-4 lg:px-12 mr-4 w-full lg:mr-0 rounded-xl">
                        <div class="col-span-2 bg-form-call w-full  py-8 rounded-xl mx-auto">
                            <div class="space-y-2 lg:space-y-4 ">
                                <p class="text-xl">به مشاوره نیاز دارین؟</p>
                                <p class="font-sansRegular text-zinc-700">در سریع‌ترین زمان ممکن پاسخگوی شما هستیم...</p>
                            </div>

                            <form id="contact-form" class="flex flex-col gap-y-3 lg:gap-y-4 mt-[11px] lg:mt-[22px]">
                                <input name="fullname"
                                    class="w-full h-[58px] rounded-[14px] bg-white outline-0 font-sansRegular px-2" type="text"
                                    placeholder="نام و نام خانوادگی">
                                <input name="phone"
                                    class="w-full h-[58px] rounded-[14px] bg-white outline-0 font-sansRegular px-2" type="text"
                                    placeholder="شماره موبایل">
                                <textarea name="message"
                                    class="w-full h-[178px] rounded-[14px] bg-white outline-0 font-sansRegular p-2"
                                    placeholder="چه پیامی برای ما دارین؟"></textarea>

                                <button type="submit"
                                    class="bg-mainBlue text-white w-fit mx-auto py-3 px-5 rounded-xl mt-[22px]">ثبت
                                    درخواست</button>
                            </form>
                            <div id="toast" class="toast"></div>

                            <script>
                                function showToast(message, type = 'success') {
                                    const toast = document.getElementById('toast');
                                    toast.textContent = message;
                                    toast.className = 'toast'; // Reset classes
                                    toast.classList.add(type, 'show');

                                    // پس از 3 ثانیه Toast را مخفی کنید
                                    setTimeout(() => {
                                        toast.classList.remove('show');
                                    }, 3000);
                                }
                                document.querySelector('form#contact-form').addEventListener('submit', function (e) {
                                    e.preventDefault();

                                    const formData = new FormData(this);
                                    formData.append('action', 'submit_contact_form');
                                    formData.append('security', contactForm.ajax_nonce);

                                    fetch(contactForm.ajax_url, {
                                        method: 'POST',
                                        body: formData,
                                        credentials: 'same-origin'
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                showToast(data.data, 'success');
                                                this.reset();
                                            } else {
                                                showToast(data.data || 'خطای ناشناخته', 'error');
                                            }
                                        })
                                        .catch(error => {
                                            showToast('خطا در ارتباط با سرور', 'error');
                                        });
                                });
                            </script>
                        </div>
                    </div>


                </div>
            </div>
            <?php
            $logos = get_option('hompage-customers-logo', []);
            if (!empty($logos)):
                ?>
                <div class="w-[90%] 2xl:container  lg:mt-[55px] mt-9 mx-auto">


                    <div class="flex items-center justify-center font-sansBold text-black gap-x-2 text-base lg:text-[22px] ">
                        مشتریانی که به ما<p class="text-mainBlue">اعتماد</p>کرده اند</div>

                    <div
                        class=" bg-mainBlue px-3 lg:px-[70px] grid grid-cols-4 lg:grid-cols-6 py-4 lg:py-5 rounded-xl mt-5 lg:mt-8">
                        <?php foreach ($logos as $logo): ?>
                            <div>
                                <img src="<?php echo esc_url($logo); ?>">
                            </div>
                        <?php endforeach; ?>


                    </div>
                </div>
            <?php endif; ?>

            <?php
            $about_data = get_option('about-section', ['description' => '', 'cards' => []]);
            if (!empty($about_data)):
                ?>
                <div class="mt-9 lg:mt-12 bg-white flex flex-col items-center">

                    <div class="w-[90%] 2xl:container px-3 lg:px-[70px] mx-auto py-10 flex flex-col items-center">

                        <p class="lg:text-[28px] text-[20px] font-sansBold text-mainBlue text-center">چرا ایده‌آل برش؟!</p>
                        <p class="text-base text-zinc-700 font-sansRegular text-center lg:w-2/4 mt-2">
                            <?php echo $about_data['description'] ? esc_html($about_data['description']) : ''; ?>
                        </p>

                        <div class="grid grid-cols-2 lg:grid-cols-5">

                        </div>

                        <button></button>
                    </div>


                    <div class="w-[90%] 2xl:container mx-auto">

                        <div class="grid grid-cols-2 lg:grid-cols-5 gap-x-6 lg:gap-x-10 gap-y-6 px-3 lg:px-[70px]">
                            <?php
                            if (!empty($about_data['cards'])):
                                foreach ($about_data['cards'] as $index => $card):
                                    ?>
                                    <div class="p-3 lg:p-5 flex flex-col items-center justify-between border-2 rounded-xl border-nili-100">

                                        <img src="<?php echo esc_url($card['icon']); ?>">

                                        <p class="text-base font-sansFanumBold text-black mt-2 lg:mt-5">
                                            <?php echo esc_html($card['title']); ?>
                                        </p>

                                        <p class="font-sansRegular text-zinc-600 text-center mt-2">
                                            <?php echo esc_html($card['description']); ?>
                                        </p>
                                    </div>
                                    <?php
                                endforeach;
                            endif;
                            ?>

                        </div>

                    </div>


                    <a href="<?php echo get_home_url(); ?>/about"
                        class="bg-mainBlue font-sansRegular text-white rounded-xl py-3 px-5 mt-6 lg:mt-10 mx-auto mb-10">
                        درباره ما
                    </a>
                </div>
            <?php endif; ?>


            <div class="w-[90%] 2xl:container px-3 lg:px-[70px] mx-auto my-9 lg:mt-12">

                <div class="flex items-center justify-between">

                    <div class="flex items-center font-sansBold text-black gap-x-2 text-base lg:text-[22px] ">
                        <p class="text-mainBlue">مجله</p>ایده آل برش
                    </div>

                    <div class="flex items-center  lg:gap-x-2 p-3 bg-white rounded-xl border border-nili-100 w-fit">

                        <a href="<?php echo get_home_url(); ?>/blog" class="font-sansRegular text-mainBlue">بلاگ ایده آل برش</a>

                        <div class="mt-1">
                            <svg class="w-4 h-4">
                                <use href="#ArrowLeft2"></use>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mt-4 lg:mt-6">

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-5 lg:gap-x-12">

                        <?php
                        $args = array(
                            'post_type' => 'post', // نوع پست (نوشته‌ها)
                            'posts_per_page' => 4, // تعداد نوشته‌ها
                            'post_status' => 'publish',
                            'orderby' => 'date', // مرتب‌سازی بر اساس تاریخ
                            'order' => 'DESC' // جدیدترین‌ها اول
                        );

                        $query = new WP_Query($args);

                        if ($query->have_posts()): ?>
                            <?php while ($query->have_posts()):
                                $query->the_post(); ?>
                                <a href="<?php the_permalink(); ?>"
                                    class="px-2 pt-2 lg:px-3 lg:pt-3 pb-3 lg:pb-4 flex flex-col items-center justify-between gap-y-2 lg:gap-y-3 bg-white rounded-xl border border-zinc-200 shadow-sm">
                                    <div
                                        class="flex flex-col items-center justify-between gap-y-2 lg:gap-y-3 bg-white rounded-xl border border-zinc-200 shadow-sm">

                                        <!-- تصویر شاخص -->
                                        <?php if (has_post_thumbnail()): ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>"
                                                class="w-full h-auto">
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri() . '/assets/img/placholder.jpg'; ?>"
                                                alt="ایده آل برش" class="w-full h-auto">
                                        <?php endif; ?>

                                        <!-- عنوان مقاله -->
                                        <p class="font-sansFanumBold text-black lg:text-[18px]"><?php the_title(); ?></p>

                                        <!-- دکمه مشاهده مقاله -->
                                        <div class="flex items-center gap-x-1 lg:gap-x-2 font-sansRegular text-mainBlue">
                                            <div class="flex items-center gap-x-1 lg:gap-x-2">
                                                <p>مشاهده مقاله</p>
                                                <div>
                                                    <svg class="w-6 h-6">
                                                        <use href="#Sarrowleft"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php endif;
                        wp_reset_postdata(); ?>



                    </div>
                </div>

            </div>



            <div class="overlay_section transition-all duration-300"></div>



            <script src="<?php echo get_template_directory_uri() . '/assets/js/swiper-bundle.min.js'; ?>"></script>
            <script src="<?php echo get_template_directory_uri() . '/assets/js/main.js'; ?>"></script>

            <script>
                var swiper = new Swiper(".mySwiper", {
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                });

                var CategoryProducts = new Swiper(".CategoryProducts1", {
                    loop: true,
                    slidesPerView: 2,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: ".swiper-button-next-1",
                        prevEl: ".swiper-button-prev-1",
                    },

                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 40
                        },

                        768: {
                            slidesPerView: 3,
                            spaceBetween: 40
                        },

                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 40
                        },

                        1280: {
                            slidesPerView: 6,
                            spaceBetween: 40
                        }
                    }
                });

                var CategoryProducts = new Swiper(".CategoryProducts2", {
                    loop: true,
                    slidesPerView: 2,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: ".swiper-button-next-2",
                        prevEl: ".swiper-button-prev-2",
                    },

                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },

                        768: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },

                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 20
                        },

                        1280: {
                            slidesPerView: 5,
                            spaceBetween: 20
                        }
                    }
                });


                var CategoryProducts3 = new Swiper(".CategoryProducts3", {
                    loop: true,
                    slidesPerView: 2,
                    spaceBetween: 20,
                    // navigation: {
                    //     nextEl: ['.swiper-button-next-3','swiper-button-next-31'],
                    //     prevEl: [".swiper-button-prev-3",'swiper-button-prev-31']
                    // },

                    navigation: {
                        nextEl: '.swiper-button-next-3',
                        prevEl: ".swiper-button-prev-3"
                    },

                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 40
                        },

                        768: {
                            slidesPerView: 3,
                            spaceBetween: 40
                        },

                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 40
                        },
                        1280: {
                            slidesPerView: 4,
                            spaceBetween: 40
                        },


                    }
                });


                var CategoryProducts4 = new Swiper(".CategoryProducts4", {
                    loop: true,
                    slidesPerView: 2,
                    spaceBetween: 20,
                    // navigation: {
                    //     nextEl: ['.swiper-button-next-3','swiper-button-next-31'],
                    //     prevEl: [".swiper-button-prev-3",'swiper-button-prev-31']
                    // },

                    navigation: {
                        nextEl: '.swiper-button-next-4',
                        prevEl: ".swiper-button-prev-4"
                    },

                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },

                        768: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },

                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 40
                        },


                    }
                });




                var CategoryProducts5 = new Swiper(".CategoryProducts5", {
                    loop: true,
                    slidesPerView: 2,
                    spaceBetween: 20,
                    // navigation: {
                    //     nextEl: ['.swiper-button-next-3','swiper-button-next-31'],
                    //     prevEl: [".swiper-button-prev-3",'swiper-button-prev-31']
                    // },

                    navigation: {
                        nextEl: '.swiper-button-next-5',
                        prevEl: ".swiper-button-prev-5"
                    },

                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },

                        768: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },

                        1024: {
                            slidesPerView: 5,
                            spaceBetween: 40
                        },


                    }
                });



                document.querySelector('.swiper-button-next-31').addEventListener('click', function () {
                    CategoryProducts3.slideNext();
                });

                document.querySelector('.swiper-button-prev-31').addEventListener('click', function () {
                    CategoryProducts3.slidePrev();
                });


            </script>
            <?php
        endwhile;
    else:
        // پیام در صورت نبود محتوا
        echo '<p>' . esc_html__('محتوا موجود نیست.', 'idealboresh') . '</p>';
    endif;
    get_footer();