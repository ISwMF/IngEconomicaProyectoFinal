$(document).ready(function() {
  $("#monto").on("change keyup paste", function() {
    var monto = $("#monto").val();
    var monto = hacerNumeroPorqueJSnoPuede(monto);
    var resultado;
    switch (monto.length) {
      case 4:
        resultado = splitValue(monto, 1);
        break;
      case 5:
        resultado = splitValue(monto, 2);
        break;
      case 6:
        resultado = splitValue(monto, 3);
        break;
      case 7:
        resultado = splitValue(monto, 1);
        resultado = splitValue(resultado, 5);
        break;
      case 8:
        resultado = splitValue(monto, 2);
        resultado = splitValue(resultado, 6);
        break;
      case 9:
        resultado = splitValue(monto, 3);
        resultado = splitValue(resultado, 7);
        break;
      case 10:
        resultado = splitValue(monto, 1);
        resultado = splitValue(resultado, 5);
        resultado = splitValue(resultado, 9);
        break;
      case 11:
        resultado = splitValue(monto, 2);
        resultado = splitValue(resultado, 6);
        resultado = splitValue(resultado, 10);
        break;
      case 12:
        resultado = splitValue(monto, 3);
        resultado = splitValue(resultado, 7);
        resultado = splitValue(resultado, 11);
        break;
      default:
        resultado = monto;
    }
    $('#monto').val(resultado);
  });
});

function splitValue(value, index) {
  return value.substring(0, index) + "." + value.substring(index);
}

function hacerNumeroPorqueJSnoPuede() {
  numero = arguments[0];
  var respuesta = "";
  for (var i = 0; i < numero.length; i++) {
    if (numero[i] >= '0' && numero[i] <= '9') {
      respuesta = respuesta + numero[i];
    } else if (numero[i] == ',') {
      respuesta = respuesta + ".";
    }
  }
  return respuesta;
}
