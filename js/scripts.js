var tablesdata = [
  '#dataTable'
];

$.each(tablesdata, function(index,value){
  $(value).DataTable({
    "oLanguage": {
      "sLengthMenu": "Mostrar _MENU_ registros por página",
      "sZeroRecords": "Nenhum registro encontrado",
      "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
      "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
      "sInfoFiltered": "(filtrado de _MAX_ registros)",
      "sSearch": "Pesquisar: ",
      "oPaginate": {
        "sFirst": "Início",
        "sPrevious": "Anterior",
        "sNext": "Próximo",
        "sLast": "Último"
      }
    },
    "pageLength": 30,
    // "stateSave" : true,
    "dom" : '<"top"iflp<"clear">>rt<"bottom"ip<"clear">>'
  });
});
// ======================================
// excluir usuarios
$(document).ready(function() {

    $(".btnDelUser").on("click", function(e) {
       const target = e.currentTarget;

       var a = confirm("Certeza que deseja excluir este item?");

       if(a == true){

        // $("#logar").prop('disabled', true);
        let cd = $(target).data("cd");
        let acao = $(target).data("acao");
       
        $("body").addClass("loading");
        // sleep(2000);
        $.post(
          "Controller/Usuarios.php",
          {cd: cd, acao: acao}, 
        ).done(function (data) {
    
          $("body").removeClass("loading");   
    
          $("#result").html(data);
        }).fail(function () {
          alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
        });
      }
    });
  
// =============================
// excluir material
$(".btnDelMaterial").on("click", function(e) {
  const target = e.currentTarget;

  var a = confirm("Certeza que deseja excluir este item?");

  if(a == true){

   // $("#logar").prop('disabled', true);
   let cd = $(target).data("cd");
   let acao = $(target).data("acao");
  
   $("body").addClass("loading");
   // sleep(2000);
   $.post(
     "Controller/Materiais.php",
     {cd: cd, acao: acao}, 
   ).done(function (data) {

     $("body").removeClass("loading");   

     $("#result").html(data);
   }).fail(function () {
     alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
   });
 }
});
// =============================
// excluir estoque
    $(".btnDelEstoque").on("click", function(e) {
       const target = e.currentTarget;

       let result = $(target).data("cd");

       $(".hiddencd").val(result);
       
    })

    $(".btn-submit").on("click", function(e) {

        e.preventDefault();

        const formulario = document.querySelector(".form"); //class formulario

        var combinedFormData = $(formulario).serialize();
        console.log(combinedFormData);
           $.post(
             "Controller/Estoque.php",
             combinedFormData
           ).done(function (data) {
               if(data === "true") {
                   $('#modalDelEstoque').modal('hide');
                   Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'Item excluído com sucesso!',
                       showConfirmButton: false,
                       timer: 1500
                   }).then((result)=>{
                       window.location.reload();
                   })
               }
             console.log(data)
             $("#result").html(data);
           }).fail(function () {
           });
    });

// =============================
// excluir seção
$(".btnDelSecao").on("click", function(e) {
  const target = e.currentTarget;

  var a = confirm("Certeza que deseja excluir este item?");

  if(a == true){

   // $("#logar").prop('disabled', true);
   let cd = $(target).data("cd");
   let acao = $(target).data("acao");
  
   $("body").addClass("loading");
   // sleep(2000);
   $.post(
     "Controller/Secao.php",
     {cd: cd, acao: acao}, 
   ).done(function (data) {
     $("#logar").show();
     $("#logando").hide()

     $("body").removeClass("loading");   

     $("#result").html(data);
   }).fail(function () {
     alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
   });
 }
});
// =============================
//cadastrar equipamentos
$("#btnCadEquipamento").click(function (e) {
  e.preventDefault();

    $("#btnCadEquipamento").hide();
    $("#gravandoEquipamento").show();

    var combinedFormData = $("#formCadEquipamento").serialize();
    // alert(combinedFormData);
    $("body").addClass("loading");
    
    $.post(
      "Controller/Equipamentos.php",
      combinedFormData
    ).done(function (data) {
      $("#btnCadEquipamento").show();
      $("#gravandoEquipamento").hide();

      $("body").removeClass("loading");

      $("#result").html(data);
    }).fail(function () {
      alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
    });
});

// =============================
// excluir equipamento
$(".btnDelEquipamento").on("click", function(e) {
  const target = e.currentTarget;

  var a = confirm("Certeza que deseja excluir este item?");

  if(a == true){

   // $("#logar").prop('disabled', true);
   let cd = $(target).data("cd");
   let acao = $(target).data("acao");
  
   $("body").addClass("loading");
   // sleep(2000);
   $.post(
     "Controller/Equipamentos.php",
     {cd: cd, acao: acao}, 
   ).done(function (data) {

     $("body").removeClass("loading");   

     $("#result").html(data);
   }).fail(function () {
     alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
   });
 }
});

// =============================
// excluir incidente
$(".btnDelIncidente").on("click", function(e) {
  const target = e.currentTarget;

  var a = confirm("Certeza que deseja excluir este item?");

  if(a == true){

   // $("#logar").prop('disabled', true);
   let cd = $(target).data("cd");
   let acao = $(target).data("acao");
  
   console.log(cd);
   console.log(acao);
   $("body").addClass("loading");
   // sleep(2000);
   $.post(
     "Controller/Incidentes.php",
     {cd: cd, acao: acao}, 
   ).done(function (data) {

     $("body").removeClass("loading");   

     $("#result").html(data);
   }).fail(function () {
     alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
   });
 }
});

 // ===========================
//cadastrar usuário
  $("#btnCadUsuarios").click(function (e) {
    e.preventDefault();

      $("#btnCadUsuarios").hide();
      $("#gravandoUser").show();

      var combinedFormData = $("#formCadUsuarios").serialize();
      $("body").addClass("loading");
      
      $.post(
        "Controller/Usuarios.php",
        combinedFormData
      ).done(function (data) {
        $("#btnCadUsuarios").show();
        $("#gravandoUser").hide();

        $("body").removeClass("loading");

        $("#result").html(data);
      }).fail(function () {
        alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
      });
  });
// ==================================
//editar usuário
$("#btnEditUser").click(function (e) {
  e.preventDefault();
    $("#btnEditUser").hide();
    $("#editandoUser").show();

    var combinedFormData = $("#formEditUser").serialize();
    
    $("body").addClass("loading");

    $.post(
      "Controller/Usuarios.php",
      combinedFormData
    ).done(function (data) {
      $("#btnEditUser").show();
      $("#editandoUser").hide();

      $("body").removeClass("loading");

      $("#result").html(data);
    }).fail(function () {
      alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
    });
});
// ==================================
//cadastrar secao
  $("#cadSecao").click(function (e) {
    e.preventDefault(e);
   
      $("#cadSecao").hide();
      $("#gravandoSecao").show();
      var combinedFormData = $("#formCadSecao").serialize();
       // console.log(combinedFormData);
      $("body").addClass("loading");
      // sleep(2000);
      // console.log(combinedFormData);
      $.post(
        "Controller/Secao.php",
        combinedFormData
      ).done(function (data) {
        $("#cadSecao").show();
        $("#gravandoSecao").hide();

        $("body").removeClass("loading");  

        $("#result").html(data);
      }).fail(function () {
        alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
      });
  });
// ==================================
//cadastrar incidente
$("#btnCadIncidente").click(function (e) {
  e.preventDefault(e);
    $("#btnCadIncidente").hide();
    $("#gravandoIncidente").show();
    var combinedFormData = $("#formCadIncidente").serialize();
     // console.log(combinedFormData);
    // alert(combinedFormData);

    $("body").addClass("loading");
    // sleep(2000);
    // console.log(combinedFormData);
    $.post(
      "Controller/Incidentes.php",
      combinedFormData
    ).done(function (data) {
      $("#btnCadIncidente").show();
      $("#gravandoIncidente").hide();

      $("body").removeClass("loading");  

      $("#result").html(data);
    }).fail(function () {
      alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
    });
});
// ==================================
//editar incidente
$("#btnEditIncidente").click(function (e) {
  e.preventDefault(e);
    $("#btnEditIncidente").hide();
    $("#editandoIncidente").show();
    var combinedFormData = $("#formEditIncidente").serialize();
     // console.log(combinedFormData);
    // alert(combinedFormData);

    $("body").addClass("loading");
    // sleep(2000);
    // console.log(combinedFormData);
    $.post(
      "Controller/Incidentes.php",
      combinedFormData
    ).done(function (data) {
      $("#btnEditIncidente").show();
      $("#editandoIncidente").hide();

      $("body").removeClass("loading");  

      $("#result").html(data);
    }).fail(function () {
      alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
    });
});
// ==================================
  //editar chamado
  $("#editSecao").click(function (e) {
    e.preventDefault(e);
   
      $("#editSecao").hide();
      $("#editandoSecao").show();
      var combinedFormData = $("#formEditSecao").serialize();
       // console.log(combinedFormData);
      $("body").addClass("loading"); //não ta funcionando
      // sleep(2000);
      // console.log(combinedFormData);
      $.post(
        "Controller/Secao.php",
        combinedFormData
      ).done(function (data) {
        $("#editSecao").show();
        $("#editandoSecao").hide();

        $("body").removeClass("loading");   //não ta funcionando

        $("#result").html(data);
      }).fail(function () {
        alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
      });
  });
// =====================================
// on.submit, usado com o plugin form jquery
$('#formCadChamado').on('submit', function (e) {
  e.preventDefault();
  // Armazenando objetos em variáveis para utilizá-los posteriormente
  var formulario = $(this);
  // alert(formulario);
  $("#btnCadChamados").hide();
  $("#gravandoChamado").show();   

  $("body").addClass("loading"); 
  
  // Enviando formulário
  $(this).ajaxSubmit({
      url: 'Controller/Chamados.php',
      type: 'post',
      // Definindo tipo de retorno do servidor
      // dataType: 'json',
      // Se a requisição foi um sucesso
      success: function (data) {
        // alert('pp');
          // Se cadastrado com sucesso
          $("#btnCadChamados").show();
          $("#gravandoChamado").hide();
  
          $("body").removeClass("loading"); 
  
          $("#result").html(data);
      },
      // Se houver algum erro na requisição
      error: function () {
          // Definindo estilo da mensagem (erro)
        alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
      }
  });
  // Retorna FALSE para que o formulário não seja enviado de forma convencional
  return false;
});
// =====================================
// on.submit, usado com o plugin form jquery
$('#formEditChamado').on('submit', function (e) {
  e.preventDefault();
  // Armazenando objetos em variáveis para utilizá-los posteriormente
  var formulario = $(this);
  // alert(formulario);
  $("#editChamado").hide();
  $("#editandoChamado").show();   

  $("body").addClass("loading"); 
  
  // Enviando formulário
  $(this).ajaxSubmit({
      url: 'Controller/Chamados.php',
      type: 'post',
      // Definindo tipo de retorno do servidor
      // dataType: 'json',
      // Se a requisição foi um sucesso
      success: function (data) {
        // alert('pp');
          // Se cadastrado com sucesso
          $("#editChamado").show();
          $("#editandoChamado").hide();
  
          $("body").removeClass("loading"); 
  
          $("#result").html(data);
      },
      // Se houver algum erro na requisição
      error: function () {
          // Definindo estilo da mensagem (erro)
        alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
      }
  });
  // Retorna FALSE para que o formulário não seja enviado de forma convencional
  return false;
});
// =====================================

// =======================================
}); //fim do carregamento document
// ================================
//select2
$("#postograd").select2({
  theme:"bootstrap"
});
$("#secao").select2({
  theme:"bootstrap"
});
$("#cadmaterial").select2({
  theme:"bootstrap"
});
$("#editmaterial").select2({
  theme:"bootstrap"
});
$("#id_incidente").select2({
  theme:"bootstrap"
});
$("#prioridade").select2({
  theme:"bootstrap"
});
$("#status").select2({
  theme:"bootstrap"
});
$("#tecnico").select2({
  theme:"bootstrap"
});
$("#id_equipamento").select2({
  theme:"bootstrap"
});
$("#id_estoque").select2({
  theme:"bootstrap"
});
$("#open_by").select2({
  theme:"bootstrap"
});
// ================================ fim do select2
//notificacao conta chamados novos
function countChamadodNovos() {
  var url="Notify/count-novos-chamados.php";
   jQuery("#countChamadodNovos").load(url);
}
setInterval("countChamadodNovos()", 1000);
// ======================================
// notificacao lista chamados novos
function listChamadosNovos() {
  var url="Notify/list-chamados-novos.php";
   jQuery("#listChamadosNovos").load(url);
}
setInterval("listChamadosNovos()", 1000);
// ======================================
//notificacao conta novas msgns
function countNewMessages() {
  var url="Notify/count-new-messages.php";
   jQuery("#countNewMessages").load(url);
}
setInterval("countNewMessages()", 1000);
// =======================================
//notificacao lista novas msgns
function listAllMessages() {
  var url="Notify/list-all-messages.php";
   jQuery("#listAllMessages").load(url);
}
setInterval("listAllMessages()", 1000);
// ========================================
//atualizar chamados abertos hoje
function countChamadosAbertosHoje() {
  var url="Notify/count-chamados-abertos-hoje.php";
   jQuery("#countChamadosAbertosHoje").load(url);
}
setInterval("countChamadosAbertosHoje()", 1000);
// ========================================
//atualizar chamados pendentes
function countChamadosPendentes() {
  var url="Notify/count-chamados-pendentes.php";
   jQuery("#countChamadosPendentes").load(url);
}
setInterval("countChamadosPendentes()", 1000);
// =========================================
//atualizar aguardando resposta do usuario
function countAguardandoRespostaUsuario() {
  var url="Notify/count-aguardando-resposta-usuario.php";
   jQuery("#countAguardandoRespostaUsuario").load(url);
}
setInterval("countAguardandoRespostaUsuario()", 1000);
// ==========================================
//atualizar chamados resolvidos hoje
function countResolvidosHoje() {
  var url="Notify/count-resolvidos-hoje.php";
   jQuery("#countResolvidosHoje").load(url);
}
setInterval("countResolvidosHoje()", 1000);
// ==========================================
//logar
$("#logar").click(function (e) {
  e.preventDefault(e);

    $("#logar").hide();
    $("#logando").show();
    // $("#logar").prop('disabled', true);
    var combinedFormData = $("#formLogin").serialize();
    // console.log(combinedFormData);
    $("body").addClass("loading");
    // sleep(2000);
    $.post(
      "Controller/Login.php",
      combinedFormData
    ).done(function (data) {
      $("#logar").show();
      $("#logando").hide()

      $("body").removeClass("loading");   

      $("#result").html(data);
    }).fail(function () {
      alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
    });
});
// ================================================
// incidentes IP
$(document).ready(function() {
  $('#dataTable tbody').on('click', 'tr td label input.ip-required', function () {
    var data = $(this);

    var cd = $(data).data("cd");
    var name = $(data).data("name");

    if($(data).is(":checked")){
      value=1;
    }else{
      value=0;
    }

    $.post(
      "Controller/Incidentes.php",
      {name: name, value: value, cd: cd}
    ).done(function (data) {

      $("#result").html(data);
    }).fail(function () {
      alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
    }); 
  } );
} );
// ================================================
// incidentes Equipamento
$(document).ready(function() {
  $('#dataTable tbody').on('click', 'tr td label input.equipamento-required', function () {
    var data = $(this);

    var cd = $(data).data("cd");
    var name = $(data).data("name");

    if($(data).is(":checked")){
      value=1;
    }else{
      value=0;
    }

    $.post(
      "Controller/Incidentes.php",
      {name: name, value: value, cd: cd}
    ).done(function (data) {

      $("#result").html(data);
    }).fail(function () {
      alert("Erro de comunicação com o servidor. Tente novamente mais tarde!!!")
    }); 
  } );
} );
// ================================================
$(document).ready(function () {
  
  var estado = $('#id_incidente');

  estado.change(function () {
    var cd = estado.val();    
    // var incidente = "incidente";
   var a = $(estado).find(':selected').data("ip")

   if(a == 0) {
    var b = document.getElementById("row-ip");
    b.style.setProperty('display', 'none');
   } else{
    var b = document.getElementById("row-ip");
    b.style.setProperty('display', 'block');

    c = document.getElementById("ip");
    c.required = true;
   }   
  //  console.log(a);
  //  console.log(cd);

  });
});
// ================================================
// aumentar as imagens das msngs
function aumentaImagem(nome){
	nome.width = nome.width+400;
	nome.height = nome.height+300;			
}

function tamanhoNormal(nome){
	nome.width = 320;
	nome.height = 205;			
}
// ================================================
// popular placeholder com dicas do incidente nos chamados
$(document).ready(function () {
  $("select[name='id_incidente']").change(function (){
   
   var a = $('option:selected', this).attr('dica'); //pega o atributo dica da otion incidente

   var b = document.getElementById('descricao').placeholder=a; //preenche o placeholder com a dica cadastrada para o incidente
  });
});
// ==================================================
$(function(){

  function createDivFields(){

      /*

       Criamos a variavel, e atribuimos os campos que serão criados;

       Utilizamos o colchetes nos nomes do campos para informar que os dados

       em forma de array;

       Adiciona uma div, para que nela seja criado novos campos extras;

       E um link para para chamar o evento de adicionar;

      */

       var teste = '<div class="form-group">';
        teste += '<label for="id_estoque">Material usado</label>';
        teste += '<select class="form-control select2" name="id_estoque" id="id_estoque" style="width: 100%;">';
        teste += '<option>Inserir item de estoque no chamado</option>';        
        teste += '</select>';
        teste += '<small style="color: blue;">Alertar se foi usado algum material nesse chamado</small>';
        teste += '</div>';
        return teste;

      // var html  = '<div class="items">';

      //     html += '<label>Material usado <input type="text" name="telefone[]" /></label>';

      //     // html += '<a href="#" class="addTel">Add Telefone</a>';

      //     html += '<div class="item"></div>';

      //     html += '<div>';

      //     return html;
  }

  //Cria a função para adicionar os campos extras de telefone

  // function createFieldTel(num){

  //     /*

  //      Repare que é informado que terá um parametro;

  //      Será por ele iremos identificar de quem pertence esses campos;

  //     */

  //     var tel  = '<label> Telefone :';

  //         tel += '<input type="text" name="telExtra['+num+'][]" />';

  //         tel += '</label><br />';

  //         return tel;

  // }

  //cria uma função para conta os campos criados

  function getTotalItems(){

      //Contamos o total de campos, e diminuimos 1

      //Porque o array é iniciado seu indice com 0

      return $(".items").length - 1;
  }

  //Adiciona os nome e telefone

  $("#add").click(function(){

      //Adicionado no final do elemento ( #boxFields) os campos

      $("#boxFields").append(createDivFields());

      return false;

  });

  //Adiciona os campos extras

  // $(".addTel").live('click', function(){

  //     /*

  //         Utilizamos Live para atribui o evento click ao link addTel

  //         Isso porque como criamos dinamicamente esse elemento

  //         ele ainda não está no DOM, quando o jQuery vai executar

  //     */


  //     //Chamamos o contador

  //     var total = getTotalItems();


  //     //Voltamos um elemento (parent);

  //     //e depois buscamos .item, informando que precisa ser o primeiro encontrado

  //     //Adiciona no final do elemento (.item) os novos campos


  //     $(this).parent().children('.item:first').append(createFieldTel(total));


  //     return false;

  // });


});