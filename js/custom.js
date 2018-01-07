$(window).load(function () {
    "use strict";
    $(function () {
            
        $(".preloader").fadeOut();
        $("#side-menu").metisMenu();
    });
    $(".open-close").click(function () {
        $("body").toggleClass("show-sidebar");
    });
    $(".right-side-toggle").click(function () {
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");
        $(".fxhdr").click(function () {
            $("body").toggleClass("fix-header");
        });
        $(".fxsdr").click(function () {
            $("body").toggleClass("fix-sidebar");
        });
        if ($("body").hasClass("fix-header")) {
            $(".fxhdr").attr("checked", true);
        } else {
            $(".fxhdr").attr("checked", false);
        }
    });
    $(function () {
        $(window).bind("load resize", function () {
            topOffset = 60;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $("div.navbar-collapse").addClass("collapse");
                topOffset = 100; // 2-row-menu
            } else {
                $("div.navbar-collapse").removeClass("collapse");
            }
            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) { height = 1; }
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            }
        });
        var url = window.location;
        var element = $("ul.nav a").filter(function () {
            return this.href === url || url.href.indexOf(this.href) === 0;
        }).addClass("active").parent().parent().addClass("in").parent();
        if (element.is("li")) {
            element.addClass("active");
        }
    });
    $(function () {
        $(window).bind("load resize", function () {
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 1170) {
                $('body').addClass('content-wrapper');
                $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                
            } else {
                $("body").removeClass("content-wrapper");
            }
        });
    });
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]';
        $(panelSelector).each(function () {
            var $this = $(this),
                parent = $this.closest(".panel"),
                wrapper = parent.find(".panel-wrapper"),
                collapseOpts = {
                    toggle: false
                };
            if (!wrapper.length) {
                wrapper = parent.children(".panel-heading").nextAll().wrapAll("<div/>").parent().addClass("panel-wrapper");
                collapseOpts = {};
            }
            wrapper.collapse(collapseOpts).on("hide.bs.collapse", function () {
                $this.children("i").removeClass("ti-minus").addClass("ti-plus");
            }).on("show.bs.collapse", function () {
                $this.children("i").removeClass("ti-plus").addClass("ti-minus");
            });
        });
        $(document).on("click", panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest(".panel");
            var wrapper = parent.find(".panel-wrapper");
            wrapper.collapse("toggle");
        });
    }(jQuery, window, document));
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-dismiss"]';
        $(document).on("click", panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest(".panel");
            function removeElement() {
                var col = parent.parent();
                parent.remove();
                col.filter(function () {
                    var el = $(this);
                    return (el.is('[class*="col-"]') && el.children("*").length === 0);
                }).remove();
            }
            removeElement();
        });
    }(jQuery, window, document));
    //tooltip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
    $(".list-task li label").click(function () {
        $(this).toggleClass("task-done");
    });
    $(".settings_box a").click(function () {
        $("ul.theme_color").toggleClass("theme_block");
    });
});
$(".collapseble").click(function () {
    "use strict";
    $(".collapseblebox").fadeToggle(350);
});
$(".slimscrollright").slimScroll({
    height: "100%",
    position: "right",
    size: "5px",
    color: "#dcdcdc",
    opacity: 0
}).mouseover(function () {
    "use strict";
    $(this).next(".slimScrollBar").css("opacity", 0.4);
});
$(".slimscrollsidebar").slimScroll({
    height: "100%",
    position: "left",
    size: "6px",
    color: "rgba(0,0,0,0.5)",
    opacity: 0
}).mouseover(function () {
    "use strict";
    $(this).next(".slimScrollBar").css("opacity", 0.4);
});
$("body").trigger("resize");
// visited ul li
$(".visited li a").click(function (e) {
    "use strict";
    $(".visited li").removeClass("active");
    var $parent = $(this).parent();
    if (!$parent.hasClass("active")) {
        $parent.addClass("active");
    }
    e.preventDefault();
});
$("#to-recover").click(function () {
    "use strict";
    $("#loginform").fadeOut("fast", function () {$("#recoverform").fadeIn(); });
});
$('#to-login').click(function () {
    "use strict";
    $("#recoverform").fadeOut("fast", function () {$("#loginform").fadeIn(); });
});
$(".navbar-toggle").click(function () {
    "use strict";
    $(".navbar-toggle i").toggleClass("ti-menu");
    $(".navbar-toggle i").addClass("ti-close");
});
