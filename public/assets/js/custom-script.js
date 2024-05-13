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

    let cssRuleForConsoleStop =
        "color: rgb(255, 0, 0);" +
        "font-size: 30px;" +
        "font-weight: bold;" +
        "text-shadow: 1px 1px 5px rgb(255, 77, 77);" +
        "filter: dropshadow(color=rgb(255, 77, 77), offx=1, offy=1);";
    setTimeout(console.log.bind(console, "%cStop!", cssRuleForConsoleStop), 0);
    setTimeout(console.log.bind(console, "%cDo not pest or write anything here. It can be risky. Be careful!", "font-size:16px;"), 100);

});

/*let data = `
         _     wWw  wWw  _   wW  Ww\\\\\\  ///   .-.          W  W   wW  Ww   _
    /)  /||_   (O)  (O) /||_ (O)(O)((O)(O)) c(O_O)c    /) (O)(O)  (O)(O) _||\\
  (o)(O) /\`_)  / )  ( \\  /\`_) (..)  | \\ || ,'.---.\`, (o)(O) ||     (..) (_'\\
   //\\\\ |  \`. / /    \\ \\|  \`.  ||   ||\\\\||/ /|_|_|\\ \\ //\\\\  | \\     ||  .'  |
  |(__)|| (_))| \\____/ || (_))_||_  || \\ || \\_____/ ||(__)| |  \`.  _||_((_) |
  /,-. |(.'-' '. \`--' .\`(.'-'(_/\\_) ||  ||'. \`---' .\`/,-. |(.-.__)(_/\\_)\`-\`.)
 -'   '' )      \`-..-'   )         (_/  \\_) \`-...-' -'   '' \`-'            (
`;
console.log('%c'+data, "color: #ff0000; font-size: 7px; font-family:monospace;");*/
