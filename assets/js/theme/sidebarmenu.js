var at = document.documentElement.getAttribute("data-layout");

/* -----------------------------
   Vertical Layout
------------------------------ */
if (at === "vertical") {

    document.addEventListener("DOMContentLoaded", function () {

        var isSidebar = document.getElementsByClassName("side-mini-panel");
        if (!isSidebar.length) return;

        /* -----------------------------
           پیدا کردن لینک فعال
        ------------------------------ */
        function findMatchingElement() {
            var currentUrl = window.location.href;
            var anchors = document.querySelectorAll("#sidebarnav a");
            for (var i = 0; i < anchors.length; i++) {
                if (anchors[i].href === currentUrl) return anchors[i];
            }
            return null;
        }

        var elements = findMatchingElement();
        if (elements) elements.classList.add("active");

        /* -----------------------------
           منوی چندسطحی
        ------------------------------ */
        document.querySelectorAll("#sidebarnav a").forEach(function (link) {
            link.addEventListener("click", function () {

                const parentUl = this.closest("ul");
                if (!parentUl) return;

                const isActive = this.classList.contains("active");

                if (!isActive) {
                    parentUl.querySelectorAll("ul").forEach(function (submenu) {
                        submenu.classList.remove("in");
                    });
                    parentUl.querySelectorAll("a").forEach(function (navLink) {
                        navLink.classList.remove("active");
                    });

                    const submenu = this.nextElementSibling;
                    if (submenu) submenu.classList.add("in");

                    this.classList.add("active");
                } else {
                    this.classList.remove("active");
                    const submenu = this.nextElementSibling;
                    if (submenu) submenu.classList.remove("in");
                }
            });
        });

        /* -----------------------------
           جلوگیری از باز شدن لینک‌های has-arrow
        ------------------------------ */
        document.querySelectorAll("#sidebarnav > li > a.has-arrow").forEach(function (link) {
            link.addEventListener("click", function (e) {
                e.preventDefault();
            });
        });

        /* -----------------------------
           نمایش منوی مرتبط
        ------------------------------ */
        if (elements) {
            var closestNav = elements.closest("nav[class^=sidebar-nav]");
            if (closestNav) {
                var menuid = closestNav.id;
                var menu = menuid[menuid.length - 1];

                var menuRight = document.getElementById("menu-right-mini-" + menu);
                var miniItem = document.getElementById("mini-" + menu);

                if (menuRight) menuRight.classList.add("d-block");
                if (miniItem) miniItem.classList.add("selected");
            }
        }

        /* -----------------------------
           فعال‌سازی mini sidebar
        ------------------------------ */
        document.querySelectorAll(".mini-nav .mini-nav-item").forEach(function (item) {
            item.addEventListener("click", function () {

                document.querySelectorAll(".mini-nav .mini-nav-item").forEach(function (navItem) {
                    navItem.classList.remove("selected");
                });

                this.classList.add("selected");

                document.querySelectorAll(".sidebarmenu nav").forEach(function (nav) {
                    nav.classList.remove("d-block");
                });

                var target = document.getElementById("menu-right-" + this.id);
                if (target) target.classList.add("d-block");

                document.body.setAttribute("data-sidebartype", "full");
            });
        });

    });
}

/* -----------------------------
   Horizontal Layout
------------------------------ */
if (at === "horizontal") {

    function findMatchingElement() {
        var currentUrl = window.location.href;
        var anchors = document.querySelectorAll("#sidebarnavh ul#sidebarnav a");
        for (var i = 0; i < anchors.length; i++) {
            if (anchors[i].href === currentUrl) return anchors[i];
        }
        return null;
    }

    var elements = findMatchingElement();
    if (elements) elements.classList.add("active");

    document.querySelectorAll("#sidebarnavh ul#sidebarnav a.active").forEach(function (link) {
        if (link.closest("a")) link.closest("a").parentElement.classList.add("selected");
        if (link.closest("ul")) link.closest("ul").parentElement.classList.add("selected");
    });
}

/* -----------------------------
   Active 2 file at same time
------------------------------ */
var currentURL = window.location != window.parent.location ? document.referrer : document.location.href;
var link = document.getElementById("get-url");

if (link) {
    if (currentURL.includes("/main/index.html")) {
        link.setAttribute("href", "../main/index.html");
    } else if (currentURL.includes("/index.html")) {
        link.setAttribute("href", "./index.html");
    } else {
        link.setAttribute("href", "./index.html");
    }
}