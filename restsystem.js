//Elements
// const addDishForm = document.getElementById('addNewItemForm');
const headerProfilePic = document.getElementById('header-profile-image');

// Define categories for each restaurant
const restaurantCategories = {
    'IT Milkbar': ['Drinks', 'Sweets', 'Sandwiches'],
    'Medicine Milkbar': ['Drinks', 'Sweets', 'Sandwiches'],
    'Main Snackway': ['Pizza', 'Manakeesh', 'Sandwiches', 'Snacks', 'Burger', 'Shawarma'],
    'Student Snackway': ['Pizza', 'Manakeesh', 'Sandwiches', 'Snacks', 'Burger', 'Shawarma'],
    'Business Saj': ['Pizza', 'Manakeesh', 'Sandwiches', 'Burger'],
    'Agriculture Saj': ['Pizza', 'Manakeesh', 'Sandwiches', 'Burger']
};

// Load profile image from localStorage on page load
window.onload = function () {
    loadProfileImage();
    const activeSection = localStorage.getItem('activeSection') || 'addNewItem';
    showSection(activeSection);
    loadMenuItems(); // Load menu items on page load
};

// Load profile image
function loadProfileImage() {
    const storedImage = localStorage.getItem('profileImage') || './images/profile logo.png';
    headerProfilePic.src = storedImage;
}

// Handle form submission to add a new dish
// addDishForm.addEventListener('submit', submitAddNewItemForm);

function submitAddNewItemForm(event) {
    event.preventDefault();

    const dishName = document.getElementById('dishName').value;
    const dishPrice = document.getElementById('dishPrice').value;
    const dishImage = document.getElementById('dishImage').files[0];
    const selectedCategory = document.getElementById('selectedCategory').textContent;

    if (!selectedRestaurant || !selectedCategory ||selectedCategory === 'Select Category') {
        alert('Please select a restaurant and category!');
        return;
    }

    if (dishImage) {
        const reader = new FileReader();
        reader.onload = function (event) {
            const dish = {
                name: dishName,
                price: dishPrice,
                image: event.target.result, // Base64 image data
                category: selectedCategory
            };

            saveDishToLocalStorage(dish);
            alert("New dish added successfully!");

            // Reset form
            document.getElementById('addNewItemForm').reset();
            document.getElementById('selectedCategory').textContent = 'Select Category';
        };
        reader.readAsDataURL(dishImage);
    }
}

function saveDishToLocalStorage(dish) {
    const menuItems = JSON.parse(localStorage.getItem('menuItems')) || [];
    menuItems.push(dish);
    localStorage.setItem('menuItems', JSON.stringify(menuItems));
    loadMenuItems(); // Reload menu items to reflect changes
}

// Show the corresponding section and persist it
function showSection(sectionId) {
    const sections = document.querySelectorAll('.collapse');
    sections.forEach(section => section.classList.remove('show'));

    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('show');
        localStorage.setItem('activeSection', sectionId); // Save active section
    }
}
/*
// Set the selected restaurant value
function setRestaurant(restaurant) {
    document.getElementById('selectedRestaurant').textContent = restaurant;
    document.getElementById('selectedRestaurantValue').value = restaurant; // Store the restaurant
    updateCategoryDropdown(restaurant); // Update categories based on the selected restaurant
}*/
/*
// Set the selected category value
function setCategory(category) {
    document.getElementById('selectedCategory').textContent = category;
    document.getElementById('selectedCategoryValue').value = category; // Store the category
}*/



// JavaScript to handle form submission and category selection

// Function to set the selected category
function setCategory(category) {
    const selectedCategoryElement = document.getElementById('selectedCategory');
    const selectedCategoryValueElement = document.getElementById('selectedCategoryValue');

    if (!selectedCategoryElement || !selectedCategoryValueElement) {
        console.error('Category elements not found in the DOM.');
        return;
    }

    // Update the visible category text
    selectedCategoryElement.textContent = category;

    // Update the hidden input value for form submission
    selectedCategoryValueElement.value = category;
}
/*
// Function to handle form submission
document.getElementById('addItemform').addEventListener('submit', async function (event) {
    event.preventDefault(); // Prevent default form submission

    // Collect form data
    const dishName = document.getElementById('dishName').value.trim();
    const dishPrice = parseFloat(document.getElementById('dishPrice').value);
    const dishCategory = document.getElementById('selectedCategoryValue').value;
    const dishImage = document.getElementById('dishImage').files[0];
    const restaurantId = localStorage.getItem('selectedRestaurant'); // Retrieve restaurant ID from localStorage
    console.log("ResID",restaurantId);
    // Basic validation
    if (!dishName || isNaN(dishPrice) || dishPrice <= 0 || !dishCategory || !restaurantId) {
        alert('Please fill out all fields correctly.');
        return;
    }

    // Create a FormData object to handle the file and text fields
    const formData = new FormData();
    formData.append('dishName', dishName);
    formData.append('dishPrice', dishPrice);
    formData.append('category', dishCategory);
    formData.append('dishImage', dishImage);
    formData.append('restaurant_id', restaurantId); // Include restaurant ID in form data

    try {
        const response = await fetch('add_menu_item.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.status === 'success') {
            alert(result.message);
            document.getElementById('addItemform').reset(); // Reset the form
            document.getElementById('selectedCategory').textContent = 'Select Category';
            window.location.href = 'restsystem.html'; // Redirect on success
        } else {
            alert(result.message);
            window.location.href = 'restsystem.html';
        }
    } catch (error) {
        console.error('Error submitting the form:', error);
        alert('An error occurred while adding the item. Please try again.');
    }
});

*/




// Update the category dropdown based on the selected restaurant
function updateCategoryDropdown(restaurant) {
    const categoryList = document.getElementById('categoryList');
    categoryList.innerHTML = ''; // Clear existing categories

    const categories = restaurantCategories[restaurant] || [];
    
    categories.forEach(category => {
        const categoryItem = document.createElement('li');
        categoryItem.innerHTML = `<a class="dropdown-item" href="#" onclick="setCategory('${category}')">${category}</a>`;
        categoryList.appendChild(categoryItem);
    });

    // Reset the selected category
    document.getElementById('selectedCategory').textContent = 'Select Category';
    document.getElementById('selectedCategoryValue').value = '';  // Reset the hidden input
}


// Function to load menu items into the correct category sections
function loadMenuItems() {
    const sections = document.querySelectorAll('.menusSYS');

    sections.forEach(section => {
        const categoryId = section.id.replace('-items-container', ''); // Get category name from section id (e.g., 'Sandwiches', 'Drinks')
        const categoryContainer = document.getElementById(`${categoryId}-items`);
        categoryContainer.innerHTML = ''; // Clear existing items

        menuItems.filter(item => item.category === categoryId).forEach(dish => {
            const dishCard = createDishCard(dish); // Create dish card for each item
            categoryContainer.appendChild(dishCard); // Append dish card to the container
        });
    });
}
/*
async function loadRestaurantMenu() {
    try {
        const response = await fetch('get_menu.php');
        const result = await response.json();

        if (result.status === 'success') {
            const menuContainer = document.getElementById('menuItems');
            menuContainer.innerHTML = '';

            if (result.data.length === 0) {
                menuContainer.innerHTML = '<p>No items available for this restaurant.</p>';
                return;
            }

            result.data.forEach(item => {
                const menuItemDiv = document.createElement('div');

                const imagePath = `./images/${item.image}`;
                console.log("Image Path:", imagePath); // Debugging the image path


                menuItemDiv.classList.add('col');
                menuItemDiv.innerHTML = `
                    <div class="card">
                        <img src="${imagePath}" class="card-img-top" alt="${item.name}" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">${item.name}</h5>
                            <p class="card-text"><strong>Price:</strong> $${item.price.toFixed(2)}</p>
                            <div class="d-flex flex-column">
                                <button class="btn btn-warning mb-2" onclick="markOutOfStock(${item.menu_item_id})">Out of Stock</button>
                                <button class="btn btn-primary mb-2" onclick="editPrice(${item.menu_item_id})">Edit Price</button>
                                <button class="btn btn-info mb-2" onclick="changePhoto(${item.menu_item_id})">Change Photo</button>
                                <button class="btn btn-danger" onclick="deleteItem(${item.menu_item_id})">Delete Item</button>
                            </div>
                        </div>
                    </div>
                `;
                menuContainer.appendChild(menuItemDiv);
            });
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error fetching menu:', error);
        alert('Failed to load menu. Please try again later.');
    }
}
*/
function markOutOfStock(itemId) {
    if (confirm('Mark this item as out of stock?')) {
        // Send a request to update the item's stock status
        fetch('updateMenuItem.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'outOfStock', itemId }),
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert(result.message);
                    loadRestaurantMenu(); // Refresh menu
                } else {
                    alert(result.message);
                }
            })
            .catch(error => console.error('Error updating item:', error));
    }
}

function editPrice(itemId) {
    const newPrice = prompt('Enter the new price for this item:');
    if (newPrice) {
        fetch('updateMenuItem.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'editPrice', itemId, newPrice }),
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert(result.message);
                    loadRestaurantMenu(); // Refresh menu
                } else {
                    alert(result.message);
                }
            })
            .catch(error => console.error('Error updating price:', error));
    }
}

function changePhoto(itemId) {
    const newPhoto = prompt('Enter the URL of the new photo for this item:');
    if (newPhoto) {
        fetch('updateMenuItem.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'changePhoto', itemId, newPhoto }),
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert(result.message);
                    loadRestaurantMenu(); // Refresh menu
                } else {
                    alert(result.message);
                }
            })
            .catch(error => console.error('Error updating photo:', error));
    }
}

function deleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item?')) {
        fetch('updateMenuItem.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'deleteItem', itemId }),
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert(result.message);
                    loadRestaurantMenu(); // Refresh menu
                } else {
                    alert(result.message);
                }
            })
            .catch(error => console.error('Error deleting item:', error));
    }
}

// Call loadRestaurantMenu when the page loads
//document.addEventListener('DOMContentLoaded', loadRestaurantMenu);




// Function to create dish card elements
function createDishCard(dish) {
    const card = document.createElement('div');
    card.className = 'col-md-3'; // Adjust the size if needed

    card.innerHTML = `
        <div class="card" style="width: 15rem;">
            <img src="${dish.image || 'default-image.jpg'}" 
                 class="card-img-top img-fluid dish-image ${dish.status === 'out-of-stock' ? 'blurred' : ''}" 
                 alt="${dish.name}">
            <span class="padding-top changing-color d-flex justify-content-between">
                <p class="card-text">${dish.name}</p>
                <span class="dish-price">${dish.price || '0.00'} JD</span>
            </span>
            <div class="d-grid gap-2">
                <!-- Toggle Stock -->
                <button class="btn ${dish.status === 'in-stock' ? 'btn-success' : 'btn-secondary'}"
                    onclick="toggleStockStatus(this, '${dish.name}', this.closest('.card').querySelector('.dish-image'))">
                    ${dish.status === 'in-stock' ? 'Mark as Out of Stock' : 'Mark as In Stock'}
                </button>
                <!-- Change Image -->
                <button class="btn btn-primary"
                    onclick="changeDishImage('${dish.name}', this.closest('.card').querySelector('.dish-image'))">
                    Change Image
                </button>
                <!-- Change Price -->
                <button class="btn btn-warning text-dark"
                    onclick="changeDishPrice('${dish.name}', this.closest('.card').querySelector('.dish-price'))">
                    Change Price
                </button>
                <!-- Delete Dish -->
                <button class="btn btn-danger"
                    onclick="confirmDelete(this.closest('.card'), '${dish.name}')">
                    Delete
                </button>
            </div>
        </div>
    `;
    return card;
}
/* 
const addDishForm = document.getElementById('addNewItemForm');
const headerProfilePic = document.getElementById('header-profile-image');

// Define categories for each restaurant
const restaurantCategories = {
  'IT Milkbar': ['Drinks', 'Sweets', 'Sandwiches'],
  'Medicine Milkbar': ['Drinks', 'Sweets', 'Sandwiches'],
  'Main Snackway': ['Pizza', 'Manakeesh', 'Sandwiches', 'Snacks', 'Burger', 'Shawarma'],
  'Student Snackway': ['Pizza', 'Manakeesh', 'Sandwiches', 'Snacks', 'Burger', 'Shawarma'],
  'Business Saj': ['Pizza', 'Manakeesh', 'Sandwiches', 'Burger'],
  'Agriculture Saj': ['Pizza', 'Manakeesh', 'Sandwiches', 'Burger']
};
*/
// Load profile image from localStorage on page load
window.addEventListener('load', function() {
  loadProfileImage();
  const activeSection = localStorage.getItem('activeSection') || 'addNewItem';
  showSection(activeSection);
  loadRestaurantMenu(); // Load menu items on page load
});

// Load profile image
function loadProfileImage() {
  const storedImage = localStorage.getItem('profileImage') || './images/profile logo.png';
  headerProfilePic.src = storedImage;
}

// Handle form submission to add a new dish
// addDishForm.addEventListener('submit', submitAddNewItemForm);

function submitAddNewItemForm(event) {
  event.preventDefault();
  const dishName = document.getElementById('dishName').value;
  const dishPrice = document.getElementById('dishPrice').value;
  const dishImage = document.getElementById('dishImage').files[0];
  const selectedRestaurant = document.getElementById('selectedRestaurant');
  const selectedCategory = document.getElementById('selectedCategory').textContent;

  if (!selectedRestaurant || !selectedCategory || selectedRestaurant === 'Select Restaurant' || selectedCategory === 'Select Category') {
    alert('Please select a restaurant and category!');
    return;
  }

  if (dishImage) {
    const reader = new FileReader();
    reader.onload = function(event) {
      const dish = {
        name: dishName,
        price: dishPrice,
        image: event.target.result, // Base64 image data
        restaurant: selectedRestaurant,
        category: selectedCategory
      };
      saveDishToLocalStorage(dish);
      alert("New dish added successfully!");
      // Reset form
      document.getElementById('addNewItemForm').reset();
      document.getElementById('selectedRestaurant').textContent = 'Select Restaurant';
      document.getElementById('selectedCategory').textContent = 'Select Category';
    };
    reader.readAsDataURL(dishImage);
  }
}

function saveDishToLocalStorage(dish) {
  const menuItems = JSON.parse(localStorage.getItem('menuItems')) || [];
  menuItems.push(dish);
  localStorage.setItem('menuItems', JSON.stringify(menuItems));
  loadRestaurantMenu(); // Reload menu items to reflect changes
}

// Show the corresponding section and persist it
function showSection(sectionId) {
  const sections = document.querySelectorAll('.collapse');
  sections.forEach(section => section.classList.remove('show'));
  const targetSection = document.getElementById(sectionId);
  if (targetSection) {
    targetSection.classList.add('show');
    localStorage.setItem('activeSection', sectionId); // Save active section
  }
}
/*
// Set the selected restaurant value
function setRestaurant(restaurant) {
  document.getElementById('selectedRestaurant').textContent = restaurant;
  document.getElementById('selectedRestaurantValue').value = restaurant; // Store the restaurant
  updateCategoryDropdown(restaurant); // Update categories based on the selected restaurant
}*/
// Function to prompt and update quantity by menu_item_id
function updateQuantity(menuItemId) {
    const newQuantity = prompt("Enter the new quantity for menu item ID: " + menuItemId);

    if (newQuantity !== null) {
        // Ensure the input is a valid number
        if (isNaN(newQuantity) || newQuantity < 0) {
            alert("Invalid quantity. Please enter a positive number.");
            return;
        }

        // Send the new quantity to the server
        fetch('update_quantity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                menu_item_id: menuItemId,
                quantity: newQuantity,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    alert("Quantity updated successfully!");
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert("Error updating quantity: " + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("An error occurred while updating the quantity.");
            });
    }
}
// Function to prompt and update price by menu_item_id
function updatePrice(menuItemId) {
    const newPrice = prompt("Enter the new price for menu item ID: " + menuItemId);

    if (newPrice !== null) {
        // Ensure the input is a valid number
        if (isNaN(newPrice) || newPrice <= 0) {
            alert("Invalid price. Please enter a positive number.");
            return;
        }

        // Send the new price to the server
        fetch('update_price.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                menu_item_id: menuItemId,
                price: newPrice,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    alert("Price updated successfully!");
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert("Error updating price: " + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("An error occurred while updating the price.");
            });
    }
}
// Function to delete a menu item by menu_item_id
function deleteMenuItem(menuItemId) {
    if (confirm("Are you sure you want to delete this menu item?")) {
        fetch('delete_menu_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                menu_item_id: menuItemId,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    alert("Menu item deleted successfully!");
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert("Error deleting menu item: " + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("An error occurred while deleting the menu item.");
            });
    }
}


