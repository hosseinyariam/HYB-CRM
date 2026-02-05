!(function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples
    (SweetAlert.prototype.init = function() {
        //Basic
        $("#sa-basic").click(function() {
            Swal.fire("در اینجا یک پیام وجود دارد!");
        });

        //A title with a text under
        $("#sa-title").click(function() {
            Swal.fire(
                "در اینجا یک پیام وجود دارد!",
                "Lorem بسیار هویج ، توسعه دهنده کارشناسی گوجه فرنگی.با این حال ، لورم از همیشه کسر می شد ، لوبورتیس چیلی اما."
            );
        });

        //Success Message
        $("#sa-success").click(function() {
            Swal.fire(
                "کار خوب!",
                "Lorem بسیار هویج ، توسعه دهنده کارشناسی گوجه فرنگی.با این حال ، لورم از همیشه کسر می شد ، لوبورتیس چیلی اما.",
                "موفقیت"
            );
        });

        //Warning Message
        $("#sa-warning").click(function() {
            Swal.fire({
                    title: "مطمئن هستید؟",
                    text: "شما قادر به بازیابی این پرونده خیالی نخواهید بود!",
                    type: "هشدار",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                },
                function() {
                    swal("حذف شده!", "پرونده خیالی شما حذف شده است.", "موفقیت");
                }
            );
        });

        //Custom Image
        $("#sa-image").click(function() {
            Swal.fire({
                title: "گوویندا!",
                text: "اخیراً به توییتر پیوست",
                imageUrl: "../assets/images/profile/user-2.jpg",
            });
        });

        //Auto Close Timer
        $("#sa-close").click(function() {
            Swal.fire({
                title: "هشدار نزدیک خودکار!",
                text: "من در 2 ثانیه بسته خواهم شد.",
                timer: 2000,
                showConfirmButton: false,
            });
        });

        $("#model-error-icon").click(function() {
            Swal.fire({
                type: "error",
                title: "اوه...",
                text: "مشکلی پیش آمد!",
                footer: "<a href>چرا من این مسئله را دارم؟</a>",
            });
        });

        $("#sa-html").click(function() {
            Swal.fire({
                title: "<strong>HTML <u>نمونه</u></strong>",
                type: "info",
                html: "You can use <b>bold text</b>, " +
                    '<a href="//github.com">links</a> ' +
                    "و سایر برچسب های HTML",
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="ti ti-thumb-up"></i> Great!',
                confirmButtonAriaLabel: "Thumbs up, great!",
                cancelButtonText: '<i class="ti ti-thumb-down"></i>',
                cancelButtonAriaLabel: "Thumbs down",
            });
        });

        $("#sa-position").click(function() {
            Swal.fire({
                position: "top-end",
                type: "success",
                title: "کار شما ذخیره شده است",
                showConfirmButton: false,
                timer: 1500,
            });
        });

        $("#sa-animation").click(function() {
            Swal.fire({
                title: "انیمیشن سفارشی با Animate.css",
                animation: false,
                customClass: {
                    popup: "animated tada",
                },
            });
        });

        $("#sa-confirm").click(function() {
            Swal.fire({
                title: "مطمئن هستید؟",
                text: "شما نمی توانید این را برگردانید!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    Swal.fire("حذف شده!", "پرونده شما حذف شده است.", "success");
                }
            });
        });

        $("#sa-passparameter").click(function() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "me-6 btn btn-danger",
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons
                .fire({
                    title: "مطمئن هستید?",
                    text: "شما نمی توانید این را برگردانید!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "بله ، آن را حذف کنید!",
                    cancelButtonText: "نه ، لغو!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.value) {
                        swalWithBootstrapButtons.fire(
                            "حذف شده!",
                            "پرونده شما حذف شده است.",
                            "success"
                        );
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "لغو شده",
                            "پرونده خیالی شما ایمن است :)",
                            "error"
                        );
                    }
                });
        });

        $("#sa-bg").click(function() {
            Swal.fire({
                title: "عرض سفارشی ، بالشتک ، پس زمینه.",
                width: 600,
                padding: "3em",
                background: "var(--bs-body-bg) url(../assets/images/backgrounds/active-bg.png)",
                backdrop: `
                          rgba(0,0,123,0.4)
                          url("../assets/images/backgrounds/nyan-cat.gif")
                          center left
                          no-repeat
                      `,
            });
        });

        $("#sa-autoclose").click(function() {
            let timerInterval;
            Swal.fire({
                title: "هشدار نزدیک خودکار!",
                html: "من بسته خواهم شد <strong></strong> ثانیه.",
                timer: 2000,
                onBeforeOpen: () => {
                    Swal.showLoading();
                    timerInterval = setInterval(() => {
                        Swal.getContent().querySelector("strong").textContent =
                            Swal.getTimerLeft();
                    }, 100);
                },
                onClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
                if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.timer
                ) {
                    console.log("I was closed by the timer");
                }
            });
        });

        $("#sa-rtl").click(function() {
            Swal.fire({
                title: "آیا می خواهید ادامه دهید؟",
                type: "question",
                customClass: {
                    icon: "swal2-arabic-question-mark",
                },
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
                showCancelButton: true,
                showCloseButton: true,
            });
        });

        $("#sa-ajax").click(function() {
            Swal.fire({
                title: "نام کاربری GitHub خود را ارسال کنید",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off",
                },
                showCancelButton: true,
                confirmButtonText: "Look up",
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return fetch(`//api.github.com/users/${login}`)
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            return response.json();
                        })
                        .catch((error) => {
                            Swal.showValidationMessage(`درخواست انجام نشد: ${error}`);
                        });
                },
                allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: `${result.value.login}'s avatar`,
                        imageUrl: result.value.avatar_url,
                    });
                }
            });
        });

        $("#sa-chain").click(function() {
            Swal.mixin({
                    input: "text",
                    confirmButtonText: "Next &rarr;",
                    showCancelButton: true,
                    progressSteps: ["1", "2", "3"],
                })
                .queue([{
                        title: "پرسش 1",
                        text: "زنجیر کردن مودال های SWAL2 آسان است",
                    },
                    "پرسش 2",
                    "پرسش 3",
                ])
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "تمام شده!",
                            html: "پاسخ های شما: <pre><code>" +
                                JSON.stringify(result.value) +
                                "</code></pre>",
                            confirmButtonText: "Lovely!",
                        });
                    }
                });
        });

        $("#sa-queue").click(function() {
            const ipAPI = "https://api.ipify.org?format=json";

            Swal.queue([{
                title: "IP عمومی شما",
                confirmButtonText: "Show my public IP",
                text: "IP عمومی شما دریافت می شود" + "via AJAX request",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(ipAPI)
                        .then((response) => response.json())
                        .then((data) => Swal.insertQueueStep(data.ip))
                        .catch(() => {
                            Swal.insertQueueStep({
                                type: "error",
                                title: "نمی توانید IP عمومی خود را دریافت کنید",
                            });
                        });
                },
            }, ]);
        });

        $("#sa-timerfun").click(function() {
            let timerInterval;
            Swal.fire({
                title: "هشدار نزدیک خودکار!",
                html: "من بسته خواهم شد<strong></strong> seconds.<br/><br/>" +
                    '<button id="increase" class="btn bg-warning-subtle text-warning px-4">' +
                    "من به 5 ثانیه دیگر نیاز دارم!" +
                    "</button><br/>" +
                    '<button id="stop" class="btn bg-danger-subtle text-danger px-4 mt-1">' +
                    "لطفا تایمر را متوقف کنید!!" +
                    "</button><br/>" +
                    '<button id="resume" class="btn bg-success-subtle text-success px-4 mt-1" disabled>' +
                    "پسر ... اکنون می توانید دوباره راه اندازی کنید!" +
                    "</button><br/>" +
                    '<button id="toggle" class="btn bg-primary-subtle text-primary px-4 mt-1">' +
                    "پیچیدن" +
                    "</button>",
                timer: 10000,
                onBeforeOpen: () => {
                    const content = Swal.getContent();
                    const $ = content.querySelector.bind(content);

                    const stop = $("#stop");
                    const resume = $("#resume");
                    const toggle = $("#toggle");
                    const increase = $("#increase");

                    Swal.showLoading();

                    function toggleButtons() {
                        stop.disabled = !Swal.isTimerRunning();
                        resume.disabled = Swal.isTimerRunning();
                    }

                    stop.addEventListener("click", () => {
                        Swal.stopTimer();
                        toggleButtons();
                    });

                    resume.addEventListener("click", () => {
                        Swal.resumeTimer();
                        toggleButtons();
                    });

                    toggle.addEventListener("click", () => {
                        Swal.toggleTimer();
                        toggleButtons();
                    });

                    increase.addEventListener("click", () => {
                        Swal.increaseTimer(5000);
                    });

                    timerInterval = setInterval(() => {
                        Swal.getContent().querySelector("strong").textContent = (
                            Swal.getTimerLeft() / 1000
                        ).toFixed(0);
                    }, 100);
                },
                onClose: () => {
                    clearInterval(timerInterval);
                },
            });
        });
    }),
    //init
    ($.SweetAlert = new SweetAlert()),
    ($.SweetAlert.Constructor = SweetAlert);
})(window.jQuery),
//initializing
(function($) {
    "use strict";
    $.SweetAlert.init();
})(window.jQuery);