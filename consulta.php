<?php
  require_once("banco/banco_listar.php");
  $pdo  = new PDO('mysql:host=localhost;dbname=farma', 'root', '');
  $stmt = $pdo->prepare('select nome,codigo from catmat order by nome');
  $stmt->execute();
  $resultUf = $stmt->fetchAll(PDO::FETCH_CLASS);
  $stmt->closeCursor();
?>

<script>
var remedios = new Array();
<?php foreach($resultUf as $uf){ ?>
  remedios.push('<?php echo(utf8_encode($uf->nome)); ?>');
<?php } ?>
</script>

<!DOCTYPE html>
<html>
<head>
 
    <title>ConsultaFarma</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"> 
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="js/autocomplete.js"></script>
    <script src="js/mapa.js"></script>
    <script src="js/modal.js"></script>



    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estiloAdicional.css">
    <link rel="shortcut icon" type="image/png" href="imgs/pills2.png"/>
    <link href="https://fonts.googleapis.com/css?family=Dosis:300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">

</head>
  <body id="page-top" data-spy="scroll" data-target=".navbar">

      <!--Navbar do site -->
      <nav class="navbar navbar-expand-lg navbar-light bg-nav-personalizado sticky-top">
        <a class="navbar-brand" href="index.html">
          <img src="imgs/farma.jpeg" width="105" height="55" alt="">
        </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
          </button>

        <div class="navbar-collapse collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link text-white" href="consulta.php">PESQUISAR<span class="sr-only">(Página atual)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link text-white" href="estatisticas.html">ESTATÍSTICAS<span class="sr-only">(Página atual)</span></a>
            </li> 
            <li class="nav-item active">
              <a class="nav-link text-white" href="faq.html">PERGUNTAS FREQUENTES<span class="sr-only">(Página atual)</span></a>
            </li>     
          </ul>
        </div>
      </nav>



      <!-- Header do site -->
      <header class="bg-white" id="head">
        <div class="jumbotron jumbotron-fluid bg-white">
          <div class="container-fluid">
            <h1 class="text-dark display-4 text-center">Consulta de Medicamentos</h1>
            <p class="lead text-dark text-center">Um sistema para consulta de remédios nas farmácias das Unidades Básicas de Saúde de Manaus.</p> 
            <div class="form-group col-12">
              <hr class="mt-6 mb-5">
            </div>
            <div class="row justify-content-md-center">
              <div class="largura-form-consulta">
                 <!-- Formulario de consulta de remedios -->
                <form autocomplete="off" action="consulta.php" method="POST">             
                  <div class="autocomplete form-group">
                    <label for="remedioUsuario">Nome do remédio: </label>
                    <input type="text" name="remedioUsuario" class="form-control" id="remedioUsuario" placeholder="Insira o nome do remédio aqui">
                    <input type="text" name="lat" id="input-lat" value="teste" hidden>
                    <input type="text" name="lon" id="input-lon" value="teste" hidden>

                  </div>
                  <button type="submit" class="btn btn-info form-control">Consultar disponibilidade</button>
                  <h5 class="lead text-muted small"><a href="faq.html">Meu medicamento não aparece na lista</a></h5>
                </form>
              </div>
            </div>
          </div>
        </div>
      </header>
      
      <!-- API Google Maps -->
      <?php
      if(isset($_POST['remedioUsuario'])){
        $listaRemedios = buscarRemedio($_POST['remedioUsuario'],$_POST['lat'],$_POST['lon']);
        if($listaRemedios!=null){
      ?>
          <section>
            <h1 class="text-dark display-4 text-center text-muted">Informações</h1>
            <hr class="mt-6 mb-5">
            <div class="row">
              <div class="col-md-6">
                <div class="row justify-content-md-center">    
                  <div id="mapa" style="height: 500px; width: 80%">
                      <!-- Maps API Javascript -->
                      <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBqC7N4pUFnbACf8lFrel_kY8SdIQh5qik&amp;sensor=false"></script>
              
                      <!-- Arquivo de inicialização do mapa -->
                      <script src="js/mapa.js"></script>
                  </div> 
                </div>
                <div class="container-fluid bg-light">
                  <a title="Compartilhar" href="https://api.whatsapp.com/send?text= Acabei de consultar a disponibilidade de um remédio do SUS de forma online e rápida ! Consulte você também: http://localhost/consultaFarma"><img src="imgs/wpp.png" width="80" height="70" /> Clique aqui para compartilhar este serviço</a>
                </div> 
              </div>

              <div class="col-md-6">
                <div class="container">

                  <p class="lead">Unidades Básicas de Saúde (UBS) mais próximas:</p>
                  <h5 class="lead text-muted small"><a href="faq.html">Como pegar um medicamento ?</a></h5>

                  <table class="table">
                    <thead>
                      <tr>          
                        <th scope="col">Nome</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Telefone</th>
                        <th class="text-center" scope="col">Localização</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $i=0;
                      foreach($listaRemedios as $ubs){ 
                        $i=$i+1;
                        if($i>10)break;
                        if( $ubs["telefone"]=="0") continue;?>
                        <tr>                
                          <td><?=$ubs["nome"]?></td>
                          <td><?=utf8_encode($ubs["endereco"])?></td>
                          <td><?=$ubs["telefone"]?></td>
                          <td class="text-center" >
                          <div>
                            <img src="imgs/maps.png" width ="30px" height="30px" alt="" onclick="marcarPonto(<?=$ubs["lat"]?>,<?=$ubs["lon"]?>);">
                          </div>
                          <div>
                            <p class="lead text-muted small"><?=number_format($ubs["distancia"], 2, ',', ' ');?> km</p>
                          </div>
                          </td>
                        </tr>
                        <?php }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </section>
        <?php }else{ ?>

        <!-- Informativo sobre a falta do remedio/ sugestao de notificacao -->
          <section class="feedback" id="feedback">
              <h1 class="text-dark display-4 text-center text-muted">Informações</h1>
              <hr class="mt-6 mb-5">
              <div class="row">
                <div class="col-lg-4 ml-auto text-center"></div>
                <div class="col-lg-4 ml-auto text-center">
                  <h3 class="lead font-weight-light text-justify">Infelizmente, este remédio <b>não encontra-se em estoque em nenhuma UBS neste momento</b>. Caso queira ser notificado sobre a reposição deste remédio, clique no botão abaixo.</h3>
                  <h6 class="text-muted">Caso queira saber mais sobre a falta de remédios, <a href="faq.html">clique aqui.</a>
                  </h6>
                </div>
                <div class="col-lg-4 ml-auto text-center"></div>
              </div>
              <p class="lead text-center">
                <a class="btn btn-info btn-lg" href="#" role="button" data-toggle="modal" data-target="#notificacaoModal" onclick="pegarRemedio()">Quero ser notificado!</a>
              </p>
          </section>
        <?php  }
        }
        ?>

      <!-- Modal para fornecimento de informacoes p/ notificacao -->
      <div class="modal fade" id="notificacaoModal" tabindex="-1" role="dialog" aria-labelledby="notificacaoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title lead" id="notificacaoModal">Ativar notificação</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="#" method="POST">
                <div class="form-group">
                  <table class="table">
                  <tbody>
                      <th>Remédio solicitado: <p><?=$_POST['remedioUsuario']?></p> </th>
                      <td id="reqUsuario"></td>
                    </tr>
                  </tbody>
                </table> 
                  <label for="emailLogin">Email ou número de celular:</label>
                  <input type="email" class="form-control" name="email" id="emailUsuario" aria-describedby="emailUsuario" placeholder="Insira seu email">
                </div>
                <div class="form-group">
                  <input type="number" class="form-control" id="telUsuario" placeholder="Insira seu número de celular">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" id="submitBtn" class="btn btn-info" onclick="alerta();">Ativar notificação</button>
                </div>
              </form>
            </div>       
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="bg-light py-5 ">
        <div class="container text-center">
           <div class="small text-center text-muted">Copyright © 2019 - FarmaOnline</div>
        </div>
      </footer>

  </body>
  
  <script>
      //Chamada de função para gerar lista de auto complete no campo de busca por remedio
      autocomplete(document.getElementById("remedioUsuario"), remedios);
      //Confirmacao de envio de sms/email para usuario
      function alerta() {
      }
  </script>
  <script src="localizacao.js"></script>

</html>
<?php
  unset($pdo);
?>


 