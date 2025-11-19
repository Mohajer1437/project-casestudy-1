document.addEventListener("DOMContentLoaded", function () {
    const first__level = document.querySelector("#first__level");
    const humberger = document.querySelector("#humbergerr");
    const overlay_section = document.querySelector(".overlay_section");
    const mobile__menu__bar = document.querySelector("#mobile__menu__bar");
    const controler__icon__menu__bar = document.querySelector("#controler__icon__menu__bar");
    const second__level = document.querySelector("#second__level");
    const three__level = document.querySelector("#three__level");
    const placeHolder__two = second__level.querySelector("#placeHolder__two");
    const placeHolder__three = document.querySelector("#placeHolder__three");

    if (!humberger || !first__level || !overlay_section || !mobile__menu__bar || 
        !controler__icon__menu__bar || !second__level || !three__level || 
        !placeHolder__two || !placeHolder__three) {
        console.error("One or more elements are not found in the DOM.");
        return;
    }

    // همبرگر منو کلیک شد → منو باز شود و اوورلی فعال شود
    humberger.addEventListener("click", function () {
        openMenu("first", "open");
        showOverlay();
    });

    function openMenu(level, action) {
        const levels = { first: first__level, second: second__level, three: three__level };
        const targetLevel = levels[level];

        if (!targetLevel) return;

        if (action === "open") {
            targetLevel.classList.remove("-right-64", "md:-right-[384px]");
            targetLevel.classList.add("right-0");
        } else {
            targetLevel.classList.remove("right-0");
            targetLevel.classList.add("-right-64", "md:-right-[384px]");
        }
    }

    function showOverlay() {
        overlay_section.classList.add("overlay-section-true");
    }

    function hideOverlay() {
        overlay_section.classList.remove("overlay-section-true");
    }

    // کلیک روی اوورلی → همه منوها بسته شوند و اوورلی حذف شود
    overlay_section.addEventListener("click", function () {
        openMenu("first", "close");
        openMenu("second", "close");
        openMenu("three", "close");
        hideOverlay();
    });

    // جلوگیری از تأثیر کلیک روی اوورلی روی دیگر عناصر
    overlay_section.addEventListener("click", function (e) {
        e.stopPropagation();  // جلوگیری از انتشار رویداد به سایر عناصر
    });

    function handleMenuClick(event, level, placeHolder) {
        const menuItem = event.target.closest(".item__menu__mobile");
        if (!menuItem) return;

        // اگر روی SVG کلیک شد، زیرمنو نمایش داده شود
        const toggleIcon = event.target.closest("svg");
        if (toggleIcon && menuItem.classList.contains("has__subMenu")) {
            event.preventDefault();
            const submenu = menuItem.querySelector(".parent__item__menu");

            if (submenu) {
                const clonedMenu = submenu.cloneNode(true);
                clonedMenu.classList.remove("hidden", "px-4");
                openMenu(level, "open");
                placeHolder.innerHTML = "";
                placeHolder.appendChild(clonedMenu);
            }
        }
    }

    first__level.addEventListener("click", (e) => handleMenuClick(e, "second", placeHolder__two));
    second__level.addEventListener("click", (e) => handleMenuClick(e, "three", placeHolder__three));
});
