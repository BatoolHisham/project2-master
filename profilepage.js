document.getElementById('profile-image-upload').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // Update the profile image preview
            document.getElementById('profile-image-preview').src = e.target.result;
            // Update the header image
            document.getElementById('header-profile-image').src = e.target.result;
            // Store the image in localStorage for cross-page persistence
            localStorage.setItem('profileImage', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});

// On page load, check if there's a stored profile image and set it
/*window.onload = function () {
    const storedImage = localStorage.getItem('profileImage');
    if (storedImage) {
        document.getElementById('profile-image-preview').src = storedImage;
        document.getElementById('header-profile-image').src = storedImage;
    }
};*/

window.onload = function () {
    
    // Load profile image from localStorage
    const storedImage = localStorage.getItem('profileImage');
    if (storedImage) {
        document.getElementById('profile-image-preview').src = storedImage;
        document.getElementById('header-profile-image').src = storedImage;
    }

    // Load phone number from localStorage
    const storedPhoneNumber = localStorage.getItem('phoneNumber');
    if (storedPhoneNumber) {
        document.getElementById('phone').value = storedPhoneNumber;
    } else {
        // Optional: Fetch phone number from the server if not available in localStorage
        fetch('getUserDetails.php')
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log response to debug
                if (data.status === 'success') {
                    document.getElementById('phone-number').value = data.phone;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error fetching user details:', error));
    }
};

// Delete profile image functionality
document.getElementById('delete-profile-image').addEventListener('click', function () {
    const defaultImage = './images/profile logo.png';
    document.getElementById('profile-image-preview').src = defaultImage;
    document.getElementById('header-profile-image').src = defaultImage;
    localStorage.removeItem('profileImage');
});
//handle the password change and send a request to the backend
document.getElementById('update-profile').addEventListener('click', async () => {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (!password || !confirmPassword) {
        alert('Please fill in both password fields.');
        return;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
    }

    try {
        const response = await fetch('updatePassword.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ password }),
        });

        const result = await response.json();
        if (result.status === 'success') {
            alert(result.message);
            document.getElementById('password').value = '';
            document.getElementById('confirm-password').value = '';
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error updating password:', error);
        alert('An unexpected error occurred. Please try again later.');
    }
});
// Save changes to phone number
document.getElementById('phone-number').addEventListener('blur', function () {
    const newPhoneNumber = this.value;

    fetch('updateUserDetails.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ phone: newPhoneNumber }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Phone number updated successfully!');
            } else {
                alert('Failed to update phone number: ' + data.message);
            }
        })
        .catch(error => console.error('Error updating phone number:', error));
});