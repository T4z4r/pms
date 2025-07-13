function get_list(url, item_list, item_key_name, item_id, item_name) {
    // populate items (calling the function to get items list)
    $.ajax({
        url: url,
        method: "GET",
        cache: false,
        beforeSend: function(item_list) {},
        success: function(item_list) {
            var item_list = item_list[item_key_name]
            const length = item_list.length
                // check if there is any branch
            if (length == 0) {
                $('#' + item_id).append('<option value="0">No any ' + item_name + ' yet!.</option>');
            }
            // display data
            item_list.map(data => {
                $('#' + item_id).append('<option value="' + data.id + '">' + data.name + '</option>')
            })
            $('#' + item_id).selectpicker('refresh');
        },
        complete: function(item_list) {}
    })

}