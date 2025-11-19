



// Accordion


const Accordion__parent = document.querySelectorAll('.Accordion__parent');
const Accordion__content = document.querySelectorAll('.Accordion__content');
if (Accordion__parent && Accordion__content) {

    Accordion__parent.forEach(function (item) {
        item.addEventListener('click', function () {
            const Accordion__content = item.querySelector('.Accordion__content')
            slideToggle(Accordion__content);
        });
    });

}



function slideToggle(element) {
    // const element = document.getElementById('myElement');
    if (element.style.height === "0px" || element.style.height === "") {
        element.style.height = element.scrollHeight + "px";
    } else {
        element.style.height = "0px";
    }
}


const Accordion__parent__title = document.querySelectorAll('.Accordion__parent__title');
Accordion__parent__title.forEach(function (item) {
    item.addEventListener('click', function () {

        const Accordion__parent__filter = item.parentElement;
        const Accordion__content = Accordion__parent__filter.querySelector('.Accordion__content');
        const chevron_down = item.querySelector('svg');
        chevron_down.classList.toggle("rotate-180");
        slideToggle(Accordion__content);
    });

});
