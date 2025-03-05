// Select photo button handler
document.querySelector('.select-btn').addEventListener('click', function() {
    document.getElementById('photoInput').click();
});

// Photo preview functionality
document.getElementById('photoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, or GIF)');
            this.value = '';
            return;
        }

        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            this.value = '';
            return;
        }

        // Show upload button and preview
        document.querySelector('.upload-btn').style.display = 'inline-block';
        document.querySelector('.select-btn').textContent = 'Change Photo';
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.profile-image img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Photo upload handling
document.getElementById('photoForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const photoFile = document.getElementById('photoInput').files[0];
    if (!photoFile) {
        alert('Please select a photo first');
        return;
    }

    const formData = new FormData();
    formData.append('photo', photoFile);

    try {
        const uploadBtn = document.querySelector('.upload-btn');
        const selectBtn = document.querySelector('.select-btn');
        uploadBtn.disabled = true;
        selectBtn.disabled = true;
        uploadBtn.textContent = 'Uploading...';

        const response = await fetch('update_photo.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        
        if(result.success) {
            alert(result.message || 'Photo updated successfully');
            location.reload();
        } else {
            alert(result.message || 'Failed to upload photo');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while uploading the photo');
    } finally {
        const uploadBtn = document.querySelector('.upload-btn');
        const selectBtn = document.querySelector('.select-btn');
        uploadBtn.disabled = false;
        selectBtn.disabled = false;
        uploadBtn.textContent = 'Upload Photo';
    }
});

// Rest of your existing profile update handling code remains the same