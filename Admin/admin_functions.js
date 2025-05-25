// Function to add a new user
function addUser(userData) {
    fetch('add_user.php', {
            method: 'POST',
            body: JSON.stringify(userData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("User added successfully.");
                location.reload(); // Refresh the page
            } else {
                alert("Failed to add user: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error adding user:', error);
        });
}

// Function to edit user data
function editUser(userId, updatedData) {
    fetch(`edit_user.php?userID=${userId}`, {
            method: 'POST',
            body: JSON.stringify(updatedData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("User data updated successfully.");
                location.reload();
            } else {
                alert("Failed to update user: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error updating user:', error);
        });
}

// Function to delete a user
function deleteUser(userId) {
    if (!confirm("Are you sure you want to delete this user?")) return;

    fetch(`delete_user.php?userID=${userId}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("User deleted successfully.");
                location.reload();
            } else {
                alert("Failed to delete user: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting user:', error);
        });
}

// Function to handle form submission
document.getElementById('admin-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const userData = Object.fromEntries(formData.entries());

    if (userData.userID) {
        editUser(userData.userID, userData);
    } else {
        addUser(userData);
    }
});