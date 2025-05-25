jQuery(function($){

    /* Get data input by the user into the form fields */
    async function getRecipesFilterInputData() {
        let options = [];

        // Get all checked checkboxes.
        var recipeCategories = $(".recipe-filter input[type='checkbox'][name='recipe-categories[]']:checked");

        // Initialize arrays for holding checkbox values.
        var recipeArray = [];

        // Fill arrays with checked data.
        recipeCategories.each(function() {
            recipeArray.push($(this).val());
        });

        // Combine arrays into strings for REST request.
        options.recipeCategories = recipeArray.join(",");

        return options;
    }

    /* Submit user input data to REST API and assemble the response */
    async function postRecipesFilterForm(pageNumber = 1) {
        // Get filter options from user.
        const options = await getRecipesFilterInputData();

        // Array with all of our cards as HTML strings.
        let cards = [];

        $.ajax({
            url: window.location.origin + '/wp-json/recipes/v1/filter-recipes/',
            method: 'GET',
            data: {
                recipeCategories: options.recipeCategories,
            },
            success: function(response, status, xhr) {
                const totalPages = xhr.getResponseHeader('X-WP-TotalPages');
                const currentPage = xhr.getResponseHeader('X-WP-CurrentPage');
                let items = response.data;

                // Clear results.
                $('#response').empty();

                // Debug SQL
                // $('#response').append('<pre>' + response.query + '</pre>');

                if(items.length !== 0) {
                    // Loop through results and build HTML.
                    $.each(items, function(index, item) {
                        // Fill the cards array with this data.
                        cards[index] = `
                        <div>
                            ${item.title}
                        </div>
                        `;
                    });

                    // Use intervals and animate() to slowly fade in each card
                    function fadeInCardsStaggered() {
                        let index = 0;

                        const interval = setInterval(function() {
                            const newCard = $(cards[index]);

                            $('#response').append(newCard);

                            newCard.animate({ opacity: 1 }, 800);

                            index++

                            // Check if all elements have been created
                            if (index === cards.length) {
                                clearInterval(interval);
                            }
                        }, 50);
                    }

                    fadeInCardsStaggered();
                } else {
                    // data is empty, no results.
                    $('#response').append('Keine Ergebnisse gefunden. Bitte ändere deine Filteroptionen.');
                }
            },
            error: function(error) {
                var formattedJSON = JSON.stringify(error, null, 2);
                $('#response').append('Bei deiner Anfrage ist ein Fehler aufgetreten.<br>Informationen für Entwickler:');
                $('#response').append('<pre>' + formattedJSON + '</pre>');
            }
        });
        return false;
    }

    $('#exhibitor-search input').on('change', function() {
        postRecipesFilterForm();
        return false;
    });

    postRecipesFilterForm()
});