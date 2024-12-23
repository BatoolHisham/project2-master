let menuItems = JSON.parse(localStorage.getItem('menuItems')) || [];

    // Toggle Stock Status
    function toggleStockStatus(button, dishName, imgElement) {
        let dish = menuItems.find(item => item.name === dishName);

        if (!dish) {
            dish = { name: dishName, status: 'in-stock' };
            menuItems.push(dish);
        }

        if (dish.status === 'in-stock') {
            dish.status = 'out-of-stock';
            imgElement.classList.add('blurred');
        } else {
            dish.status = 'in-stock';
            imgElement.classList.remove('blurred');
        }

        button.textContent = dish.status === 'in-stock' ? 'Mark as Out of Stock' : 'Mark as In Stock';
        button.classList.toggle('btn-success', dish.status === 'in-stock');
        button.classList.toggle('btn-secondary', dish.status === 'out-of-stock');

        updateDishInLocalStorage(dish);
    }

    // Change Dish Image
    function changeDishImage(dishName, imgElement) {
        const dish = menuItems.find(item => item.name === dishName);

        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.click();

        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imgElement.src = e.target.result;
                    if (dish) {
                        dish.image = e.target.result;
                        updateDishInLocalStorage(dish);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Change Dish Price
    function changeDishPrice(dishName, priceElement) {
        const dish = menuItems.find(item => item.name === dishName);
        const newPrice = prompt('Enter the new price:', priceElement.textContent.replace(' JD', ''));

        if (newPrice && !isNaN(newPrice)) {
            priceElement.textContent = `${newPrice} JD`;
            if (dish) {
                dish.price = newPrice;
                updateDishInLocalStorage(dish);
            }
        }
    }

    // Delete Dish with Confirmation
    function confirmDelete(cardElement, dishName) {
        const confirmation = confirm("Are you sure you want to delete this?");
        
        if (confirmation) {
            deleteDish(cardElement, dishName);
        }
    }

    // Actual Deletion Function
    function deleteDish(cardElement, dishName) {
        menuItems = menuItems.filter(item => item.name !== dishName);
        cardElement.remove();
        localStorage.setItem('menuItems', JSON.stringify(menuItems));
    }

    // Update Local Storage
    function updateDishInLocalStorage(updatedDish) {
        menuItems = menuItems.map(item => item.name === updatedDish.name ? updatedDish : item);
        localStorage.setItem('menuItems', JSON.stringify(menuItems));
    }
    