function validateRegister() {
    const password = document.querySelector('input[name="password"]').value;
    if (password.length < 6) {
      alert("Password minimal 6 karakter");
      return false;
    }
    return true;
  }
  