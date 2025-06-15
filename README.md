# Vulnerable Web Application

This is a sample vulnerable web application created for security learning and exploitation practice.

## ⚠️ Included Vulnerabilities

### `login.php`
- SQL Injection (Login Bypass)

### `register.php`
- SQL Injection (Insert)
- XSS

### `changepasswd.php`
- SQL Injection (Update)
- CSRF Missing

### `deleteaccount.php`
- SQL Injection (Delete)
- IDOR

### `passreset.php`
- Blind SQL Injection

### `Profileupdate.php`
- CSRF Missing
- IDOR

### `pingurl.php`
- Command Injection

### `settings.php`
- XSS

### `tos.php`
- Local File Inclusion (LFI)

### `forgotpassword.html`
- Blind SQL Injection

### `index.html`
- Clickjacking

### `service.html`
- Clickjacking

## 🛠️ How to Run the App
Run this command from the terminal in the project folder:
```bash
php -S 0.0.0.0:8000
```
Then open your browser to `http://localhost:8000`

## 🔓 Example Exploits
- **Login Bypass (login.php)**: Try username `' OR '1'='1` and any password
- **Command Injection (pingurl.php)**: Use `8.8.8.8 | ls`
- **XSS (register.php)**: Input `<script>alert('XSS')</script>` in username
- **LFI (tos.php)**: Try `?page=../../../../etc/passwd`
- **Blind SQLi (passreset.php)**: Use time-based payloads like `' OR SLEEP(5)--`
