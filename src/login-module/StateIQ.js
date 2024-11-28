document.addEventListener("DOMContentLoaded", function () {
    const stateSelect = document.getElementById('state');
    const districtSelect = document.getElementById('district');

    // Fetch Indian States using Country ISO Code
    const states = csc.getStatesOfCountry('IN');

    // Populate States Dropdown
    states.forEach(state => {
        const option = document.createElement('option');
        option.value = state.name;
        option.textContent = state.name;
        stateSelect.appendChild(option);
    });

    // Update Districts Dropdown based on selected State
    stateSelect.addEventListener('change', function () {
        const selectedState = stateSelect.value;

        // Clear previous districts
        districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';

        // Get Districts of the selected State
        const selectedStateData = states.find(state => state.name === selectedState);
        const districts = csc.getCitiesOfState(selectedStateData.id);

        // Populate Districts Dropdown
        districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district.name;
            option.textContent = district.name;
            districtSelect.appendChild(option);
        });
    });
});