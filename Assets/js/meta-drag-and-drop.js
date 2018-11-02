KB.on('dom.ready', function() {

    function savePosition(metadataId, position) {
        var url = $(".metadata-table").data("save-position-url");

        $.ajax({
            cache: false,
            url: url,
            contentType: "application/json",
            type: "POST",
            processData: false,
            data: JSON.stringify({
                "id": metadataId,
                "position": position
            })
        });
    }

    $(".draggable-row-handle").mouseenter(function() {
        $(this).parent().parent().addClass("draggable-item-hover");
    }).mouseleave(function() {
        $(this).parent().parent().removeClass("draggable-item-hover");
    });

    $(".metadata-table tbody").sortable({
        forcePlaceholderSize: true,
        handle: "td:first i",
        helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });

            return ui;
        },
        stop: function(event, ui) {
            var metadata = ui.item;
            metadata.removeClass("draggable-item-selected");
            savePosition(metadata.data("metadata-id"), metadata.index() + 1);
        },
        start: function(event, ui) {
            ui.item.addClass("draggable-item-selected");
        }
    }).disableSelection();
});
