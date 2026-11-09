window.addEventListener('DOMContentLoaded', () => {
    const lookupBtn = document.querySelector('#lookup');
    const lookupCitiesBtn = document.querySelector('#lookup-cities');
    const countryInput = document.querySelector('#country');
    const resultDiv = document.querySelector('#result');

    function fetchData(lookupType = '') {
        const country = encodeURIComponent(countryInput.value.trim());
        let url = `world.php?country=${country}`;
        
        if (lookupType === 'cities') {
            url += `&lookup=cities`;
        }

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network error');
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }

    lookupBtn.addEventListener('click', () => {
        fetchData();
    });

    lookupCitiesBtn.addEventListener('click', () => {
        fetchData('cities');
    });
});