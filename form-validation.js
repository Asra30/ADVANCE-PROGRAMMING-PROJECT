document.getElementById('registrationForm').addEventListener('submit', function(event) {
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (name === '' || email === '') {
        alert('Name and Email fields cannot be empty.');
        event.preventDefault();
        return;
    }
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        event.preventDefault();
        return;
    }
});
