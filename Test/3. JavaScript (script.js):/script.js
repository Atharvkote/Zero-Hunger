// Array to store food donations
let donations = [];

// Function to add a new donation
document.getElementById('donationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Get input values
    const donorName = document.getElementById('donorName').value;
    const donorContact = document.getElementById('donorContact').value;
    const foodType = document.getElementById('foodType').value;
    const quantity = document.getElementById('quantity').value;
    
    // Create a donation object
    const donation = {
        name: donorName,
        contact: donorContact,
        food: foodType,
        quantity: quantity
    };

    // Add the donation to the array
    donations.push(donation);

    // Update the food list
    updateFoodList();

    // Clear the form
    document.getElementById('donationForm').reset();
});

// Function to update the list of available food
function updateFoodList() {
    const foodList = document.getElementById('foodList');
    foodList.innerHTML = '';
    
    donations.forEach(function(donation, index) {
        const li = document.createElement('li');
        li.textContent = `${donation.quantity}kg of ${donation.food} donated by ${donation.name} (Contact: ${donation.contact})`;
        foodList.appendChild(li);
    });
}
