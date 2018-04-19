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
  var per = $('input[name=Periodicidad]:checked').val();
  var plazo = $('select[name="years"]').val();
  $.ajax({
    type: 'GET',
    url: 'http://localhost/Chocorramo/Controlador.php?',
    data: {
      'EfectivoAnual': arguments[0],
      'NominalAnual': arguments[1],
      'PeriodicoVencido': arguments[2],
      'Periodicidad': per,
      'Plazo': plazo,
      'Monto':arguments[3]
    },
    success: function(msg) {
      $("#r").html(msg);
      var cosatanrebuscada = msg.split("<p hidden>");
      var myObj = JSON.parse(cosatanrebuscada[1]);
      $("#n1").val(myObj.EA);
      $("#n2").val(myObj.NA);
      $("#n3").val(myObj.PV);
    }
  });
}
