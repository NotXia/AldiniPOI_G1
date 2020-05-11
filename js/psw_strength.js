var strength = {
   0: "Pessima 😣",
   1: "Debole 😞",
   2: "Mediocre 😐",
   3: "Buona 😃",
   4: "Ottima 😄"
}
var password = document.getElementById('password');
var text = document.getElementById('password-strength-text');

password.addEventListener('input', function() {
   var val = password.value;
   var result = zxcvbn(val);
   if(val !== "") {
      text.style = "display: block;"
      text.innerHTML = "Efficacia: " + "<strong>" + strength[result.score] + "</strong>";
      document.getElementById('strength').value = result.score;
   }
   else {
      text.style = "display: none;"
      text.innerHTML = "";
   }
});
