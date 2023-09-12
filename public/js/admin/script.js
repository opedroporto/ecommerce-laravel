// /* Dropdown */
// var elemDrop = document.querySelectorAll('.dropdown-trigger');
// var instanceDrop = M.Dropdown.init(elemDrop, {
//     coverTrigger: false,
//     constrainWidth: false
// });


// /* SideNav */
// var elemSideNav = document.querySelectorAll('.sidenav');
// var instanceSideNav = M.Sidenav.init(elemSideNav);


// /* Modal */
// var elemsModal = document.querySelectorAll('.modal');
// var instanceModal = M.Modal.init(elemsModal);

// /* Select */
// var elems = document.querySelectorAll('select');
// var instances = M.FormSelect.init(elems);

// /* Fullscreen */
// function fullScreen() {        
//         if (!document.fullscreenElement) {
//             document.documentElement.requestFullscreen();
//         } else {
//             document.exitFullscreen();
//         }
// }

/* Gráfico 01 */
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Janeiro', 'Feveiro', 'Março', 'Abril'],
        datasets: [{
            label: '2020',
            data: [12, 19, 3, 5],
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',                         
                'rgba(255, 159, 64, 1)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',                     
                'rgba(255, 159, 64, 1)'
            ],
        borderWidth: 1, 
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

/* Gráfico 02 */
var ctx = document.getElementById('myChart2');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Facebook', 'Google', 'Instagram'],
        datasets: [{
            label: 'Visitas',
            data: [12, 19, 3],
            backgroundColor: [
                'rgba(255, 99, 132)',
                'rgba(54, 162, 235)',                         
                'rgba(255, 159, 64)'
            ]
        }]
    }
});
