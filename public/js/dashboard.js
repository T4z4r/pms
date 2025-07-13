
 $(function () {
/* ChartJS
 * -------
 * Here we will create a few charts using ChartJS
 */

function get_task_data(asset_id) {
    let url = "{{ url('get_task_data') }}"
    $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        beforeSend: function () {},
        success: function (result) {
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Waiting',
                    'Initialized',
                    'Inprogress',
                    'Halted',
                    'Complete',
                ],
                datasets: [{
                    data: [
                        result.result.waitingTaskCount,
                        result.result.initializedTaskCount,
                        result.result.inProgressTaskCount,
                        result.result.haltedTaskCount,
                        result.result.completeTaskCount
                    ],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12',
                        '#00c0ef', '#3c8dbc', '#d2d6de'
                    ],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })


        }
    })

}


function get_repair_data() {
    let url = "{{ url('get_repair_data') }}"
    $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        beforeSend: function () {},
        success: function (result) {
            console.log("repair", result.result)
            var donutChartCanvas = $('#donutChartRepair').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Unassigned',
                    'Inprogress',
                    'Cancelled',
                    'Complete',
                ],
                datasets: [{
                    data: [
                        result.result.unassignedRepairsCount,
                        result.result.inProgressRepairCount,
                        result.result.cancelledRepairCount,
                        result.result.completeRepairCount
                    ],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12',
                        '#00c0ef', '#d2d6de'
                    ],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })


        }
    })

}




function get_maintenance_data() {
    let url = "{{ url('get_maintenance_data') }}"
    $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        beforeSend: function () {},
        success: function (result) {
            console.log("repair", result.result)
            var donutChartCanvas = $('#donutChartMaintenance').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Coming',
                    'InProgress',
                    'Complete',
                    'Cancelled',
                ],
                datasets: [{
                    data: [
                        result.result.comingMaintenanceCount,
                        result.result.inProgressMaintenanceCount,
                        result.result.completeMaintenanceCount,
                        result.result.cancelledMaintenanceCount
                    ],
                    backgroundColor: ['#00a65a', '#f39c12', '#00c0ef',
                        '#d2d6de'
                    ],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })


        }
    })

}


get_repair_data()
get_task_data()
get_maintenance_data()

// Radialize the colors



})
