function toggleSidebar() {
    var sidebar = document.querySelector('.sidebar');
    sidebar.style.display = (sidebar.style.display === 'block') ? 'none' : 'block';
}

window.addEventListener('DOMContentLoaded', () => {
    // Step 1: Make an AJAX request to fetch the ticket data from the server
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                displayTicketData(data);
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'ticket_data.php', true);
    xhr.send();

    // Step 2: Display the ticket data on the webpage
    function displayTicketData(data) {
        const purchasedCount = document.getElementById('purchased-count');
        const availableCount = document.getElementById('available-count');
        const vipCount = document.getElementById('vip-count');
        const genAdCount = document.getElementById('genad-count');

        purchasedCount.textContent = 'Purchased Tickets: ' + data.purchasedTickets;
        availableCount.textContent = 'Tickets Available: ' + data.newTicketAvailable;
        vipCount.textContent = 'VIP Ticket Count: ' + data.vipTicketCount;
        genAdCount.textContent = 'General Admission Ticket Count: ' + data.genAdTicketCount;
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var purchasedCount = document.querySelectorAll('.ticket-container')[0].querySelectorAll('.ticket-count');
    var availableTickets = parseInt(purchasedCount[1].textContent.split(': ')[1]);
    var unavailableTickets = parseInt(purchasedCount[0].textContent.split(': ')[1]);

    var totalTickets = availableTickets + unavailableTickets;

    var availableHeight = (availableTickets / totalTickets) * 100;
    var unavailableHeight = (unavailableTickets / totalTickets) * 100;

    var chartBars = document.querySelectorAll('.chart-bar');
    chartBars[0].style.height = availableHeight + '%';
    chartBars[1].style.height = unavailableHeight + '%';

    chartBars[0].setAttribute('title', 'Available Tickets: ' + availableTickets);
    chartBars[1].setAttribute('title', 'Unavailable Tickets: ' + unavailableTickets);
});

const chartContainer = document.getElementById('chart-container');
chartContainer.style.width = '100px';
chartContainer.style.height = '100px';



