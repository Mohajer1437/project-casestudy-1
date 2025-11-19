const Filters_options_Mobile = document.querySelectorAll('.Filter_by_attribute');
let lastValues = new Map();
const data_mobile_taxonomy = document.querySelector('[data-mobile_taxonomy]').getAttribute('data-mobile_taxonomy');
const data_mobile_termid = document.querySelector('[data-mobile_termid]').getAttribute('data-mobile_termid');
const Page_att = [{data_mobile_taxonomy : data_mobile_taxonomy , data_mobile_termid : data_mobile_termid}];
let attributes = [];
let filter_values_yet = '';
let page_att_ajax_yet = '';
let offsett = 0;
let posts_per_page = 0;
let counterr = 0;
const init_render_posts = document.querySelector('.init_render_posts');
const page_numbers = document.querySelector('.page-numbers');
const see_load_more = document.querySelector('#see_load_more');
const checkboxes = document.querySelectorAll('.filter_by_attribute_desk[type="checkbox"]');

Filters_options_Mobile.forEach(function (item){
    lastValues.set(item.id, item.value);
    item.addEventListener('change',function(){
        offsett = 0;
        posts_per_page = 0;
        counterr = 0;
        if(page_numbers){
            page_numbers.classList.add('orjanceHidden');
        }
        let previousValue = lastValues.get(this.id);
        const value_option = item.value;
        let data_product_attribute = item.getAttribute('data-product_attribute')
        if (this.value !== previousValue){
            addProduct({ value_option: value_option, data_product_attribute: data_product_attribute});
            // console.log(attributes);
            let filter_values = JSON.stringify(attributes);
            let page_att_ajax = JSON.stringify(Page_att);
            filter_values_yet = filter_values;
            page_att_ajax_yet = page_att_ajax;

            Load_products(filter_values,page_att_ajax,0);





            // console.log(data_product_attribute);
            // console.log(data_mobile_taxonomy);
            // console.log(data_mobile_termid);
            // console.log(value_option);

            // console.log(data_product_attribute); pa_part_number
            // console.log(data_mobile_taxonomy); product_cat
            // console.log(data_mobile_termid); 34 موبایل
            // console.log(value_option); 18
            // let param = "filter";
            // let value = "example";
            // let url = new URL(window.location.href);
            // url.searchParams.set(param, value); // افزودن مقدار
            // history.pushState(null, '', url.toString()); // تغییر URL بدون رفرش

        }
    });
});

function Load_products(filter_att,page_att,offset){


    let xhr = new XMLHttpRequest();
    let formData = new FormData();

    formData.append("action", "ideal_Lode_more_products");
    formData.append("nonce", ideal_ajax_object.nonce);

    formData.append("filter_att", filter_att);
    formData.append("page_att", page_att);
    formData.append("offset", offset);


    xhr.open("POST", ideal_ajax_object.ajaxurl, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    if( counterr == 0){
                        init_render_posts.replaceChildren();
                    }
                    init_render_posts.insertAdjacentHTML("beforeend", response.contetnt);
                    counterr++;
                    offsett = counterr * posts_per_page;
                    if(response.founded > offsett){
                        see_load_more.classList.remove('orjanceHidden');
                    }else{
                        see_load_more.classList.add('orjanceHidden');
                    }
                }
            } else {
                let response = JSON.parse(xhr.responseText);
                init_render_posts.replaceChildren();
                init_render_posts.insertAdjacentHTML("beforeend", response.contetnt);
            }
        }
    };

    // قبل از ارسال درخواست
    xhr.onloadstart = function () {
        // عملیات مورد نظر
       document.getElementById('global-loader').style.display = 'block';  
    };

    // بعد از تکمیل درخواست
    xhr.onloadend = function () {
        // عملیات مورد نظر
        document.getElementById('global-loader').style.display = 'none';
        // console.log(offset);
    };
    xhr.send(formData);

}

checkboxes.forEach(function(checkbox){

    checkbox.addEventListener("change", function () {

        offsett = 0;
        posts_per_page = 0;
        counterr = 0;
        if(page_numbers){
            page_numbers.classList.add('orjanceHidden');
        }
        const value_option = checkbox.value;
        const data_product_attribute = checkbox.closest('.Accordion__parent__filter').getAttribute('data-product_attribute');

        handleAttribute_filter_desktop({value_option : value_option , data_product_attribute : data_product_attribute});
        let page_att_ajax = JSON.stringify(Page_att);
        let filter_values = JSON.stringify(attributes);
        filter_values_yet = filter_values;
        page_att_ajax_yet = page_att_ajax;
        if(!attributes.length == 0){
            Load_products(filter_values,page_att_ajax,0);
        }else{
            location.reload();
        }
    });


});
// helpper methods

function addProduct(newProduct) {
    let index = attributes.findIndex(product => product.data_product_attribute === newProduct.data_product_attribute);

    if (index !== -1) {
        // اگر محصول پیدا شد، جایگزین کن
        attributes[index] = newProduct;
    } else {
        // اگر محصول وجود نداشت، اضافه کن
        attributes.push(newProduct);
    }
}

function handleAttribute_filter_desktop(newObj){

    // const existingIndex = attributes.findIndex(item => item.data_product_attribute === newObj.data_product_attribute);

    // if (existingIndex !== -1) {
    //     // اگر وجود داشت، مقادیر number را در یک آرایه قرار می‌دهیم
    //     attributes[existingIndex].value_option = [
    //         attributes[existingIndex].value_option,
    //         newObj.value_option
    //     ];
    // } else {
    //     // اگر وجود نداشت، آبجکت جدید را اضافه می‌کنیم
    //     attributes.push(newObj);
    // }

    const existingIndex = attributes.findIndex(item => item.data_product_attribute === newObj.data_product_attribute);

    if (existingIndex !== -1) {
        // اگر آبجکت با id مشابه وجود داشت
        let value_option = attributes[existingIndex].value_option;

        if (!Array.isArray(value_option)) {
            value_option = [value_option]; // تبدیل به آرایه در صورت نیاز
        }

        if (value_option.includes(newObj.value_option)) {
            // اگر مقدار number داخل آرایه بود، حذفش کن
            value_option = value_option.filter(num => num !== newObj.value_option);

            // اگر بعد از حذف، آرایه خالی شد، کل آبجکت رو حذف کن
            if (value_option.length === 0) {
                attributes.splice(existingIndex, 1);
            } else {
                attributes[existingIndex].value_option = value_option;
            }
        } else {
            // اگر مقدار number نبود، اضافه کن
            value_option.push(newObj.value_option);
            attributes[existingIndex].value_option = value_option;
        }
    } else {
        // اگر آبجکت با id مشابه نبود، اضافه کن
        attributes.push({value_option: [newObj.value_option] , data_product_attribute: newObj.data_product_attribute });
    }
    // console.log(attributes);

}

//ajax_add_to_cart

let add_to_cart = document.body.querySelectorAll('.add-to-cart');

document.addEventListener("click", function(event) {
    if (event.target.matches(".add-to-cart") || event.target.matches(".add-to-cart-svg")) {
        let product_id = event.target.closest('.product__content').id;
        add__to__cart(product_id);
    }
});

function add__to__cart(product_id){


    let xhr = new XMLHttpRequest();
    let formData = new FormData();


    formData.append("action", "ideal_add_to_cart");
    formData.append("product_id", product_id);
    if (typeof ideal_ajax_object !== 'undefined' && ideal_ajax_object.nonce) {
        formData.append("nonce", ideal_ajax_object.nonce);
    }

    xhr.open("POST", ajax.ajaxurl, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // موفقیت
                }
            } else {
                // خطا
            }
        }
    };

    // قبل از ارسال درخواست
    xhr.onloadstart = function () {
        // عملیات مورد نظر
    };

    // بعد از تکمیل درخواست
    xhr.onloadend = function () {
        // عملیات مورد نظر
    };
    xhr.send(formData);

}