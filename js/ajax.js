function ajaxConnect() {
  if (arguments[0] == "") {
    arguments[0] = 0;
  }
  if (arguments[1] == "") {
    arguments[1] = 0;
  }
  if (arguments[2] == "") {
    arguments[2] = 0;
  }
  var monto = arguments[3];
  monto = hacerNumeroPorqueJSnoPuede(monto);
  var per = $('input[name=Periodicidad]:checked').val();
  var plazo = $('select[name="years"]').val();
  $.ajax({
    type: 'GET',
    url: 'http://localhost/Chocorramo/Servidor/Controlador.php?',
    data: {
      'EfectivoAnual': arguments[0],
      'NominalAnual': arguments[1],
      'PeriodicoVencido': arguments[2],
      'Periodicidad': per,
      'Plazo': plazo,
      'Monto': monto
    },
    success: function(msg) {
      $("#r").html(msg);
      var cosatanrebuscada = msg.split("<p hidden>");
      var myObj = JSON.parse(cosatanrebuscada[1]);
      $("#n1").val(myObj.EA.substring(0, (myObj.EA.indexOf(".") + 3)));
      $("#n2").val(myObj.NA.substring(0, (myObj.NA.indexOf(".") + 3)));
      $("#n3").val(myObj.PV.substring(0, (myObj.PV.indexOf(".") + 3)));
    }
  });
}

function ajaxConnect2() {
  var table = document.getElementById('tabla');
  var fechaCuota = table.rows[(parseInt(arguments[0]) + 1)].cells[1].innerHTML;
  var separar = fechaCuota.split("/");
  fechaCuota = separar[2] + "-" + separar[1] + "-" + separar[0];
  var saldo = table.rows[parseInt(arguments[0])].cells[2].innerHTML;
  saldo = hacerNumeroPorqueJSnoPuede(saldo);
  var CuotaFija = table.rows[2].cells[3].innerHTML;
  CuotaFija = hacerNumeroPorqueJSnoPuede(CuotaFija);
  $.ajax({
    type: 'GET',
    url: 'http://localhost/Chocorramo/Servidor/Controlador.php?',
    data: {
      'NumCuota': arguments[0],
      'Fecha': arguments[1],
      'FechaCuota': fechaCuota,
      'Saldo': saldo,
      'CuotaFija' : CuotaFija
    },
    success: function(msg) {
      $("#respuestaMora").html(msg);
    }
  });

}

function hacerNumeroPorqueJSnoPuede(){
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
