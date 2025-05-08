document.addEventListener("DOMContentLoaded", function() {
    const addButton = document.querySelector('.add');
    const submitButton = document.querySelector('input[type="submit"]');
    const form = document.querySelector('.form1');
    const menuWrapper = document.querySelector(".menu-wrapper");
    const menu = document.querySelector(".menu");
    let dates = [];
    
    // Add button functionality
    if (addButton) {
        addButton.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            
            const servtime = document.querySelector("#servicetime");
            const descriptionBox = document.querySelector("#description");

            if (!servtime.value) {
                alert("Please select a service availability time.");
                return;
            }

            const newDate = "Time Available is: " + new Date(servtime.value).toLocaleString();
            dates.push(servtime.value);
            
            if (descriptionBox.value) {
                descriptionBox.value += "\n" + newDate;
            } else {
                descriptionBox.value = newDate;
            }

            servtime.value = '';
        });
    }

    // Submit button functionality
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            // Create a hidden input for each date
            dates.forEach((date, index) => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `service_avalablity_time_${index}`;
                hiddenInput.value = date;
                form.appendChild(hiddenInput);
            });
        });
    }

    // Menu toggle functionality
    if (menuWrapper && menu) {
        menuWrapper.addEventListener("click", () => {
            menuWrapper.classList.toggle("active");
            menu.classList.toggle("active");
        });
    }
});