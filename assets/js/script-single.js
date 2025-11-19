const PrevButton = document.querySelector('.prev');
if (PrevButton) {
    const Parent__PrevButton = PrevButton.parentElement;
    Parent__PrevButton.classList.add('orjanceHidden');
}
let message__status__comment = document.querySelector('.message__status__comment');
if (message__status__comment) {
    message__status__comment.scrollIntoView({
        behavior: "smooth",  // اسکرول نرم و انیمیشنی
        block: "start",     // قرار گرفتن در وسط صفحه
    });
    console.log('message__status__comment');
}





document.addEventListener('DOMContentLoaded', () => {
    // والد تب‌ها
    const tabList = document.querySelector('.tabs.wc-tabs');
    if (tabList) {
        // همه‌ی تب‌ها (لی‌های داخل role="tablist")

        const tabs = Array.from(tabList.querySelectorAll('li[role="tab"]'));

        // وقتی روی هر چیزی داخل ul کلیک شد
        tabList.addEventListener('click', e => {

            const clickedLi = e.target.closest('li[role="tab"]');
            if (!clickedLi) return;

            // ۱) از برداشتن رفتار لینک جلوگیری کن (دلخواه)
            e.preventDefault();

            // ۲) مخفی کردن همه ایندیکیتورها و غیرفعال کردن همه تب‌ها
            tabs.forEach(li => {
                li.classList.remove('active');
                const a = li.querySelector('a');
                if (a) a.setAttribute('aria-selected', 'false');

                const indicator = li.querySelector('.is__active__tab');
                if (indicator) indicator.classList.add('hidden');
            });

            // ۳) فعال‌سازی تب کلیک‌شده
            clickedLi.classList.add('active');
            const a = clickedLi.querySelector('a');
            if (a) a.setAttribute('aria-selected', 'true');

            // ۴) نمایش ایندیکیتورش
            const activeIndicator = clickedLi.querySelector('.is__active__tab');
            if (activeIndicator) activeIndicator.classList.remove('hidden');
        });

        // اختیاری: باز کردن تب اول به صورت پیش‌فرض
        if (tabs.length) tabs[0].click();
    }


});



document.addEventListener('DOMContentLoaded', function () {
    // همه‌ی دکمه‌های show-more
    var buttons = document.querySelectorAll('.show-more');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            // کلیک روی تب Specifications
            var specsTabLink = document.querySelector('#tab-title-specs > a');
            if (specsTabLink) {
                specsTabLink.click();
            }

            // بعد از 100ms اسکرول نرم با offset 200px
            setTimeout(function () {
                var specsContent = document.querySelector('#tab-specs');
                if (specsContent) {
                    // اگر لازم باشه نمایشش بده
                    specsContent.style.display = 'block';

                    // محاسبه موقعیت Y المان نسبت به کل صفحه
                    var elementTop = specsContent.getBoundingClientRect().top + window.pageYOffset;
                    // کم کردن 200px
                    var scrollToY = elementTop - 200;

                    window.scrollTo({
                        top: scrollToY,
                        behavior: 'smooth'
                    });
                }
            }, 100);
        });
    });
});





// Reply comment functionality

const Reply_comment = document.querySelectorAll('.Reply_comment');
const comment_parent = document.querySelector('#comment_parent');
const Reply__alert = document.querySelector('#Reply__alert');
const Reply__alert__message = document.querySelector('#Reply__alert__message');

Reply_comment.forEach(function (element) {
    element.addEventListener('click', function () {
        const parent = element.closest('.comment_item');
        if (parent) {
            comment_parent.value = parent.getAttribute('id');
            const comment__content = parent.querySelector('.comment__content');
            Reply__alert.classList.remove('hidden');
            Reply__alert__message.innerText = comment__content.textContent;
            Reply__alert.scrollIntoView({
                behavior: "smooth",  // اسکرول نرم و انیمیشنی
                block: "start",     // قرار گرفتن در وسط صفحه
            });
        }
    });
});