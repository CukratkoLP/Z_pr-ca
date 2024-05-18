const email = document.getElementById('email').value;
if (!email.includes('@')) {
  alert("Zadajte správnu formu e-mailu!");
  return;
}
document.getElementById('fo').reset();
window.open('typage.html', '_blank');
