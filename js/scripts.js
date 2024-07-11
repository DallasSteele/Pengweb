document.getElementById('transaction-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Form validation
    const name = document.getElementById('name').value;
    const amount = document.getElementById('amount').value;

    if(name === '' || amount === '') {
        document.getElementById('message').innerText = 'Please fill out all fields.';
        return;
    }

    // If valid, submit the form
    this.submit();
});

