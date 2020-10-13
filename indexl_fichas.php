<link href="css/circle.css" rel="stylesheet">
<script src="includes/jquery.classyloader.min.js" type="text/javascript" charset="utf-8"></script>
                <div class="sidebar col-lg-2 col-md-2 col-sm-2 col-xs-12">               
                	<div class="row">
                     <ul class="list-group menu-perfil">
	                  <li class="list-group-item <?=$formulario=="agenda" ? "active" : ""?>"><a href="javascript:validarFormulario('agenda.php',1)" class="">Agenda</a></li>
	                  <li class="list-group-item <?=$formulario=="protocolos" ? "active" : ""?>"><a href="javascript:validarFormulario('protocolos.php',1)" class="">Protocolos</a></li>
                      <li class="list-group-item <?=$formulario=="pacientes" ? "active" : ""?>"><a href="javascript:validarFormulario('pacientes.php',1)" class="">Pacientes</a></li>
                    </ul>
                    </div>
                </div>
