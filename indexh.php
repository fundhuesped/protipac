        <header>
        	<div class="container-fluid color_topheader">
            	<div class="row fondo_topheader">
                	<div class="col-md-4 col-lg-4 hidden-sm hidden-xs"></div>
                	<!--<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 container-registrarse">-->
                    <div class="col-md-1 col-lg-1 hidden-xs col-sm-1 espacio_40right"></div>
                	<div class="col-md-3 col-lg-3 col-sm-5 col-xs-12 container-registrarse">
                    	<div class="row">
                            <?php if(!seguridadFuncion("LOGINPUBLICO")){
		                		echo('<div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 container-link-topheader"><a href="login.php" title="Ingresar" data-toggle="tooltip" data-placement="bottom" class="link_topheader fondo_registrarse">Ingresar</a></div>');
							} else {
		                		echo('<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 container-link-topheader-login"><a href="registro.php" title="Perfil del usuario" data-toggle="tooltip" data-placement="bottom" class="link_topheader"><i class="fa fa-user fa-2x" aria-hidden="true"></i>&nbsp;'.fullUpper($_SESSION['usu_lastname']).', '.$_SESSION['usu_name'].'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="logout.php" title="Cerrar Sesión" data-toggle="tooltip" data-placement="bottom" class="link_topheader"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a></div>');
							}?>
                        </div>
                    </div>
                	<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 container-links-home">


                    </div>
					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Contacto</h4>
						  </div>
						  <div class="modal-body">
							<p>Florencio varela<br />
							<a href="mailto:">mail</a><br />
							+54 9 11 565656565</p>
							</div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						  </div>
						</div>

					  </div>
					</div>

                </div>
            </div>
            <div class="container-fluid">
                <nav class="navbar navbar-default">
					<div class="row blanco">
	                    <a href="/index.php">
	                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 logo">
                        	<div class="row">                          
			                    <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1 espacio_40left"></div>
                            	<div class="col-xs-10 col-md-5 col-sm-3 col-lg-2">
			    	                <img src="images/logo_fh.png" class="logo img-responsive"/>
                                </div>
                            	<div class="col-xs-6 col-md-7 col-sm-8 col-lg-9 mt-20">
										<span class="registro">Protipac v2</span>

                                </div>
                            </div>
                        </div>
                        </a>
                    	


                    </div>
                </nav>
            </div>
        </header>
