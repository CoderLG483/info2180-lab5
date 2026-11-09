window.addEventListener('DOMContentLoaded', () => {
    const lookupBtn = document.querySelector('#lookup');
    const countryInput = document.querySelector('#country');
    const resultDiv = document.querySelector('#result');

    lookupBtn.addEventListener('click', () => {
        const query = encodeURIComponent(countryInput.value.trim());

        fetch(`world.php?country=${query}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
});