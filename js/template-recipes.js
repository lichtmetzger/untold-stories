jQuery(function($){
    let currentRecipesPage = 1;
    let totalRecipesPages = 1;

    let $grid = $('#response').masonry({
        itemSelector: '.recipe-card-wrap',
        percentPosition: true
    });

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
        // Store the current page globally
        currentRecipesPage = pageNumber;

        // Get filter options from user
        const options = await getRecipesFilterInputData();

        // Clear results
        $grid.masonry('remove', $grid.find('.recipe-card-wrap'));
        $('#response').empty();

        $.ajax({
            url: window.location.origin + '/wp-json/recipes/v1/filter-recipes/',
            method: 'GET',
            data: {
                recipeCategories: options.recipeCategories,
                page: currentRecipesPage
            },
            success: function(response, status, xhr) {
                totalRecipesPages = parseInt(xhr.getResponseHeader('X-WP-TotalPages')) || 1;
                let items = response.data;

                if (items.length > 0) {
                    let cards = items.map(item => `
                    <a class="col-sm-4 recipe-card-wrap" href="${item.permalink}">
                        <div class="recipe-card">
                            <span class="category">${item.category}</span>
                            <div class="recipe-content">
                                <div class="thumb">
                                    <img src="${item.imageUrl}" alt="${item.title}" />
                                </div>
                                <h3 class="title">${item.title}</h3>
                            </div>
                        </div>
                    </a>`);

                    // Fade in one-by-one
                    let index = 0;
                    const interval = setInterval(function() {
                        const newCard = $(cards[index]);
                        newCard.animate({ opacity: 1 }, 800);
                        $grid.append(newCard);
                        $grid.masonry('appended', newCard);

                        // Once image is loaded, re-layout
                        newCard.find('img').on('load', function() {
                            $grid.masonry('layout');
                        });

                        index++;
                        if (index === cards.length) clearInterval(interval);
                    }, 50);

                } else {
                    $('#response').append('Keine Ergebnisse gefunden. Bitte ändere deine Filteroptionen.');
                }

                renderRecipesPagination();
            },
            error: function(error) {
                var formattedJSON = JSON.stringify(error, null, 2);
                $('#response').append('Bei deiner Anfrage ist ein Fehler aufgetreten.<br>Informationen für Entwickler:');
                $('#response').append('<pre>' + formattedJSON + '</pre>');
            }
        });

        return false;
    }

    function renderRecipesPagination() {
        let paginationHtml = '';

        const addPageBtn = (page, label = null, active = false) => {
            paginationHtml += `<button class="recipes-page-btn ${active ? 'active' : ''}" data-page="${page}">${label || page}</button>`;
        };

        if (currentRecipesPage > 1) {
            addPageBtn(currentRecipesPage - 1, '«');
        }

        const maxVisible = 5;
        const sideCount = 2;

        // Always show first page
        if (currentRecipesPage > sideCount + 2) {
            addPageBtn(1);
            paginationHtml += `<span class="ellipsis">...</span>`;
        }

        // Page range around current page
        let startPage = Math.max(1, currentRecipesPage - sideCount);
        let endPage = Math.min(totalRecipesPages, currentRecipesPage + sideCount);

        for (let i = startPage; i <= endPage; i++) {
            addPageBtn(i, null, i === currentRecipesPage);
        }

        // Always show last page
        if (currentRecipesPage < totalRecipesPages - sideCount - 1) {
            paginationHtml += `<span class="ellipsis">...</span>`;
            addPageBtn(totalRecipesPages);
        }

        if (currentRecipesPage < totalRecipesPages) {
            addPageBtn(currentRecipesPage + 1, '»');
        }

        $('#pagination').html(paginationHtml);
    }

    $(document).on('click', '.recipes-page-btn', function() {
        let page = parseInt($(this).data('page'));
        // Scroll back to top
        document.getElementById("site-content").scrollIntoView();
        postRecipesFilterForm(page);
    });

    $('.recipe-filter input').on('change', function() {
        postRecipesFilterForm();
        return false;
    });

    postRecipesFilterForm();
});