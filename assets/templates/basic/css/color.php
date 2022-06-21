<?php
header("Content-Type:text/css");
$color1 = $_GET['color1']; // Change your Color Here

function checkhexcolor($color1){
    return preg_match('/^#[a-f0-9]{6}$/i', $color1);
}

if (isset($_GET['color1']) AND $_GET['color1'] != '') {
    $color1 = "#" . $_GET['color1'];
}

if (!$color1 OR !checkhexcolor($color1)) {
    $color1 = "#336699";
}

?>

.social-icons li a:hover, .social__icons li a i, .search-form .cmn--btn:hover, .search-form .cmn--btn:hover, .header-top-wrapper li a.header-btn, .sidebar__widget .title::after, .filter-category .sub-category li a::before, .filter-category .sub-category li a:hover::before, .nav--tabs .nav-item .nav-link.active, .dashboard-item .dashboard-icon, .dashboard-item:hover, .cmn--table thead tr th, .post__item .post__thumb .category, .post__share li a i, .widget.widget__tags ul li a:hover, .widget.widget__tags ul li a.active, .post__tag li a:hover, .post__tag li a.active, .post__share li a i, .scrollToTop, .video__button, .video__button::before, .video__button::after, .cmn--btn, .pagination .page-item a.active, .pagination .page-item span.active, .pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a, .dashboard-menu-open {
    background: <?= $color1 ?>;
}

.light-version .nav--tabs .nav-item .nav-link.active, .light-version .widget.widget__tags ul li a:hover, .light-version .widget.widget__tags ul li a.active, .light-version .post__tag li a:hover, .light-version .post__tag li a.active, .light-version .bg--body .widget.widget__tags ul li a:hover, .light-version .bg--body .widget.widget__tags ul li a.active, .light-version .bg--body .post__tag li a:hover, .light-version .bg--body .post__tag li a.active, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .custom--card button.form--control {
    background: <?= $color1 ?> !important;
}

*::selection, .form--check .form-check-input:checked {
    background-color: <?= $color1 ?>;
}

.btn--base, .badge--base, .bg--base, .btn--1, .badge--1, .bg--1 {
    background-color: <?= $color1 ?> !important;
}


.light-version .contact__item ul li a:hover, .header-links li a:hover, .header-links li a.active, .footer__widget .contact__info .icon, .footer__widget .footer__links li a:hover, .footer__widget .footer__links li a::before, .menu li a:hover, .menu li .submenu li a:hover, .filter-category li a:hover, .filter-category .sub-category li a:hover, .product__details .title-area .btn-side .add-wishlist i, .form--label i, .dashboard-item:hover .dashboard-icon, .contact__item ul li a:hover, .post__item .post__content .meta__date .meta__item i, .post__item .post__read, .widget__post .widget__post__content span, p a, p a:hover, 
.cmn--modal .modal-footer .btn-close,
  .cmn--modal .modal-header .btn-close {
    color: <?= $color1 ?>;
}

.text--base, .text--1 {
    color: <?= $color1 ?> !important;
}

.form--check .form-check-input:checked, .dashboard-menu ul li a:hover, .dashboard-menu ul li a.active {
    border-color: <?= $color1 ?>;
}

.post__item .post__content .meta__date {
    border-left: 5px solid <?= $color1 ?>;
}

.post__quote {
    border-left: 3px solid <?= $color1 ?>;
}

@media (max-width: 1199px) {
    .dashboard-menu {
        background: <?= $color1 ?>;
    }
}
