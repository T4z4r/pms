function save_barcode() {
    let formData = document.querySelector('#barcode_form');
    url = formData.getAttribute('action');
    $.ajax({
        url: url,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: new FormData(formData),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#barcode_form').css('display', 'none');
            $('#small_title_barcode_success').fadeIn('slow');
            $('#small_title_barcode_fail').fadeOut('fast');
            $('#small_title_barcode_success').text('Generating barcodes...');
        },
        success: function(result) {
            // console.log(result)
            if (result.message) {
                $('#name').val(null);
                $('#done_btn').css('display', 'unset');
                $('#cancel_btn').css('display', 'none')
                $('#small_title_barcode_success').text('saved');
                setTimeout(function() {
                    $('#small_title_barcode_success').fadeOut('slow');
                }, 800);
                $('#small_title_barcode_success').fadeIn('fast');
                $('#barcode_form').css('display', 'unset');
                display_barcodes()
            } else {
                $('#small_title_barcode_success').fadeOut('fast');
                $('#small_title_barcode_fail').text('something is wrong, fail to save new category!.');
                setTimeout(function() {
                    $('#small_title_barcode_fail').fadeOut('slow');
                }, 6000);
                $('#small_title_barcode_fail').fadeIn('slow');

            }
        },
        complete: function(data) {

        }

    });

}


// insert data in  barcode  table
function populate_barcodes(url) {
    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function() {},
        success: function(result) {
            result = result['barcode_last_group_list']
            if (result) {
                // insert data in datatable
                var t = $('#example1').DataTable();
                // t.empty()
                // autoload datatable;
                var counter = 1;
                let barcodeHolder = []
                result.map(data => {
                    // assign values
                    let branch_id = data.branch_id
                    let category_id = data.category_id
                    let serial_no = data.serial_no
                    let id = data.id

                    if (branch_id < 10) {
                        branch_id = '0' + branch_id;
                    }
                    if (category_id < 10) {
                        category_id = '0' + category_id;
                    }
                    if (serial_no < 99999) {
                        serial_no = serial_number_generate(serial_no)
                    }

                    // display data in a row 
                    let barcode = branch_id + category_id + serial_no
                    t.row.add([
                        id, barcode
                    ]).draw(true);

                    barcodeHolder.push(id)

                    counter++;
                })

                $('#barcode_holder').val(null)
                $('#barcode_holder').val(barcodeHolder)

            }

        },
        complete: function(data) {

        }
    });




}

function serial_number_generate(serial_no) {
    if (serial_no.length == 1) {
        serial_no = '00000' + serial_no
    }
    if (serial_no.length == 2) {
        serial_no = '0000' + serial_no
    }
    if (serial_no.length == 3) {
        serial_no = '000' + serial_no
    }
    if (serial_no.length == 4) {
        serial_no = '00' + serial_no
    }
    if (serial_no.length == 5) {
        serial_no = '0' + serial_no
    }
    return serial_no;
}