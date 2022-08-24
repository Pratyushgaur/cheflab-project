$(".isNumber").keypress(function (event) {
  //only float value
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    (charCode != 8 &&
      charCode != 9 &&
      (charCode < 48 || charCode > 57) &&
      charCode != 46 &&
      charCode != 39 &&
      charCode != 37 &&
      charCode != 13) ||
    charCode == 37
  ) {
    return false;
  }
  return true;
});
$(".isInteger").keypress(function (event) {
  // integer
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    (charCode != 8 &&
      charCode != 9 &&
      (charCode < 48 || charCode > 57) &&
      charCode != 37 &&
      charCode != 13) ||
    charCode == 37
  ) {
    return false;
  }
  return true;
});
$(".isAlpha").keypress(function (event) {
  // only alphabets with space and percentage sign
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    (charCode != 8 &&
      charCode != 9 &&
      charCode != 46 &&
      (charCode < 97 || charCode > 122) &&
      (charCode < 65 || charCode > 90) &&
      charCode != 39 &&
      charCode != 32) ||
    charCode == 37 ||
    charCode == 38
  ) {
    return false;
  }
  return true;
});
$(".isAlphaSpecialChar").keypress(function (event) {
  // only alphabets with space and percentage sign
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;

  if (
    (charCode != 8 &&
      charCode != 9 &&
      charCode != 46 &&
      (charCode < 97 || charCode > 122) &&
      (charCode < 65 || charCode > 90) &&
      charCode != 39 &&
      charCode != 32) ||
    charCode == 37 ||
    charCode == 38
  ) {
    return false;
  }
  return true;
});
$(".isAlphaOnly").keypress(function (event) {
  // only alphabets without space and percentage sign
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    charCode != 8 &&
    charCode != 9 &&
    charCode != 46 &&
    (charCode < 97 || charCode > 122) &&
    (charCode < 65 || charCode > 90) &&
    charCode != 39
  ) {
    return false;
  }
  return true;
});
$(".isAlphaNumber").keypress(function (event) {
  // only alphanumeric
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    charCode != 8 &&
    charCode != 9 &&
    charCode != 46 &&
    charCode != 45 &&
    (charCode < 48 || charCode > 57) &&
    (charCode < 97 || charCode > 122) &&
    (charCode < 65 || charCode > 90) &&
    charCode != 39 &&
    charCode != 32
  ) {
    return false;
  }
  return true;
});
$(".isUppercase").keyup(function (event) {
  //lower to upper case
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    charCode != 8 &&
    charCode != 9 &&
    charCode != 46 &&
    (charCode < 97 || charCode > 122) &&
    (charCode < 65 || charCode > 90) &&
    charCode != 39 &&
    charCode != 37 &&
    charCode != 32
  ) {
    return false;
  }
  this.value = this.value.toUpperCase();
  return this.value;
});
$(".isDecimal").keypress(function (event) {
  //only float value with no % sign
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    charCode != 8 &&
    charCode != 9 &&
    (charCode < 48 || charCode > 57) &&
    charCode != 46 &&
    charCode != 39 &&
    charCode != 13
  ) {
    return false;
  }
  return true;
});
$(".specialNumChar").keypress(function (event) {
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  //alert(charCode);
  if (
    charCode != 8 &&
    (charCode < 97 || charCode > 122) &&
    (charCode < 48 || charCode > 57) &&
    (charCode < 65 || charCode > 90) &&
    charCode != 38 &&
    charCode != 46 &&
    charCode != 39 &&
    charCode != 32 &&
    charCode != 9 &&
    charCode != 13
  ) {
    return false;
  }
  return true;
});
$(".numberSpace").keypress(function (event) {
  // integer
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    (charCode != 8 &&
      charCode != 9 &&
      (charCode < 48 || charCode > 57) &&
      charCode != 32 &&
      charCode != 39 &&
      charCode != 37 &&
      charCode != 13) ||
    charCode == 37
  ) {
    return false;
  }
  return true;
});
$(".numberwithspl").keypress(function (event) {
  // integer
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    charCode != 8 &&
    charCode != 9 &&
    (charCode < 48 || charCode > 57) &&
    charCode != 46 &&
    charCode != 39 &&
    charCode != 13 &&
    charCode != 42
  ) {
    return false;
  }
  return true;
});
$(".isUcfirst").keyup(function (event) {
  //lower to upper case
  event = event ? event : window.event;
  var charCode = event.which ? event.which : event.keyCode;
  if (
    charCode != 8 &&
    charCode != 9 &&
    charCode != 46 &&
    (charCode < 97 || charCode > 122) &&
    (charCode < 65 || charCode > 90) &&
    charCode != 39 &&
    charCode != 37 &&
    charCode != 32
  ) {
    return false;
  }
  this.value =
    this.value.charAt(0).toUpperCase() + this.value.substr(1).toLowerCase();

  return this.value;
});
//
//$('.numberSpace').keyup(function () {
//     this.value = this.value.replace(/[^0-9\ ]/g, '');
//});
