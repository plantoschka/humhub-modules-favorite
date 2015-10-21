/**
 * Initialize favorite function
 */
function initFavoriteModule() {

    // Remove Existing Handlers
    $('.favoriteAnchor').off("click");
    $('.unfavoriteAnchor').off("click");

    // Handle Click on a Favorite Button
    $('.favoriteAnchor').on("click", function (event) {
        event.preventDefault();

        // Get ClassName and Id from Anchor
        arr = $(this).attr('id').split("-", 2); // Split: Object_1-FavoriteLInk
        arr = arr[0].split("_", 2); // Split: Object_1
        className = arr[0];
        id = arr[1];

        // Build Favorite Url
        url = "";
        if ($(this).hasClass('unfavorite')) {
            url = unfavoriteUrl.replace('-className-', className);
            url = url.replace('-id-', id);
        } else if ($(this).hasClass('favorite')) {
            url = favoriteUrl.replace('-className-', className);
            url = url.replace('-id-', id);
        } else {
            alert("Error: Invalid Favorite Anchor!");
            return;
        }


        // Execute Favorite
        data = {};
        data[csrfName] = csrfValue;

        $.ajax({
            dataType: "json",
            type: 'POST',
            data: data,
            url: url
        }).done(function (data) {

            // Switch Links
            if (data.currentUserFavorited) {
                $('#' + className + "_" + id + "-UnfavoriteLink").show();
                $('#' + className + "_" + id + "-FavoriteLink").hide();
            } else {
                $('#' + className + "_" + id + "-UnfavoriteLink").hide();
                $('#' + className + "_" + id + "-FavoriteLink").show();
            }

            updateFavoriteCounters(className, id, data.favoriteCounter);

        });

    });
}

/**
 * Updates the Favorite Counters
 *
 * This function will be called by FavoriteLinkWidget.
 */
function updateFavoriteCounters(className, id, count) {
    $('.' + className + "_" + id + "-FavoriteCount").hide();
    if (count > 0)
        $('.' + className + "_" + id + "-FavoriteCount").show();
    $('.' + className + "_" + id + "-FavoriteCount").html('(' + count + ')');
}