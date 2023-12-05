$(document).ready(function () {

    $(".select2-box").select2({
        closeOnSelect: true,
        containerCssClass: "select2-box-container",
        dropdownCssClass: "select2-box-dropdown",
        width: '100%'
    
    });
    
    $(".theme-change-btn").on('click', function () {
        let current_theme = $("html").attr("data-layout-mode");
        let next_theme = "light";

        // Check if the current theme is light, then switch to dark
        if (current_theme == "light") {
            next_theme = "dark";
        }

        // Update the HTML attributes for theme
        $("html").attr("data-layout-mode", next_theme);
        $("html").attr("data-topbar", next_theme);
        $("html").attr("data-sidebar", next_theme);

        // Save the theme preference in localStorage
        localStorage.setItem("theme", next_theme);
    });

    // Check if a theme preference is stored in localStorage
    let storedTheme = localStorage.getItem("theme");
    if (storedTheme) {
        // Apply the stored theme
        $("html").attr("data-layout-mode", storedTheme);
        $("html").attr("data-topbar", storedTheme);
        $("html").attr("data-sidebar", storedTheme);
    }

});
