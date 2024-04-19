document.getElementById('addressForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission
        
        // Get selected values
        const city = document.getElementById('city').value;
        const postalCode = document.getElementById('postal_code').value;
        const street = document.getElementById('street').value;
        const number = document.getElementById('number').value;
        // const addition = document.getElementById('addition').value;

        // Construct the URL
        const url = `https://www.openstreetmap.org/search?query=${city}+${postalCode}+${street}+${number}`;

        // Open the URL
        window.open(url, '_blank');
    });
