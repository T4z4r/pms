function status_finder(status_id) {
    if (status_id == 1) {
        status_ = 'Old'
    }
    if (status_id == 2) {
        status_ = 'New'
    }
    return status_
}

function department_finder(department_id) {
    let department = 'none';

    return department;
}



function get_current_price(asset_id, url) {
    $.ajax({
        url: url,
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { asset_id: asset_id },
        success: function(result) {
            localStorage.setItem("current_price_" + result.id, result.asset_price);
            // console.log(result.asset_price);
        }
    });

}


function get_supplier() {
    $.ajax({
        url: url,
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { asset_id: asset_id },
        success: function(result) {
            localStorage.setItem("current_price_" + id, result.asset_price);
            // console.log(result.asset_price);
        }
    });
}