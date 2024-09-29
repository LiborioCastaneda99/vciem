<script>
    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
    if (isFluid) {
        var container = document.querySelector('[data-layout]');
        container.classList.remove('container');
        container.classList.add('container-fluid');
    }
</script>

<nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
        </div>
        <a class="navbar-brand" href="index.php">
            <!-- <div class="d-flex align-items-center py-3"><img class="me-2" src="assets/img/icons/spot-illustrations/falcon.png" alt width="40"><span class="font-sans-serif text-primary">Visual -->
            <div class="d-flex align-items-center py-3"><span class="font-sans-serif text-primary">Visual Ciem</span></div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <!-- cargamos el menu automatico -->
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
            </ul>
            <!-- <div class="settings mb-3">
                <div class="card shadow-none">
                    <div class="card-body alert mb-0" role="alert">
                        <div class="btn-close-falcon-container"><button class="btn btn-link btn-close-falcon p-0" aria-label="Close" data-bs-dismiss="alert"></button></div>
                        <div class="text-center"><img src="assets/img/icons/spot-illustrations/navbar-vertical.png" alt width="80">
                            <p class="fs-11 mt-2">Loving what you see? <br>Get your copy of <a href="#!">Falcon</a></p>
                            <div class="d-grid"><a class="btn btn-sm btn-primary" href="https://themes.getbootstrap.com/product/falcon-admin-dashboard-webapp-template/" target="_blank">Purchase</a></div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</nav>
<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg" style="display: none;">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="index.html.htm">
        <div class="d-flex align-items-center"><img class="me-2" src="assets/img/icons/spot-illustrations/falcon.png" alt width="40"><span class="font-sans-serif text-primary">falcon</span></div>
    </a>
    <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
        <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dashboards">1393</a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="dashboards">
                    <div class="bg-white dark__bg-1000 rounded-3 py-2"><a class="dropdown-item link-600 fw-medium" href="index.html.htm">Default</a><a class="dropdown-item link-600 fw-medium" href="dashboard/analytics.html.htm">Analytics</a><a class="dropdown-item link-600 fw-medium" href="dashboard/crm.html.htm">CRM</a>
                        <a class="dropdown-item link-600 fw-medium" href="dashboard/e-commerce.html.htm">E commerce</a><a class="dropdown-item link-600 fw-medium" href="dashboard/lms.html.htm">LMS<span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a><a class="dropdown-item link-600 fw-medium" href="dashboard/project-management.html.htm">Management</a><a class="dropdown-item link-600 fw-medium" href="dashboard/saas.html.htm">SaaS</a>
                        <a class="dropdown-item link-600 fw-medium" href="dashboard/support-desk.html.htm">Support desk<span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="apps">App</a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="apps">
                    <div class="card navbar-card-app shadow-none dark__bg-1000">
                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown" src="assets/img/icons/spot-illustrations/authentication-corner.png" width="130" alt>
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium" href="app/calendar.html.htm">Calendar</a><a class="nav-link py-1 link-600 fw-medium" href="app/chat.html.htm">Chat</a><a class="nav-link py-1 link-600 fw-medium" href="app/kanban.html.htm">Kanban</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Social</p><a class="nav-link py-1 link-600 fw-medium" href="app/social/feed.html.htm">Feed</a><a class="nav-link py-1 link-600 fw-medium" href="app/social/activity-log.html.htm">Activity
                                            log</a><a class="nav-link py-1 link-600 fw-medium" href="app/social/notifications.html.htm">Notifications</a><a class="nav-link py-1 link-600 fw-medium" href="app/social/followers.html.htm">Followers</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Support Desk
                                        </p><a class="nav-link py-1 link-600 fw-medium" href="app/support-desk/table-view.html.htm">Table
                                            view</a><a class="nav-link py-1 link-600 fw-medium" href="app/support-desk/card-view.html.htm">Card
                                            view</a><a class="nav-link py-1 link-600 fw-medium" href="app/support-desk/contacts.html.htm">Contacts</a><a class="nav-link py-1 link-600 fw-medium" href="app/support-desk/contact-details.html.htm">Contact
                                            details</a><a class="nav-link py-1 link-600 fw-medium" href="app/support-desk/tickets-preview.html.htm">Tickets
                                            preview</a><a class="nav-link py-1 link-600 fw-medium" href="app/support-desk/quick-links.html.htm">Quick
                                            links</a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">E-Learning</p><a class="nav-link py-1 link-600 fw-medium" href="app/e-learning/course/course-list.html.htm">Course
                                            list</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-learning/course/course-grid.html.htm">Course
                                            grid</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-learning/course/course-details.html.htm">Course
                                            details</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-learning/course/create-a-course.html.htm">Create
                                            a course</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-learning/student-overview.html.htm">Student
                                            overview</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-learning/trainer-profile.html.htm">Trainer
                                            profile</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Events</p><a class="nav-link py-1 link-600 fw-medium" href="app/events/create-an-event.html.htm">Create
                                            an event</a><a class="nav-link py-1 link-600 fw-medium" href="app/events/event-detail.html.htm">Event
                                            detail</a><a class="nav-link py-1 link-600 fw-medium" href="app/events/event-list.html.htm">Event
                                            list</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Email</p><a class="nav-link py-1 link-600 fw-medium" href="app/email/inbox.html.htm">Inbox</a><a class="nav-link py-1 link-600 fw-medium" href="app/email/email-detail.html.htm">Email
                                            detail</a><a class="nav-link py-1 link-600 fw-medium" href="app/email/compose.html.htm">Compose</a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">E-Commerce</p><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/product/product-list.html.htm">Product
                                            list</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/product/product-grid.html.htm">Product
                                            grid</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/product/product-details.html.htm">Product
                                            details</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/product/add-product.html.htm">Add
                                            product</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/orders/order-list.html.htm">Order
                                            list</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/orders/order-details.html.htm">Order
                                            details</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/customers.html.htm">Customers</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/customer-details.html.htm">Customer
                                            details</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/shopping-cart.html.htm">Shopping
                                            cart</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/checkout.html.htm">Checkout</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/billing.html.htm">Billing</a><a class="nav-link py-1 link-600 fw-medium" href="app/e-commerce/invoice.html.htm">Invoice</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="pagess">Pages</a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="pagess">
                    <div class="card navbar-card-pages shadow-none dark__bg-1000">
                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown" src="assets/img/icons/spot-illustrations/authentication-corner.png" width="130" alt>
                            <div class="row">
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Simple Auth
                                        </p><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/simple/login.html.htm">Login</a><a class="nav-link py-1 link-600 fw-medium" href="ajax/logout.php">Logout</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/simple/register.html.htm">Register</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/simple/forgot-password.html.htm">Forgot
                                            password</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/simple/confirm-mail.html.htm">Confirm
                                            mail</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/simple/reset-password.html.htm">Reset
                                            password</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/simple/lock-screen.html.htm">Lock
                                            screen</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Card Auth
                                        </p><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/card/login.html.htm">Login</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/card/logout.html.htm">Logout</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/card/register.html.htm">Register</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/card/forgot-password.html.htm">Forgot
                                            password</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/card/confirm-mail.html.htm">Confirm
                                            mail</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/card/reset-password.html.htm">Reset
                                            password</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/card/lock-screen.html.htm">Lock
                                            screen</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Split Auth
                                        </p><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/split/login.html.htm">Login</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/split/logout.html.htm">Logout</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/split/register.html.htm">Register</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/split/forgot-password.html.htm">Forgot
                                            password</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/split/confirm-mail.html.htm">Confirm
                                            mail</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/split/reset-password.html.htm">Reset
                                            password</a><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/split/lock-screen.html.htm">Lock
                                            screen</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Layouts</p><a class="nav-link py-1 link-600 fw-medium" href="demo/navbar-vertical.html.htm">Navbar
                                            vertical</a><a class="nav-link py-1 link-600 fw-medium" href="demo/navbar-top.html.htm">Top
                                            nav</a><a class="nav-link py-1 link-600 fw-medium" href="demo/navbar-double-top.html.htm">Double
                                            top<span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a><a class="nav-link py-1 link-600 fw-medium" href="demo/combo-nav.html.htm">Combo
                                            nav</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Others</p><a class="nav-link py-1 link-600 fw-medium" href="pages/starter.html.htm">Starter</a><a class="nav-link py-1 link-600 fw-medium" href="pages/landing.html.htm">Landing</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">User</p><a class="nav-link py-1 link-600 fw-medium" href="pages/user/profile.html.htm">Profile</a><a class="nav-link py-1 link-600 fw-medium" href="pages/user/settings.html.htm">Settings</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Pricing</p><a class="nav-link py-1 link-600 fw-medium" href="pages/pricing/pricing-default.html.htm">Pricing
                                            default</a><a class="nav-link py-1 link-600 fw-medium" href="pages/pricing/pricing-alt.html.htm">Pricing
                                            alt</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Errors</p><a class="nav-link py-1 link-600 fw-medium" href="pages/errors/404.html.htm">404</a><a class="nav-link py-1 link-600 fw-medium" href="pages/errors/500.html.htm">500</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Miscellaneous</p><a class="nav-link py-1 link-600 fw-medium" href="pages/miscellaneous/associations.html.htm">Associations</a><a class="nav-link py-1 link-600 fw-medium" href="pages/miscellaneous/invite-people.html.htm">Invite
                                            people</a><a class="nav-link py-1 link-600 fw-medium" href="pages/miscellaneous/privacy-policy.html.htm">Privacy
                                            policy</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">FAQ</p><a class="nav-link py-1 link-600 fw-medium" href="pages/faq/faq-basic.html.htm">Faq
                                            basic</a><a class="nav-link py-1 link-600 fw-medium" href="pages/faq/faq-alt.html.htm">Faq
                                            alt</a><a class="nav-link py-1 link-600 fw-medium" href="pages/faq/faq-accordion.html.htm">Faq
                                            accordion</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Other Auth
                                        </p><a class="nav-link py-1 link-600 fw-medium" href="pages/authentication/wizard.html.htm">Wizard</a><a class="nav-link py-1 link-600 fw-medium" href="#authentication-modal" data-bs-toggle="modal">Modal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="moduless">Modules</a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="moduless">
                    <div class="card navbar-card-components shadow-none dark__bg-1000">
                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown" src="assets/img/icons/spot-illustrations/authentication-corner.png" width="130" alt>
                            <div class="row">
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Components</p><a class="nav-link py-1 link-600 fw-medium" href="modules/components/accordion.html.htm">Accordion</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/alerts.html.htm">Alerts</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/anchor.html.htm">Anchor</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/animated-icons.html.htm">Animated
                                            icons</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/background.html.htm">Background</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/badges.html.htm">Badges</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/bottom-bar.html.htm">Bottom bar
                                            <span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/breadcrumbs.html.htm">Breadcrumbs</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/buttons.html.htm">Buttons</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/calendar.html.htm">Calendar</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/cards.html.htm">Cards</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/carousel/bootstrap.html.htm">Bootstrap carousel
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column mt-md-4 pt-md-1"><a class="nav-link py-1 link-600 fw-medium" href="modules/components/carousel/swiper.html.htm">Swiper</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/collapse.html.htm">Collapse</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/cookie-notice.html.htm">Cookie
                                            notice</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/countup.html.htm">Countup</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/draggable.html.htm">Draggable</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/dropdowns.html.htm">Dropdowns</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/jquery-components.html.htm">Jquery<span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/list-group.html.htm">List
                                            group</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/modals.html.htm">Modals</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/navs-and-tabs/navs.html.htm">Navs</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/navs-and-tabs/navbar.html.htm">Navbar</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/navs-and-tabs/vertical-navbar.html.htm">Navbar
                                            vertical</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column mt-xxl-4 pt-xxl-1"><a class="nav-link py-1 link-600 fw-medium" href="modules/components/navs-and-tabs/top-navbar.html.htm">Top
                                            nav</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/navs-and-tabs/double-top-navbar.html.htm">Double
                                            top<span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/navs-and-tabs/combo-navbar.html.htm">Combo
                                            nav</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/navs-and-tabs/tabs.html.htm">Tabs</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/offcanvas.html.htm">Offcanvas</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/pictures/avatar.html.htm">Avatar</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/pictures/images.html.htm">Images</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/pictures/figures.html.htm">Figures</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/pictures/hoverbox.html.htm">Hoverbox</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/pictures/lightbox.html.htm">Lightbox</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/progress-bar.html.htm">Progress bar
                                        </a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/placeholder.html.htm">Placeholder</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column mt-xxl-4 pt-xxl-1"><a class="nav-link py-1 link-600 fw-medium" href="modules/components/pagination.html.htm">Pagination</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/popovers.html.htm">Popovers</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/scrollspy.html.htm">Scrollspy</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/search.html.htm">Search</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/spinners.html.htm">Spinners</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/timeline.html.htm">Timeline</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/toasts.html.htm">Toasts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/tooltips.html.htm">Tooltips</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/components/treeview.html.htm">Treeview</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/typed-text.html.htm">Typed
                                            text</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/videos/embed.html.htm">Embed</a><a class="nav-link py-1 link-600 fw-medium" href="modules/components/videos/plyr.html.htm">Plyr</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Utilities</p><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/background.html.htm">Background</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/borders.html.htm">Borders</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/clearfix.html.htm">Clearfix</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/colors.html.htm">Colors</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/colored-links.html.htm">Colored
                                            links</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/display.html.htm">Display</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/flex.html.htm">Flex</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/float.html.htm">Float</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/focus-ring.html.htm">Focus
                                            ring</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/grid.html.htm">Grid</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/icon-link.html.htm">Icon
                                            link</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/overlayscrollbar.html.htm">Overlay
                                            scrollbar</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/position.html.htm">Position</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/ratio.html.htm">Ratio</a>
                                        <a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/spacing.html.htm">Spacing</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/sizing.html.htm">Sizing</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/stretched-link.html.htm">Stretched
                                            link</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/text-truncation.html.htm">Text
                                            truncation</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/typography.html.htm">Typography</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/vertical-align.html.htm">Vertical
                                            align</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/vertical-rule.html.htm">Vertical
                                            rule</a><a class="nav-link py-1 link-600 fw-medium" href="modules/utilities/visibility.html.htm">Visibility</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Tables</p><a class="nav-link py-1 link-600 fw-medium" href="modules/tables/basic-tables.html.htm">Basic
                                            tables</a><a class="nav-link py-1 link-600 fw-medium" href="modules/tables/advance-tables.html.htm">Advance
                                            tables</a><a class="nav-link py-1 link-600 fw-medium" href="modules/tables/bulk-select.html.htm">Bulk
                                            select</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Charts</p><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/chartjs.html.htm">Chartjs</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/d3js.html.htm">D3js<span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a>
                                        <p class="nav-link text-700 mb-0 fw-bold">ECharts</p><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/line-charts.html.htm">Line
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/bar-charts.html.htm">Bar
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/candlestick-charts.html.htm">Candlestick
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/geo-map.html.htm">Geo
                                            map</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/scatter-charts.html.htm">Scatter
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/pie-charts.html.htm">Pie
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/gauge-charts.html.htm">Gauge
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/radar-charts.html.htm">Radar
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/heatmap-charts.html.htm">Heatmap
                                            charts</a><a class="nav-link py-1 link-600 fw-medium" href="modules/charts/echarts/how-to-use.html.htm">How
                                            to use</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">Forms</p><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/basic/form-control.html.htm">Form
                                            control</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/basic/input-group.html.htm">Input
                                            group</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/basic/select.html.htm">Select</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/basic/checks.html.htm">Checks</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/basic/range.html.htm">Range</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/basic/layout.html.htm">Layout</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/advance-select.html.htm">Advance
                                            select</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/date-picker.html.htm">Date
                                            picker</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/editor.html.htm">Editor</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/emoji-button.html.htm">Emoji
                                            button</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/file-uploader.html.htm">File
                                            uploader</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/input-mask.html.htm">Input
                                            mask</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/range-slider.html.htm">Range
                                            slider</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/advance/rating.html.htm">Rating</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/floating-labels.html.htm">Floating
                                            labels</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/wizard.html.htm">Wizard</a><a class="nav-link py-1 link-600 fw-medium" href="modules/forms/validation.html.htm">Validation</a>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-3">
                                    <div class="nav flex-column pt-xxl-1">
                                        <p class="nav-link text-700 mb-0 fw-bold">Icons</p><a class="nav-link py-1 link-600 fw-medium" href="modules/icons/font-awesome.html.htm">Font
                                            awesome</a><a class="nav-link py-1 link-600 fw-medium" href="modules/icons/bootstrap-icons.html.htm">Bootstrap
                                            icons</a><a class="nav-link py-1 link-600 fw-medium" href="modules/icons/feather.html.htm">Feather</a><a class="nav-link py-1 link-600 fw-medium" href="modules/icons/material-icons.html.htm">Material
                                            icons</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Maps</p><a class="nav-link py-1 link-600 fw-medium" href="modules/maps/google-map.html.htm">Google
                                            map</a><a class="nav-link py-1 link-600 fw-medium" href="modules/maps/leaflet-map.html.htm">Leaflet
                                            map</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="documentations">Documentation</a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="documentations">
                    <div class="bg-white dark__bg-1000 rounded-3 py-2"><a class="dropdown-item link-600 fw-medium" href="documentation/getting-started.html.htm">Getting
                            started</a><a class="dropdown-item link-600 fw-medium" href="documentation/customization/configuration.html.htm">Configuration</a><a class="dropdown-item link-600 fw-medium" href="documentation/customization/styling.html.htm">Styling<span class="badge rounded-pill ms-2 badge-subtle-success">Updated</span></a><a class="dropdown-item link-600 fw-medium" href="documentation/customization/dark-mode.html.htm">Dark
                            mode</a><a class="dropdown-item link-600 fw-medium" href="documentation/customization/plugin.html.htm">Plugin</a><a class="dropdown-item link-600 fw-medium" href="documentation/faq.html.htm">Faq</a><a class="dropdown-item link-600 fw-medium" href="documentation/gulp.html.htm">Gulp</a><a class="dropdown-item link-600 fw-medium" href="documentation/design-file.html.htm">Design
                            file</a><a class="dropdown-item link-600 fw-medium" href="changelog.html.htm">Changelog</a></div>
                </div>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
        <li class="nav-item ps-2 pe-0">
            <div class="dropdown theme-control-dropdown"><a class="nav-link d-flex align-items-center dropdown-toggle fa-icon-wait fs-9 pe-1 py-0" href="#" role="button" id="themeSwitchDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-sun fs-7" data-fa-transform="shrink-2" data-theme-dropdown-toggle-icon="light"></span><span class="fas fa-moon fs-7" data-fa-transform="shrink-3" data-theme-dropdown-toggle-icon="dark"></span><span class="fas fa-adjust fs-7" data-fa-transform="shrink-2" data-theme-dropdown-toggle-icon="auto"></span></a>
                <div class="dropdown-menu dropdown-menu-end dropdown-caret border py-0 mt-3" aria-labelledby="themeSwitchDropdown">
                    <div class="bg-white dark__bg-1000 rounded-2 py-2"><button class="dropdown-item d-flex align-items-center gap-2" type="button" value="light" data-theme-control="theme"><span class="fas fa-sun"></span>Light<span class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button><button class="dropdown-item d-flex align-items-center gap-2" type="button" value="dark" data-theme-control="theme"><span class="fas fa-moon" data-fa-transform></span>Dark<span class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button><button class="dropdown-item d-flex align-items-center gap-2" type="button" value="auto" data-theme-control="theme"><span class="fas fa-adjust" data-fa-transform></span>Auto<span class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button></div>
                </div>
            </div>
        </li>
        <li class="nav-item d-none d-sm-block">
            <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait" href="app/e-commerce/shopping-cart.html.htm"><span class="fas fa-shopping-cart" data-fa-transform="shrink-7" style="font-size: 33px;"></span><span class="notification-indicator-number">1</span></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait" id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg" aria-labelledby="navbarDropdownNotification">
                <div class="card card-notification shadow-none">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h6 class="card-header-title mb-0">Notifications</h6>
                            </div>
                            <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark
                                    all as read</a></div>
                        </div>
                    </div>
                    <div class="scrollbar-overlay" style="max-height:19rem">
                        <div class="list-group list-group-flush fw-normal fs-10">
                            <div class="list-group-title border-bottom">NEW</div>
                            <div class="list-group-item">
                                <a class="notification notification-flush notification-unread" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                            <img class="rounded-circle" src="assets/img/team/1-thumb.png" alt>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>Emma Watson</strong> replied to your comment : "Hello world 😍"</p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">💬</span>Just now
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item">
                                <a class="notification notification-flush notification-unread" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                            <div class="avatar-name rounded-circle"><span>AB</span></div>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>Albert Brooks</strong> reacted to <strong>Mia Khalifa's</strong> status
                                        </p>
                                        <span class="notification-time"><span class="me-2 fab fa-gratipay text-danger"></span>9hr</span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-title border-bottom">EARLIER</div>
                            <div class="list-group-item">
                                <a class="notification notification-flush" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                            <img class="rounded-circle" src="assets/img/icons/weather-sm.jpg" alt>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1">The forecast today shows a low of 20&#8451; in California. See today's weather.</p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">🌤️</span>1d</span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item">
                                <a class="border-bottom-0 notification-unread  notification notification-flush" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-xl me-3">
                                            <img class="rounded-circle" src="assets/img/logos/oxford.png" alt>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>University of
                                                Oxford</strong> created an event : "Causal Inference Hilary 2019"</p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">✌️</span>1w</span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item">
                                <a class="border-bottom-0 notification notification-flush" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-xl me-3">
                                            <img class="rounded-circle" src="assets/img/team/10.jpg" alt>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>James Cameron</strong> invited to join the group: United Nations International Children's Fund
                                        </p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">🙋‍</span>2d</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center border-top"><a class="card-link d-block" href="app/social/notifications.html.htm">View all</a></div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown px-1">
            <a class="nav-link fa-icon-wait nine-dots p-1" id="navbarDropdownMenu" role="button" data-hide-on-body-scroll="data-hide-on-body-scroll" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="43" viewbox="0 0 16 16" fill="none">
                    <circle cx="2" cy="2" r="2" fill="#6C6E71"></circle>
                    <circle cx="2" cy="8" r="2" fill="#6C6E71"></circle>
                    <circle cx="2" cy="14" r="2" fill="#6C6E71"></circle>
                    <circle cx="8" cy="8" r="2" fill="#6C6E71"></circle>
                    <circle cx="8" cy="14" r="2" fill="#6C6E71"></circle>
                    <circle cx="14" cy="8" r="2" fill="#6C6E71"></circle>
                    <circle cx="14" cy="14" r="2" fill="#6C6E71"></circle>
                    <circle cx="8" cy="2" r="2" fill="#6C6E71"></circle>
                    <circle cx="14" cy="2" r="2" fill="#6C6E71"></circle>
                </svg></a>
            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-caret-bg" aria-labelledby="navbarDropdownMenu">
                <div class="card shadow-none">
                    <div class="scrollbar-overlay nine-dots-dropdown">
                        <div class="card-body px-3">
                            <div class="row text-center gx-0 gy-0">
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="pages/user/profile.html.htm" target="_blank">
                                        <div class="avatar avatar-2xl"> <img class="rounded-circle" src="assets/img/team/3.jpg" alt></div>
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11">Account</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="https://themewagon.com/" target="_blank"><img class="rounded" src="assets/img/nav-icons/themewagon.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Themewagon</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="https://mailbluster.com/" target="_blank"><img class="rounded" src="assets/img/nav-icons/mailbluster.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Mailbluster</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/google.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Google</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/spotify.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Spotify</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/steam.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Steam</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/github-light.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Github</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/discord.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Discord</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/xbox.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">xbox</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/trello.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Kanban</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/hp.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Hp</p>
                                    </a>
                                </div>
                                <div class="col-12">
                                    <hr class="my-3 mx-n3 bg-200">
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/linkedin.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Linkedin</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/twitter.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Twitter</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/facebook.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Facebook</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/instagram.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Instagram</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/pinterest.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Pinterest</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/slack.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Slack</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/deviantart.png" alt width="40" height="40">
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Deviantart</p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="app/events/event-detail.html.htm" target="_blank">
                                        <div class="avatar avatar-2xl">
                                            <div class="avatar-name rounded-circle bg-primary-subtle text-primary"><span class="fs-7">E</span></div>
                                        </div>
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11">Events</p>
                                    </a>
                                </div>
                                <div class="col-12"><a class="btn btn-outline-primary btn-sm mt-4" href="#!">Show more</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="assets/img/team/3-thumb.png" alt>
                </div>
            </a>
            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <a class="dropdown-item fw-bold text-warning" href="#!"><span class="fas fa-crown me-1"></span><span><?=
                                                                                                                            $_SESSION["user_nombres"] ?></span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#!">Set status</a>
                    <a class="dropdown-item" href="pages/user/profile.html.htm">Profile
                        &amp; account</a>
                    <a class="dropdown-item" href="#!">Feedback</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="pages/user/settings.html.htm">Settings</a>
                    <a class="dropdown-item" href="pages/authentication/card/logout.html.htm">Logout</a>
                </div>
            </div>
        </li>
    </ul>
</nav>