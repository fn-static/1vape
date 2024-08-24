// Skrypt dodający produkty do koszyka
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        alert('Produkt został dodany do koszyka!');
    });
});


// Rejestracja użytkownika
document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Zapis danych użytkownika w LocalStorage (tymczasowe rozwiązanie)
    localStorage.setItem('user', JSON.stringify({ username, email, password }));
    
    alert('Rejestracja zakończona sukcesem!');
    window.location.href = 'login.html';
});

// Logowanie użytkownika
document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    const user = JSON.parse(localStorage.getItem('user'));
    
    if (user && user.email === email && user.password === password) {
        alert('Logowanie zakończone sukcesem!');
        window.location.href = 'index.html';
    } else {
        alert('Niepoprawny email lub hasło.');
    }
});
