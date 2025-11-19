<?php wp_footer(); ?>
<?php
$footer_context = get_query_var('idealboresh_footer_context', []);
$footer_logo = $footer_context['logo'] ?? [];
$footer_site_name = $footer_context['site_name'] ?? get_bloginfo('name');
$footer_addresses = $footer_context['addresses'] ?? ['text' => '', 'email' => '', 'phone' => ''];
$footer_social_icons = $footer_context['social_icons'] ?? [];
$footer_enamad = $footer_context['enamad'] ?? '';
$floating_contact = $footer_context['floating_contact'] ?? [];
$footer_home_url = $footer_context['home_url'] ?? home_url('/');
$floating_whatsapp = $floating_contact['whatsapp'] ?? [];
$floating_phone = $floating_contact['phone'] ?? [];
$floating_url = $floating_contact['url'] ?? [];
?>
<footer class="bg-foot-100 py-4 lg:py-8 overflow-x-hidden border-b-[18px] border-b-foot-200">

  <div class="grid grid-cols-1 lg:grid-cols-5 gap-x-2 container px-8">

    <div class="lg:col-span-2">
      <div class="font-sansFanumRegular text-[#CBCBCB] space-y-2 lg:space-y-5">
        <a href="<?php echo esc_url($footer_home_url); ?>">
          <?php if (!empty($footer_logo['url'])): ?>
            <img src="<?php echo esc_url($footer_logo['url']); ?>" alt="<?php echo esc_attr($footer_logo['alt'] ?? $footer_site_name); ?>" />
          <?php else: ?>
            <h1 class="site-title"><?php echo esc_html($footer_site_name); ?></h1>
          <?php endif; ?>
        </a>
        <div>
          <?php if (!empty($footer_addresses['text'])): ?>
            <p><?php echo esc_html($footer_addresses['text']); ?></p>
          <?php endif; ?>
        </div>
        <div class="space-y-1">
          <div class="flex items-center gap-x-2">

            <div>
              <svg class="w-6 h-6">
                <use href="#emailfoot"></use>
              </svg>
            </div>
            <?php if (!empty($footer_addresses['email'])): ?>
              <p><?php echo esc_html($footer_addresses['email']); ?></p>
            <?php endif; ?>
          </div>


          <div class="flex items-center gap-x-2">

            <div>
              <svg class="w-6 h-6">
                <use href="#phonefoot"></use>
              </svg>
            </div>
            <?php if (!empty($footer_addresses['phone'])): ?>
              <p><?php echo esc_html($footer_addresses['phone']); ?></p>
            <?php endif; ?>
          </div>
        </div>
        <div>
          <?php if (!empty($footer_social_icons)): ?>
            <div class="flex items-center gap-x-1">
              <?php foreach ($footer_social_icons as $icon): ?>
                <a href="<?php echo esc_url($icon['link']); ?>" class="p-2 bg-foot-200 w-fit rounded-xl">
                  <img class="w-6 h-6" src="<?php echo esc_url($icon['image']); ?>" alt="">
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>


        </div>
      </div>
    </div>

    <div class="lg:col-span-2 text-[#CBD8FF] font-sansFanumBold mt-5 lg:mt-6">

      <div class="grid grid-cols-3">

        <div class="space-y-2 lg:space-y-4">

          <div class="space-y-1 lg:space-y-2 text-xs lg:text-base">
            <p>لینک های کوتاه</p>

            <div class="flex items-center gap-x-1">
              <div class="w-10 h-1 rounded-xl bg-mainBlue"></div>
              <div class="w-5 h-1 rounded-xl bg-secondery"></div>
            </div>
          </div>


          <?php if (has_nav_menu('footer-menu-right')): ?>
            <?php
            wp_nav_menu([
              'theme_location' => 'footer-menu-right',
              'container' => false,
              'items_wrap' => '<div class="text-[#CBCBCB] text-[11px] lg:text-[14px] font-sansFanumRegular flex flex-col gap-y-2">%3$s</div>',
              'walker' => new \IdealBoresh\Presentation\Menu\FooterUsefulLinksWalker(),
            ]);
            ?>
          <?php endif; ?>


        </div>

        <div class="space-y-2 lg:space-y-4">

          <div class="space-y-1 lg:space-y-2 text-xs lg:text-base">
            <p>لینک های کوتاه</p>

            <div class="flex items-center gap-x-1">
              <div class="w-10 h-1 rounded-xl bg-mainBlue"></div>
              <div class="w-5 h-1 rounded-xl bg-secondery"></div>
            </div>
          </div>


          <?php if (has_nav_menu('footer-menu-middle')): ?>
            <?php
            wp_nav_menu([
              'theme_location' => 'footer-menu-middle',
              'container' => false,
              'items_wrap' => '<div class="text-[#CBCBCB] text-[11px] lg:text-[14px] font-sansFanumRegular flex flex-col gap-y-2">%3$s</div>',
              'walker' => new \IdealBoresh\Presentation\Menu\FooterUsefulLinksWalker(),
            ]);
            ?>
          <?php endif; ?>

        </div>

        <div class="space-y-2 lg:space-y-4">

          <div class="space-y-1 lg:space-y-2 text-xs lg:text-base">
            <p>لینک های کوتاه</p>

            <div class="flex items-center gap-x-1">
              <div class="w-10 h-1 rounded-xl bg-mainBlue"></div>
              <div class="w-5 h-1 rounded-xl bg-secondery"></div>
            </div>
          </div>


          <?php if (has_nav_menu('footer-menu-left')): ?>
            <?php
            wp_nav_menu([
              'theme_location' => 'footer-menu-left',
              'container' => false,
              'items_wrap' => '<div class="text-[#CBCBCB] text-[11px] lg:text-[14px] font-sansFanumRegular flex flex-col gap-y-2">%3$s</div>',
              'walker' => new \IdealBoresh\Presentation\Menu\FooterUsefulLinksWalker(),
            ]);
            ?>
          <?php endif; ?>

        </div>

      </div>

    </div>

    <div class="mt-5  text-[#CBD8FF] font-sansFanumBold">
      <p>مجوز و نماد اعتماد الکترونیک</p>
      <?php if (!empty($footer_enamad)) { echo $footer_enamad; } ?>

    </div>

  </div>

  <?php if (!empty($floating_whatsapp['link']) && !empty($floating_whatsapp['icon'])): ?>
    <a class="z-[150] left-[30px] bg-[#3c4f87] fixed bottom-[70px] flex items-center justify-center rounded-full p-4"
      href="<?php echo esc_url('https://wa.me/+98' . $whatsapp_number); ?>">
      <img class="w-8" src="<?php echo esc_url($options['whatsapp_icon'] ?? ''); ?>" alt="Support">
    </a>
  <?php endif; ?>
  <?php if (!empty($floating_phone['number']) && !empty($floating_phone['icon'])): ?>
    <a href="tel:<?php echo esc_attr($floating_phone['number']); ?>"
      class="right-[30px] lg:hidden w-[60px] h-[60px] z-[150] bg-[#3c4f87] fixed bottom-[70px] flex items-center justify-center rounded-full p-4">
      <img class="w-8 w-[25px]" src="<?php echo esc_url($options['contact_icon'] ?? ''); ?>" alt="call">
    </a>
  <?php endif; ?>
  <?php if ($options['contact_url'] && $options['contact_icon']): ?>
    <a href="<?php echo esc_url($options['contact_url'] ?? ''); ?>"
      class="right-[30px] hidden lg:flex w-[60px] h-[60px] z-[150] bg-[#3c4f87] fixed bottom-[70px] flex items-center justify-center rounded-full p-4">
      <img class="w-8 w-[25px]" src="<?php echo esc_url($options['contact_icon'] ?? ''); ?>" alt="call">
    </a>
  <?php endif; ?>

</footer>

<style>
  /* لینک default ووکامرس را مخفی کن */
  a.added_to_cart.wc-forward {
    display: none !important;
  }

  /* استایل Toast */
  .ideal-toast {
    position: fixed;
    top: 60px;
    right: 30px;
    background: red;
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    z-index: 9999;
  }

  .ideal-toast.show {
    opacity: 1;
    visibility: visible;
  }
</style>

<script>

  // تابع نمایش Toast
  function showIdealToast(text) {
    var t = document.createElement('div');
    t.className = 'ideal-toast';
    t.textContent = text;
    document.body.appendChild(t);
    // انیمیشن ورود
    setTimeout(function () {
      t.classList.add('show');
    }, 10);
    // خروج پس از ۲ ثانیه
    setTimeout(function () {
      t.classList.remove('show');
      setTimeout(function () {
        document.body.removeChild(t);
      }, 300);
    }, 2000);
  }
  document.addEventListener('DOMContentLoaded', function () {


    // هندل کلیک روی دکمه اضافه به سبد
    document.body.addEventListener('click', function (e) {
      var btn = e.target.closest('.idealboresh-add-to-cart');
      if (!btn) return;
      e.preventDefault();

      var ajaxObject = window.ideal_ajax_object || {};
      if (!ajaxObject.ajaxurl || !ajaxObject.nonce) {
        showIdealToast('⚠ خطا در افزودن به سبد خرید.');
        return;
      }

      var pid = btn.getAttribute('data-product_id'),
        qty = btn.getAttribute('data-quantity') || 1,
        data = new FormData();

      data.append('action', 'ideal_add_to_cart');
      data.append('nonce', ajaxObject.nonce);
      data.append('product_id', pid);
      data.append('quantity', qty);

      fetch(ajaxObject.ajaxurl, {
        method: 'POST',
        credentials: 'same-origin',
        body: data
      })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (!json.success) {
            showIdealToast('⚠ خطا در افزودن به سبد خرید.');
          } else {
            showIdealToast('✔ محصول به سبد خرید اضافه شد.');
          }
        })
        .catch(function () {
          showIdealToast('⚠ خطا در افزودن به سبد خرید.');
        });
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    // در لود صفحه، اگر کوکی ست شده بود، پیام بده و پاکش کن
    if (document.cookie.split('; ').some(c => c.startsWith('added_to_cart='))) {
      showIdealToast('✔ محصول به سبد خرید اضافه شد.');
      document.cookie = 'added_to_cart=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
    }
  });

  document.body.addEventListener('click', function (e) {
    // سلکتور دکمه‌های Add to Cart (بسته به مارکاپ شما)
    var btn = e.target.closest('.add_to_cart_button, .single_add_to_cart_button, .idealboresh-add-to-cart');
    if (!btn) return;

    // کوکی را ست می‌کند (بعد از آن فرم استاندارد ارسال و صفحه رفرش می‌شود)
    document.cookie = 'added_to_cart=1; path=/';
  });

</script>
<script>
  const first__level = document.querySelector('#first__level');
  const humberger = document.querySelector('#humbergerr');
  const overlay_section = document.querySelector('.overlay_section');
  const controler__icon__menu__bar = document.querySelector('#controler__icon__menu__bar');
  const second__level = document.querySelector('#second__level');
  const three__level = document.querySelector('#three__level');
  const placeHolder__two = second__level.querySelector('#placeHolder__two');
  const placeHolder__three = document.querySelector('#placeHolder__three');
  const back__state = document.querySelector('.back__state');
  humberger.addEventListener('click', function () {
    openMenu__firstlevel('first', 'open');
    overlay_section.classList.remove('hidden');
    overlay_section.classList.add('block');

  });
  const openMenu__firstlevel = function (level, action) {

    if (level === 'first' && action === 'open') {
      first__level.classList.remove('-right-64');
      first__level.classList.remove('md:-right-[384px]');
      first__level.classList.add('right-0');

    } else if (level === 'first' && action === 'close') {
      first__level.classList.remove('right-0');
      first__level.classList.add('-right-64');
      first__level.classList.add('md:-right-[384px]');
    } else if (level === 'second' && action === 'open') {
      second__level.classList.remove('-right-64');
      second__level.classList.remove('md:-right-[384px]');
      second__level.classList.add('right-0');
    } else if (level === 'second' && action === 'close') {
      second__level.classList.remove('right-0');
      second__level.classList.add('-right-64');
      second__level.classList.add('md:-right-[384px]');
    } else if (level === 'three' && action === 'open') {
      three__level.classList.remove('-right-64');
      three__level.classList.remove('md:-right-[384px]');
      three__level.classList.add('right-0');
    } else if (level === 'three' && action === 'close') {
      three__level.classList.remove('right-0');
      three__level.classList.add('-right-64');
      three__level.classList.add('md:-right-[384px]');
    }

  }
  let counter = 0;
  let item__menu__mobile = document.querySelectorAll('.item__menu__mobile');
  back__state.addEventListener('click', function () {
    if (counter == 0) {
      second__level.classList.remove('right-0');
      second__level.classList.add('-right-64');
      second__level.classList.add('md:-right-[384px]');
      resetstatus();
    }
  });
  overlay_section.addEventListener('click', function () {
    openMenu__firstlevel('first', 'close');
    openMenu__firstlevel('second', 'close');
    openMenu__firstlevel('three', 'close');
    overlay_section.classList.remove('block');
    overlay_section.classList.add('hidden');
    resetstatus();
  });
  const resetstatus = function () {
    counter = 0;
    placeHolder__two.innerHTML = '';
    placeHolder__three.innerHTML = '';
  }
  first__level.addEventListener('click', function (e) {

    if (e.target.closest('.item__menu__mobile')) {

      const item__menu__mobile = e.target.closest('.item__menu__mobile');
      if (e.target.closest('.has__subMenu')) {
        e.preventDefault();
        console.log("slan");
        const parent__item__menu = item__menu__mobile.querySelector('.parent__item__menu');
        const ClonnodeSubMenu = parent__item__menu.cloneNode(true);
        ClonnodeSubMenu.classList.remove('hidden');
        ClonnodeSubMenu.classList.remove('px-4');
        openMenu__firstlevel('second', 'open');
        placeHolder__two.appendChild(ClonnodeSubMenu);

      }

    }

  });

  second__level.addEventListener('click', function (e) {

    if (e.target.closest('.item__menu__mobile')) {

      const item__menu__mobile = e.target.closest('.item__menu__mobile');
      if (e.target.closest('.has__subMenu')) {
        e.preventDefault();
        const parent__item__menu = item__menu__mobile.querySelector('.parent__item__menu');
        const ClonnodeSubMenue = parent__item__menu.cloneNode(true);
        ClonnodeSubMenue.classList.remove('hidden');
        ClonnodeSubMenue.classList.remove('px-4');
        openMenu__firstlevel('three', 'open');
        placeHolder__three.appendChild(ClonnodeSubMenue);
        counter = 1;
      }


    }
  })

  three__level.addEventListener('click', function (e) {
    if (e.target.closest('.back__state')) {

      three__level.classList.remove('right-0');
      three__level.classList.add('-right-64');
      three__level.classList.add('md:-right-[384px]');
      placeHolder__three.innerHTML = '';
      counter = 0;

    } else if (e.target.classList.contains('.back__state')) {
      three__level.classList.remove('right-0');
      three__level.classList.add('-right-64');
      three__level.classList.add('md:-right-[384px]');
      placeHolder__three.innerHTML = '';
      counter = 0;
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    let lastScrollTop = 0;
    let searchElement = document.getElementById("mobile-serach");

    window.addEventListener("scroll", function () {
      let currentScroll = window.scrollY;

      if (currentScroll > lastScrollTop) {
        // اسکرول به پایین -> مخفی کردن المان
        searchElement.classList.add("hidden");
        searchElement.classList.remove("block");
      } else {
        // اسکرول به بالا -> نمایش المان
        searchElement.classList.add("block");
        searchElement.classList.remove("hidden");
      }

      lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // مقدار اسکرول را ذخیره می‌کنیم
    });

    // تنظیمات جستجو برای دسکتاپ و موبایل
    const searchConfigs = [{
      container: document.querySelector('.search-result-container'),
      input: document.querySelector('.header-search-input')
    },
    {
      container: document.querySelector('.mobile-search-result-container'),
      input: document.querySelector('.mobile-header-search-input')
    }
    ].filter(config => config.input && config.container); // حذف موارد نامعتبر

    const settings = {
      minChars: 2,
      delay: 1000,
      ajaxurl: '<?php echo admin_url('admin-ajax.php'); ?>',
      nonce: '<?php echo wp_create_nonce('search_nonce'); ?>'
    };

    let searchTimers = {};
    let lastSearchTerms = {};

    searchConfigs.forEach(({
      input,
      container
    }) => {
      const inputId = input.className;

      input.addEventListener('input', function (e) {
        clearTimeout(searchTimers[inputId]);
        const searchTerm = e.target.value.trim();

        if (searchTerm.length >= settings.minChars) {
          searchTimers[inputId] = setTimeout(() => {
            if (searchTerm !== lastSearchTerms[inputId]) {
              performSearch(searchTerm, container);
              lastSearchTerms[inputId] = searchTerm;
            }
          }, settings.delay);
        } else {
          clearResults(container);
        }
      });
    });

    document.addEventListener('click', function (e) {
      searchConfigs.forEach(({
        input,
        container
      }) => {
        if (!container.contains(e.target) && !input.contains(e.target)) {
          clearResults(container);
        }
      });
    });

    function performSearch(searchTerm, container) {
      showLoading(container);

      const formData = new FormData();
      formData.append('action', 'header_product_search');
      formData.append('search', searchTerm);
      formData.append('nonce', settings.nonce);

      fetch(settings.ajaxurl, {
        method: 'POST',
        body: formData
      })
        .then(response => response.ok ? response.text() : Promise.reject('Network error'))
        .then(html => container.innerHTML = html)
        .catch(error => {
          console.error('Error:', error);
          showError(container);
        });
    }

    function showLoading(container) {
      container.innerHTML = '<div class="search-loading">در حال جستجو...</div>';
    }

    function showError(container) {
      container.innerHTML = '<div class="search-error">خطا در دریافت نتایج</div>';
    }

    function clearResults(container) {
      container.innerHTML = '';
    }

  });

</script>

<script>
  const menuItems = document.querySelectorAll("[data-megamenu]");
  const megaMenuContent = document.getElementById("MegamenuContent");
  let hideTimer;

  menuItems.forEach(item => {
    const targetMenuId = item.getAttribute("data-megamenu");
    const targetMenu = targetMenuId ? document.getElementById(targetMenuId) : null;

    // وقتی موس وارد آیتم منو میشه، همه زیرمنوها رو مخفی و فقط مربوطه رو نشون بده
    item.addEventListener("mouseenter", () => {
      clearTimeout(hideTimer);
      document.querySelectorAll(".a_mega__menu__part").forEach(menu => {
        menu.classList.add("hidden");
      });
      if (targetMenu) {
        targetMenu.classList.remove("hidden");
        megaMenuContent.classList.remove("hidden");
      }
    });

    // وقتی موس از آیتم منو خارج میشه، بعد از 200ms مگامنو رو مخفی کن مگر اینکه موس رفت تو محتوا
    item.addEventListener("mouseleave", (event) => {
      hideTimer = setTimeout(() => {
        if (!megaMenuContent.contains(document.activeElement) && !megaMenuContent.matches(":hover")) {
          megaMenuContent.classList.add("hidden");
        }
      }, 200);
    });
  });

  // وقتی موس وارد مگامنو میشه، از مخفی شدن جلوگیری کن
  megaMenuContent.addEventListener("mouseenter", () => {
    clearTimeout(hideTimer);
  });

  // وقتی موس از مگامنو رفت، بلافاصله مخفی کن
  megaMenuContent.addEventListener("mouseleave", () => {
    megaMenuContent.classList.add("hidden");
  });
</script>


</body>

</html>