jQuery(document).ready(function($) {
    // Align recipes in a masonry grid
    $('.recipe-tiles').masonry({
        // options
        itemSelector: '.recipe-card-wrap',
    })

    var isMobile = window.matchMedia("(max-width: 767px)");

    // Prevent following recipe links on smartphones,
    // except when the button with the data-url attribute has been explicitely tapped on
    $('.recipe-card-wrap').on("click", function( event ) {
        if (isMobile.matches) {
            event.preventDefault();

            // Close all recipe details
            $(".recipe-card-wrap").removeClass("active");

            // Toggle current recipe details
            $(this).toggleClass("active");

            if (event.target.getAttribute("data-url")) {
                window.location.href = event.target.getAttribute("data-url");
            }

        }
    });
});
