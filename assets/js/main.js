

// change menu active
let current_url = window.location.href;

let my_menu_link = $(".my-header-menu").find("a[href='"+current_url+"']");
my_menu_link.addClass('active');
my_menu_link.parents('.nav-item').addClass('active');
my_menu_link.parents('.collapse').addClass('show');