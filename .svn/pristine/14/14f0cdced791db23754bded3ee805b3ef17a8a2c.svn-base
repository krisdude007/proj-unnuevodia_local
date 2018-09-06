$(document).ready(function() {

    // FAKE REMOVE THIS
    // Toggle the visibility of login and logout buttons based on which is clicked
    $('#snap-drawer-login-btn, #snap-drawer-logout-btn').click(function() {
        $('#snap-drawer-login-btn, #snap-drawer-logout-btn').toggleClass('hidden');
    });


    // Initialize Fastclick.js
    // If you are emulating a device in a browser, ie chrome browser emulation,
    //  you must disable this for mouse events to register
    $(function() {
        FastClick.attach(document.body);
    });

    // Initialize Snap.js
    var snapper = new Snap({
        element: document.getElementById('content-container'),
        disable: 'right',
        touchToDrag: false,
        grayedOut: true
    });

    // when the user clicks the hamburger icon, open or close the menu accordingly
    $('#open-left').click(function(e) {
        e.preventDefault();
        if (snapper.state().state == "left") {
            snapper.close();
        } else {
            snapper.open('left');
        }
    });

    // when the user clicks the login/logout button or a nav item, close the drawer
    $('#snap-drawer-login-btn, #nav, #snap-drawer-logout-btn').click(function(e) {
        if (snapper.state().state == "left") {
            snapper.close();
        }
        ;
    });

    /* Prevent Safari opening links when viewing as a Mobile App */
    (function(a, b, c) {
        if (c in b && b[c]) {
            var d, e = a.location,
                    f = /^(a|html)$/i;
            a.addEventListener("click", function(a) {
                d = a.target;
                while (!f.test(d.nodeName))
                    d = d.parentNode;
                "href" in d && (d.href.indexOf("http") || ~d.href.indexOf(e.host)) && (a.preventDefault(), e.href = d.href)
            }, !1)
        }
    })(document, window.navigator, "standalone");
});
