
function mostrarCapa(varNombre, varActivador, varNumMostrar){
	for(i=1;i<=cant_capas;i++){
		if(i!=varNumMostrar){
			//ocultar capa
			$("#"+varActivador+i).removeClass("fondoGrisOscuro");
			$("#"+varActivador+i).addClass("fondoGrisClaro");
			$("#"+varNombre+i).css("visibility", "hidden");
			$("#"+varNombre+i).css("display", "none");
		}
	}
	$("#"+varActivador+varNumMostrar).removeClass("fondoGrisClaro");
	$("#"+varActivador+varNumMostrar).addClass("fondoGrisOscuro");
	$("#"+varNombre+varNumMostrar).css("visibility", "visible");
	$("#"+varNombre+varNumMostrar).css("display", "block");

}

function validarNumeros(varCampo){
	$(varCampo).keyup(function() {  
	  var sanitized = $(this).val().replace(/[^0-9]/g, '');
	  $(this).val(sanitized);
	});	
}
function configurarEstilos()
{
	$('input').each(function() {
		if($(this).val().length>0){
			$(this).removeClass("campoVacio");
			$(this).addClass("campoLleno");
		}
	});
	$('select').each(function() {
		if($(this)[0].selectedIndex>0){
			$(this).removeClass("campoVacio");
			$(this).addClass("campoLleno");
		}
	});
	$('input').change(function() {
		if($(this).val()!=""){
			$(this).removeClass("campoVacio");
			$(this).addClass("campoLleno");
		} else {
			$(this).removeClass("campoLleno");
			$(this).addClass("campoVacio");
		}
	});	
}
function cargarOpcionesNormasPosee(varWrapper, varActual, varNombreCertificada, varNombrePorcentaje, varNombreNorma, varContenedor, varQuitar, varValorPorcentaje, varValorNorma, varValorCertificada){	
	var wrapper         = $(varWrapper); 
	$(varWrapper+' > tbody:last-child').append('<tr id="'+varContenedor+(window[varActual]+1)+'">'
									+'<td>'
									+'<input type="text" name="'+varNombreNorma+'[]" value="'+varValorNorma+'" class="form-control" />'
									+'</td>'
									+'<td>'
									+'<input type="radio"  name="'+varNombreCertificada+'_'+(window[varActual]+1)+'" value="true" '+(varValorCertificada==1 ? "checked" : "")+' onChange="cambiarPorcentaje(\'porcentaje_'+(window[varActual]+1)+'\',1)" />&nbsp;<label>S&iacute;</label>&nbsp;<input type="radio" name="'+varNombreCertificada+'_'+(window[varActual]+1)+'" value="false" '+(varValorCertificada==0 && varValorCertificada!=null ? "checked" : "")+' onChange="cambiarPorcentaje(\'porcentaje_'+(window[varActual]+1)+'\',0)" />&nbsp;<label>No</label>'
									+'<input type="hidden" name="norma[]" value="'+(window[varActual]+1)+'">'
									+'</td>'
									+'<td>'
									+'<input type="text" name="'+varNombrePorcentaje+'[]" value="'+varValorPorcentaje+'" '+(varValorCertificada==1 ? "readonly=\"readonly\"" : "")+' id="porcentaje_'+(window[varActual]+1)+'" placeholder="Ingrese el porcentaje" class="form-control" data-a-dec="," data-a-sep="." data-a-sign="" data-v-min="0" data-v-max="100" />'
									+'</td>'
									+'<td>'
									+'<a href="javascript:removerElemento(\''+varContenedor+(window[varActual]+1)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a>'
									+'</td>'
								
	);		
	window[varActual]++;
}

function agregarOpcionesNormasPosee(varMax_fields, varWrapper, varActual, varNombreCertificada, varNombrePorcentaje, varNombreNorma, varContenedor){	
	var max_fields      = varMax_fields; 
	//var wrapper         = $(varWrapper); 
	if(eval(varActual) < max_fields){ 
			//$(wrapper+' tr:last').after('<tr id="'+varContenedor+(window[varActual]+1)+'">'
			$(varWrapper+' > tbody:last-child').append('<tr id="'+varContenedor+(window[varActual]+1)+'">'
											+'<td>'
											+'<input type="text" name="'+varNombreNorma+'[]" value="" class="form-control" />'
											+'</td>'
											+'<td>'
											+'<input type="radio"  name="'+varNombreCertificada+'_'+(window[varActual]+1)+'" value="true" onChange="cambiarPorcentaje(\'porcentaje_'+(window[varActual]+1)+'\',1)" />&nbsp;<label>S&iacute;</label>&nbsp;<input type="radio" name="'+varNombreCertificada+'_'+(window[varActual]+1)+'" value="false" onChange="cambiarPorcentaje(\'porcentaje_'+(window[varActual]+1)+'\',0)" />&nbsp;<label>No</label>'
											+'</td>'
											+'<td>'
											+'<input type="text" name="'+varNombrePorcentaje+'[]" value="" id="porcentaje_'+(window[varActual]+1)+'" placeholder="Ingrese el porcentaje" class="form-control" data-a-dec="," data-a-sep="." data-a-sign="" data-v-min="0" data-v-max="100" />'
											+'</td>'
											+'<td>'
											+'<a href="javascript:removerElemento(\''+varContenedor+(window[varActual]+1)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a>'
											+'</td>'

										
			);
			$('#porcentaje_'+(window[varActual]+1)).autoNumeric('init');
			window[varActual]++;
	}
}
function removerElemento(varElemento, varActual){
	$("#"+varElemento).remove(); 
	window[varActual]--;
}

function cargarOpcionesSelect(varWrapper, varNombre, varValor, varId, varActual){	
	var wrapper         = $(varWrapper); 
	if(varId=="0"){
		$(wrapper).append('<div><input type="hidden" id="'+varNombre+'_'+eval(varActual)+'" name="'+varNombre+'[]" value="'+varValor+'" /> '+varValor+' <a href="javascript:removerOpcionesSelect(\''+varNombre+'_'+eval(varActual)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a></div>');		
	} else {
		$(wrapper).append('<div><input type="hidden" id="'+varNombre+'_'+eval(varActual)+'" name="'+varNombre+'[]" value="'+varId+'" /> '+varValor+' <a href="javascript:removerOpcionesSelect(\''+varNombre+'_'+eval(varActual)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a></div>');
	}
	window[varActual]++;
}
function cargarOpcionesSelectRo(varWrapper, varNombre, varValor, varId, varActual){	
	var wrapper         = $(varWrapper); 
	if(varId=="0"){
		$(wrapper).append('<div><input type="hidden" id="'+varNombre+'_'+eval(varActual)+'" name="'+varNombre+'[]" value="'+varValor+'" /> '+varValor+'</div>');		
	} else {
		$(wrapper).append('<div><input type="hidden" id="'+varNombre+'_'+eval(varActual)+'" name="'+varNombre+'[]" value="'+varId+'" /> '+varValor+'</div>');
	}
	window[varActual]++;
}

function cargarOpcionesRazonSocialCuit(varWrapper, varNombreCuit, varNombreRazonSocial, varActual, varValorCuit, varValorRazonSocial){	
	var wrapper         = $(varWrapper);
	var varCuitCargar	= varValorCuit;
	if(varValorCuit=="0"){
		varCuitCargar	= "";
	}
	$(wrapper).append('<div><input type="hidden" id="'+varNombreCuit+'_'+eval(varActual)+'" name="'+varNombreCuit+'[]" value="'+varValorCuit+'" /><input type="hidden" id="'+varNombreRazonSocial+'_'+eval(varActual)+'" name="'+varNombreRazonSocial+'[]" value="'+varValorRazonSocial+'" /> '+varValorRazonSocial+'  '+varCuitCargar+' <a href="javascript:removerOpcionesRazonSocialCuit(\''+varNombreRazonSocial+'_'+eval(varActual)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a></div>');
	window[varActual]++;
}

function cargarOpcionesEmbarque(varWrapper, varActual, varNombreFecha,varValorFecha,varTipoRegistro, varNombreCantidad, varValorCantidad){	
	var wrapper         = $(varWrapper);
	var tabla			= "";

	//$(wrapper).append('<div id="'+varActual+'_'+eval(varActual)+'"></div>');
	tabla+='<tr>';
	if(varNombreFecha!=""){
		tabla+='<td><input type="hidden" id="'+varNombreFecha+'_'+eval(varActual)+'" name="'+varNombreFecha+'[]" value="'+varValorFecha+'" />'+varValorFecha+'&nbsp;</td>';
	}
	if(varNombreCantidad!=""){
		tabla+='<td><input type="hidden" id="'+varNombreCantidad+'_'+eval(varActual)+'" name="'+varNombreCantidad+'[]" value="'+varValorCantidad+'" />'+varValorCantidad+'&nbsp;</td>';
	}
	if(varTipoRegistro=="embarque_compra"){
		tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesEmbarque_'+(eval[varActual])+'\',\'cant_embarques\')" id="quitarOpcionesEmbarque_'+(eval[varActual])+'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
	}

	tabla+='</tr>';
	$(varWrapper+ " table").append(tabla);
	window[varActual]++;
	$(varWrapper).show();
}

function cargarOpcionesProveedor(varWrapper, varActual, varNombreRazonSocial, varNombreOrigen, varNombreTipo, varNombreDescripcion, varNombreEmail, varValorRazonSocial, varValorOrigen, varValorTipo, varValorDescripcion, varValorEmail, varValorIdPais, varValorIdTipo, varTipoRegistro, varNombreCuit, varValorCuit, varNombreNombre, varValorNombre, varNombreApellido, varValorApellido, varNombreTelefono, varValorTelefono){	
	var wrapper         = $(varWrapper);
	var tabla			= "";

	//$(wrapper).append('<div id="'+varActual+'_'+eval(varActual)+'"></div>');
	tabla+='<tr>';
	if(varTipoRegistro=="proveedor" || varTipoRegistro=="cliente" || varTipoRegistro=="proveedor_simple"){
		if(varNombreCuit!=""){
			tabla+='<td><input type="hidden" id="'+varNombreCuit+'_'+eval(varActual)+'" name="'+varNombreCuit+'[]" value="'+varValorCuit+'" />'+varValorCuit+'&nbsp;</td>';
		}	
	}
	if(varNombreRazonSocial!=""){
		tabla+='<td><input type="hidden" id="'+varNombreRazonSocial+'_'+eval(varActual)+'" name="'+varNombreRazonSocial+'[]" value="'+varValorRazonSocial+'" />'+varValorRazonSocial+'&nbsp;</td>';
	}
	if(varNombreNombre!=""){
		tabla+='<td><input type="hidden" id="'+varNombreNombre+'_'+eval(varActual)+'" name="'+varNombreNombre+'[]" value="'+varValorNombre+'" />'+varValorNombre+'&nbsp;</td>';
	}
	if(varNombreApellido!=""){
		tabla+='<td><input type="hidden" id="'+varNombreApellido+'_'+eval(varActual)+'" name="'+varNombreApellido+'[]" value="'+varValorApellido+'" />'+varValorApellido+'&nbsp;</td>';
	}
	if(varNombreEmail!=""){
		tabla+='<td><input type="hidden" id="'+varNombreEmail+'_'+eval(varActual)+'" name="'+varNombreEmail+'[]" value="'+varValorEmail+'" />'+varValorEmail+'&nbsp;</td>';
	}
	if(varNombreTelefono!=""){
		tabla+='<td><input type="hidden" id="'+varNombreTelefono+'_'+eval(varActual)+'" name="'+varNombreTelefono+'[]" value="'+varValorTelefono+'" />'+varValorTelefono+'&nbsp;</td>';
	}
	if(varNombreOrigen!=""){
		tabla+='<td><input type="hidden" id="'+varNombreOrigen+'_'+eval(varActual)+'" name="'+varNombreOrigen+'[]" value="'+varValorIdPais+'" />'+varValorOrigen+'&nbsp;</td>';
	}
	if(varNombreTipo!=""){
		tabla+='<td><input type="hidden" id="'+varNombreTipo+'_'+eval(varActual)+'" name="'+varNombreTipo+'[]" value="'+varValorIdTipo+'" />'+varValorTipo+'&nbsp;</td>';
	}
	if(varNombreDescripcion!=""){
		tabla+='<td><input type="hidden" id="'+varNombreDescripcion+'_'+eval(varActual)+'" name="'+varNombreDescripcion+'[]" value="'+varValorDescripcion+'" />'+varValorDescripcion+'&nbsp;</td>';
	}
	if(varTipoRegistro=="proveedor" || varTipoRegistro=="proveedor_simple"){
		tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesProveedor_'+(eval(varActual))+'\',\'cant_proveedores\')" id="quitarOpcionesProveedor_'+(eval(varActual))+'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
	}
	if(varTipoRegistro=="cliente"){
		tabla+='<td><a href="#" id="quitarOpcionesCliente" class="quitarOpcionesCliente"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
	}
	if(varTipoRegistro=="competidor"){
		tabla+='<td><a href="#" id="quitarOpcionesCompetidor" class="quitarOpcionesCompetidor"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
	}

	tabla+='</tr>';
	$(varWrapper+ " table").append(tabla);
	window[varActual]++;
	$(varWrapper).show();
}
function agregarOpcionesSelect(varMax_fields, varWrapper, varNombre, varTexto, varActual, varOtro){	
	var max_fields      = varMax_fields; 
	var wrapper         = $(varWrapper); 
	if(eval(varActual) < max_fields){ 
		if($("select[name="+varTexto+"]").val()!=""){
			if($("select[name="+varTexto+"]").val()!="-1"){
				$(wrapper).append('<div><input type="hidden" id="'+varNombre+'_'+eval(varActual)+'" name="'+varNombre+'[]" value="'+$("select[name="+varTexto+"]").val()+'" /> '+$( "select[name="+varTexto+"] option:selected").text()+' <a href="javascript:removerOpcionesSelect(\''+varNombre+'_'+eval(varActual)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a></div>');
				window[varActual]++;
			} else {
				if($("input[name="+varOtro+"]").val()!=""){
					$(wrapper).append('<div><input type="hidden" id="'+varNombre+'_'+eval(varActual)+'" name="'+varNombre+'[]" value="'+$("input[name="+varOtro+"]").val()+'" /> '+$("input[name="+varOtro+"]").val()+' <a href="javascript:removerOpcionesSelect(\''+varNombre+'_'+eval(varActual)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a></div>');
					window[varActual]++;
				} else {
					alert("Debe ingresar un valor en el campo Otro")
				}
			}
		} else {
			alert("Debe elegir alguna opción para poder añadir");
		}
	} else {
		alert("Se ha alcanzado el máximo permitido. Elimine un item cargado, para poder seleccionar uno nuevo.");	
	}
}

function agregarOpcionesRazonSocialCuit(varMax_fields, varWrapper, varCuit, varRazonSocial, varActual, varNombreCuit, varNombreRazonSocial){	
	//varCuit es el nombre del campo de cuit
	//varRazonSocial es el nombre del campo razon social
	var max_fields      = varMax_fields; 
	var wrapper         = $(varWrapper); 
	var varCuitMostrar	= $("input[name="+varCuit+"]").val();
	if(varCuitMostrar=="0"){
		varCuitMostrar	= "";
	}
	if(eval(varActual) < max_fields){ 
		if(($("input[name="+varCuit+"]").val()!="" && $("input[name="+varRazonSocial+"]").val()!="") || ($("input[name="+varCuit+"]").val()=="0" && $("input[name="+varRazonSocial+"]").val()!="")){
			$(wrapper).append('<div><input type="hidden" id="'+varCuit+'_'+eval(varActual)+'" name="'+varNombreCuit+'[]" value="'+$("input[name="+varCuit+"]").val()+'" /><input type="hidden" id="'+varRazonSocial+'_'+eval(varActual)+'" name="'+varNombreRazonSocial+'[]" value="'+$("input[name="+varRazonSocial+"]").val()+'" /> '+$( "input[name="+varRazonSocial+"]").val()+'  '+varCuitMostrar+' <a href="javascript:removerOpcionesRazonSocialCuit(\''+varRazonSocial+'_'+eval(varActual)+'\', \''+varActual+'\')" class="quitarOpciones"><i class="fa fa-times" aria-hidden="true"></a></div>');
			window[varActual]++;
		} else {
			if($("input[name="+varCuit+"]").val()=="0"){
				alert("Debe ingresar la razón social para poder añadir");
			} else {
				alert("Debe ingresar CUIT y razón social para poder añadir");
			}
		}
	}
}

function removerOpcionesSelect(varElemento, varActual){
	$("#"+varElemento).parent('div').remove(); 
	window[varActual]--;
}

function removerOpcionesRazonSocialCuit(varElemento, varActual){
	$("#"+varElemento).parent('div').remove(); 
	window[varActual]--;
}

function agregarOpcionesProveedor(varMax_fields, varWrapper, varRazonSocial, varActual, varNombreRazonSocial, varOrigen, varNombreOrigen, varTipo, varNombreTipo, varDescripcion, varNombreDescripcion, varEmail, varNombreEmail, varTipoRegistro, varCuit, varNombreCuit, varApellido, varNombreApellido, varNombre, varNombreNombre, varTelefono, varNombreTelefono){	
//function agregarOpcionesProveedor(varMax_fields, varWrapper, varRazonSocial, varActual, varNombreRazonSocial, varOrigen, varNombreOrigen, varTipo, varNombreTipo, varDescripcion, varNombreDescripcion, varEmail, varNombreEmail, varTipoRegistro, varCuit, varNombreCuit){	
	var max_fields      = varMax_fields; 
	var wrapper         = $(varWrapper);
	var tabla="";           


	if((eval(varActual) < max_fields) || max_fields==''){ 
		if(varTipoRegistro=="proveedor"){
			if($("input[name="+varDescripcion+"]").val()!="" && $("input[name="+varRazonSocial+"]").val()!="" && $("input[name="+varEmail+"]").val()!="" && $("select[name="+varTipo+"]").prop('selectedIndex')!=0 && $("select[name="+varOrigen+"]").prop('selectedIndex')!=0) {
				tabla+='<tr>';
				tabla+='<td><input type="hidden" id="'+varCuit+'_'+(window[varActual]+1)+'" name="'+varNombreCuit+'[]" value="'+$("input[name="+varCuit+"]").val()+'" />'+$( "input[name="+varCuit+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varRazonSocial+'_'+(window[varActual]+1)+'" name="'+varNombreRazonSocial+'[]" value="'+$("input[name="+varRazonSocial+"]").val()+'" />'+$( "input[name="+varRazonSocial+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varOrigen+'" name="'+varNombreOrigen+'[]" value="'+$("select[name="+varOrigen+"]").val()+'" />'+$( "select[name="+varOrigen+"] option:selected").text()+'</td>';
				tabla+='<td><input type="hidden" id="'+varTipo+'" name="'+varNombreTipo+'[]" value="'+$("select[name="+varTipo+"]").val()+'" />'+$( "select[name="+varTipo+"] option:selected").text()+'</td>';
				tabla+='<td><input type="hidden" id="'+varDescripcion+'" name="'+varNombreDescripcion+'[]" value="'+$("input[name="+varDescripcion+"]").val()+'" />'+$( "input[name="+varDescripcion+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varEmail+'" name="'+varNombreEmail+'[]" value="'+$("input[name="+varEmail+"]").val()+'" />'+$( "input[name="+varEmail+"]").val()+'</td>';
				tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesProveedor_'+(window[varActual]+1)+'\',\'cant_proveedores\')" id="quitarOpcionesProveedor_'+(window[varActual]+1)+'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
				tabla+='</tr>';
				$(varWrapper+ " table").append(tabla);
				window[varActual]++;
			} else {
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("Debe completar todos los datos del proveedor para poder añadir");
				$('#alerta').modal('show');
			}
		}//end if proveedor
		if(varTipoRegistro=="proveedor_full"){
			if($("input[name="+varApellido+"]").val()!="" && $("input[name="+varNombre+"]").val()!="" && $("input[name="+varCuit+"]").val()!="" && $("input[name="+varRazonSocial+"]").val()!="" && $("input[name="+varEmail+"]").val()!="" && $("input[name="+varTelefono+"]").val()!="") {
				tabla+='<tr>';
				tabla+='<td><input type="hidden" id="'+varCuit+'_'+(window[varActual]+1)+'" name="'+varNombreCuit+'[]" value="'+$("input[name="+varCuit+"]").val()+'" />'+$( "input[name="+varCuit+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varRazonSocial+'_'+(window[varActual]+1)+'" name="'+varNombreRazonSocial+'[]" value="'+$("input[name="+varRazonSocial+"]").val()+'" />'+$( "input[name="+varRazonSocial+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varNombre+'" name="'+varNombreNombre+'[]" value="'+$("input[name="+varNombre+"]").val()+'" />'+$( "input[name="+varNombre+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varApellido+'" name="'+varNombreApellido+'[]" value="'+$("input[name="+varApellido+"]").val()+'" />'+$( "input[name="+varApellido+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varEmail+'" name="'+varNombreEmail+'[]" value="'+$("input[name="+varEmail+"]").val()+'" />'+$( "input[name="+varEmail+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varTelefono+'" name="'+varNombreTelefono+'[]" value="'+$("input[name="+varTelefono+"]").val()+'" />'+$( "input[name="+varTelefono+"]").val()+'</td>';
				tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesProveedor_'+(window[varActual]+1)+'\',\'cant_proveedores\')" id="quitarOpcionesProveedor_'+(window[varActual]+1)+'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
				tabla+='</tr>';
				$(varWrapper+ " table").append(tabla);
				window[varActual]++;
			} else {
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("Debe completar todos los datos del proveedor para poder añadir");
				$('#alerta').modal('show');
			}
		}//end if proveedor_full
		if(varTipoRegistro=="proveedor_simple"){
			if($("input[name="+varRazonSocial+"]").val()!="" && $("input[name="+varCuit+"]").val()!="") {
				tabla+='<tr>';
				tabla+='<td><input type="hidden" id="'+varCuit+'_'+(window[varActual]+1)+'" name="'+varNombreCuit+'[]" value="'+$("input[name="+varCuit+"]").val()+'" />'+$( "input[name="+varCuit+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varRazonSocial+'_'+(window[varActual]+1)+'" name="'+varNombreRazonSocial+'[]" value="'+$("input[name="+varRazonSocial+"]").val()+'" />'+$( "input[name="+varRazonSocial+"]").val()+'</td>';
				tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesProveedor_'+(window[varActual]+1)+'\',\'cant_proveedores\')" id="quitarOpcionesProveedor_'+(window[varActual]+1)+'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
				tabla+='</tr>';
				$(varWrapper+ " table").append(tabla);
				window[varActual]++;
			} else {
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("Debe completar todos los datos del proveedor para poder añadir");
				$('#alerta').modal('show');
			}
		}//end if proveedor_simple
		if(varTipoRegistro=="proveedor_sin_cuit"){
			if($("input[name="+varRazonSocial+"]").val()!="") {
				tabla+='<tr>';
				tabla+='<td><input type="hidden" id="'+varCuit+'_'+(window[varActual]+1)+'" name="'+varNombreCuit+'[]" value="'+$("input[name="+varCuit+"]").val()+'" />'+$( "input[name="+varCuit+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varRazonSocial+'_'+(window[varActual]+1)+'" name="'+varNombreRazonSocial+'[]" value="'+$("input[name="+varRazonSocial+"]").val()+'" />'+$( "input[name="+varRazonSocial+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varNombre+'" name="'+varNombreNombre+'[]" value="" />--</td>';
				tabla+='<td><input type="hidden" id="'+varApellido+'" name="'+varNombreApellido+'[]" value="" />--</td>';
				tabla+='<td><input type="hidden" id="'+varEmail+'" name="'+varNombreEmail+'[]" value="" />--</td>';
				tabla+='<td><input type="hidden" id="'+varTelefono+'" name="'+varNombreTelefono+'[]" value="" />--</td>';
				tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesProveedor_'+(window[varActual]+1)+'\',\'cant_proveedores\')" id="quitarOpcionesProveedor_'+(window[varActual]+1)+'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
				tabla+='</tr>';
				$(varWrapper+ " table").append(tabla);
				window[varActual]++;
			} else {
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("Debe completar todos los datos del proveedor para poder añadir");
				$('#alerta').modal('show');
			}
		}//end if proveedor_sin_cuit
		if(varTipoRegistro=="cliente"){
			if($("input[name="+varRazonSocial+"]").val()!="" && $("input[name="+varEmail+"]").val()!="" && $("select[name="+varOrigen+"]").prop('selectedIndex')!=0) {			
				tabla+='<tr>';
				tabla+='<td><input type="hidden" id="'+varCuit+'_'+(window[varActual]+1)+'" name="'+varNombreCuit+'[]" value="'+$("input[name="+varCuit+"]").val()+'" />'+$( "input[name="+varCuit+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varRazonSocial+'_'+(window[varActual]+1)+'" name="'+varNombreRazonSocial+'[]" value="'+$("input[name="+varRazonSocial+"]").val()+'" />'+$( "input[name="+varRazonSocial+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varOrigen+'" name="'+varNombreOrigen+'[]" value="'+$("select[name="+varOrigen+"]").val()+'" />'+$( "select[name="+varOrigen+"] option:selected").text()+'</td>';
				tabla+='<td><input type="hidden" id="'+varEmail+'" name="'+varNombreEmail+'[]" value="'+$("input[name="+varEmail+"]").val()+'" />'+$( "input[name="+varEmail+"]").val()+'</td>';
				tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesCliente_'+(window[varActual]+1)+'\',\'cant_clientes\')" id="quitarOpcionesCliente_'+(window[varActual]+1)+'" class="quitarOpcionesCliente"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
				tabla+='</tr>';
				$(varWrapper+ " table").append(tabla);
				window[varActual]++;
			} else {
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("Debe completar todos los datos del cliente para poder añadir");
				$('#alerta').modal('show');
			}
		}//end if cliente
		if(varTipoRegistro=="competidor"){
			if($("input[name="+varRazonSocial+"]").val()!="" && $("select[name="+varOrigen+"]").prop('selectedIndex')!=0) {
				tabla+='<tr>';
				tabla+='<td><input type="hidden" id="'+varRazonSocial+'_'+(window[varActual]+1)+'" name="'+varNombreRazonSocial+'[]" value="'+$("input[name="+varRazonSocial+"]").val()+'" />'+$( "input[name="+varRazonSocial+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varOrigen+'" name="'+varNombreOrigen+'[]" value="'+$("select[name="+varOrigen+"]").val()+'" />'+$( "select[name="+varOrigen+"] option:selected").text()+'</td>';
				tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesCompetidor_'+(window[varActual]+1)+'\',\'cant_competidores\')" id="quitarOpcionesCompetidor_'+(window[varActual]+1)+'" class="quitarOpcionesCompetidor"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
				tabla+='</tr>';
				$(varWrapper+ " table").append(tabla);
				window[varActual]++;
			} else {
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("Debe completar todos los datos del competidor para poder añadir");
				$('#alerta').modal('show');
			}
		}//end if cliente
		if(window[varActual]>0){
			$(wrapper).show();	
		}
	}
}

function agregarOpcionesEmbarque(varMax_fields, varWrapper, varFechaEmbarque, varActual, varNombreFechaEmbarque,varTipoRegistro, varCantidadEmbarque, varNombreCantidadEmbarque){	
	var max_fields      = varMax_fields; 
	var wrapper         = $(varWrapper);
	var tabla="";           


	if((eval(varActual) < max_fields) || max_fields==''){ 

		if(varTipoRegistro=="embarques_anio_actual"){
			if($("input[name="+varFechaEmbarque+"]").val()!="" && $("input[name="+varCantidadEmbarque+"]").val()!="") {
				tabla+='<tr>';
				tabla+='<td><input type="hidden" id="'+varFechaEmbarque+'_'+(window[varActual]+1)+'" name="'+varNombreFechaEmbarque+'[]" value="'+$("input[name="+varFechaEmbarque+"]").val()+'" />'+$( "input[name="+varFechaEmbarque+"]").val()+'</td>';
				tabla+='<td><input type="hidden" id="'+varCantidadEmbarque+'_'+(window[varActual]+1)+'" name="'+varNombreCantidadEmbarque+'[]" value="'+$("input[name="+varCantidadEmbarque+"]").val()+'" />'+$( "input[name="+varCantidadEmbarque+"]").val()+'</td>';
				tabla+='<td><a href="javascript:removerOpcion(\'quitarOpcionesEmbarque_'+(window[varActual]+1)+'\',\'cant_embarques\')" id="quitarOpcionesEmbarque_'+(window[varActual]+1)+'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
				tabla+='</tr>';
				$(varWrapper+ " table").append(tabla);
				window[varActual]++;
			} else {
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("Debe completar todos los datos del embarque para poder añadir");
				$('#alerta').modal('show');
			}
		}//end if
		if(window[varActual]>0){
			$(wrapper).show();	
		}
	}
}

function removerOpcion(varObjeto, varActual){
	$("#"+varObjeto).parent().parent().remove();
	//window[varActual]--;
}

function mostrarAyuda(varAncho, varCampo, varArchivo){
	$(varCampo).CreateBubblePopup({
		position: 'left',
		distance:'20px',
		selectable: true,
		alwaysVisible: true, 
		manageMouseEvents: false,
		width: varAncho,
		divStyle: {color: '#000000', margin:'-20px'},
		height:'100px',
		align: 'center',
		innerHtml: '<img src="/images/loading.gif" style="border:0px; vertical-align:middle; margin-right:10px; display:inline;" />loading!',
		innerHtmlStyle: { color:'#000000', 'text-align':'left' },
		themeName: 'azure',
		themePath: 'images/jquerybubblepopup-theme'
	});

	//$(varCampo).mouseover(function(){
	$(varCampo).click(function(){
		var button = $(this);
		if($(varCampo).IsBubblePopupOpen()){
			$(varCampo).HideBubblePopup();
		} else {
			$(varCampo).ShowBubblePopup();
			$.get(varArchivo, function(data) {
				var seconds_to_wait = 0;
				function pause(){
					var timer = setTimeout(function(){
						seconds_to_wait--;
						if(seconds_to_wait > 0){
							pause();
						}else{
								//set new innerHtml for the Bubble Popup
							button.SetBubblePopupInnerHtml(data, false); //false -> it shows new innerHtml but doesn't save it, then the script is forced to load everytime the innerHtml... 							
							// take a look in documentation for SetBubblePopupInnerHtml() method
						};
				},500);
				};pause();
			});
		}
	}); //end click

}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function editarPerfiles(_id)
{
	with(document.datos)
	{
		id_usuario.value = _id;
		action = "usuario_perfil_abm.php";
		submit();
	}
}

function desasociarTramite(varId_contenido_requiere, varId_contenido) {
	if(confirm("¿Está seguro que quiere DES-ASOCIAR este trámite?")){
		params="id_contenido_requiere="+varId_contenido_requiere+"&id_contenido="+varId_contenido+"&accion=DESASOCIAR";
		$.ajax({
			beforeSend: function(){},
			complete: function(){ },
			success: function(html){
				$("#contenedorTramites").html(html);
			},
			method: "post",url: "listaTramiteAsset.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
		});
	}
}

function desasociarTramiteContenedor(varId_contenido_requiere, varId_contenido) {
	if(confirm("¿Está seguro que quiere DES-ASOCIAR este trámite?")){
		params="id_contenido_requiere="+varId_contenido_requiere+"&id_contenido="+varId_contenido+"&accion=DESASOCIAR";
		$resultado=$.ajax({
			beforeSend: function(){},
			complete: function(){ },
			success: function(html){
				$("#contenedorTramites").html(html);
			},
			async:false,
			method: "post",url: "contenedorListaTramiteAsset.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
		}).responseText;
		cargarTramiteLista(varId_contenido_requiere);
	}
}

function cargarTramiteLista(varId_contenido){
 	params="id_contenido_requiere="+varId_contenido;
	$.ajax({
			beforeSend: function(){},
			complete: function(){ },
			success: function(html){
				$("#contenedorTramites").html(html);
			},
			method: "post",url: "listaTramiteAsset.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	});

}
function cerrarPopUp(varNombrePopUp){
	document.getElementById(varNombrePopUp).innerHTML='';
	document.getElementById(varNombrePopUp).style.display = 'none';
	$.unblockUI({ message: $('#'+varNombrePopUp)});
}
function cerrarPopUpIframe(varNombrePopUp){
	parent.document.getElementById(varNombrePopUp).src='';
	parent.document.getElementById(varNombrePopUp).style.display = 'none';
	$.unblockUI({ message: $('#'+varNombrePopUp)});
}
function abrirPopUp(varPaginaAbrir, varParams, varNombrePopUp, varAncho){

        $.blockUI({ message: $('#'+varNombrePopUp),
		css:{
			width: varAncho,
			cursor: 'default'
		}
	}); 
 	params=varParams;
	$.ajax({
			beforeSend: function(){},
			complete: function(){ },
			success: function(html){
				switch(html){
					case -1:
	
					break;
					default:
						$("#"+varNombrePopUp).html(html);
					break;
				}
			},
			method: "post",url: varPaginaAbrir,data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	});
	document.getElementById(varNombrePopUp).style.display = 'block';
}
function abrirPopUpIframe(varPaginaAbrir, varParams, varNombrePopUp, varAncho){

        $.blockUI({ message: $('#'+varNombrePopUp),
		css:{
			width: varAncho,
			cursor: 'default',
			top: '10px',
			left: '20px'
		}
	}); 
 	params=varParams;
	document.getElementById(varNombrePopUp).src=varPaginaAbrir+'?'+params;
	document.getElementById(varNombrePopUp).style.display = 'block';
}



		function validarLogin()
		{
			var errores = "";
			var elemFoco = "";
			
			with(document.datos)
			{
				if(username.value == "")
				{
					errores += "- Debe completar el E-mail para poder ingresar\n";
					if(elemFoco == "") elemFoco = "username";
				}

				if(password.value == "")
				{
					errores += "- Debe completar la Contraseña para poder ingresar\n";
					if(elemFoco == "") elemFoco = "password";
				}
	
				if(errores == "")
				{
						action="login.php";
						accion.value = "LOGIN";	
						submit();					
				}
				else
				{
					alert(errores);
					SetFocus(eval(elemFoco));
				}
			}
		}
		
		function validarForgot()
		{
			var errores = "";
			var elemFoco = "";
			
			with(document.datos)
			{
				if(email.value == "")
				{
					errores += "- <?= _JS_ERROR_EMAIL?>\n";
					if(elemFoco == "") elemFoco = "email";
				}

				if(errores == "")
				{
						accion.value = "FORGOT";	
						submit();					
				}
				else
				{
					alert(errores);
					SetFocus(eval(elemFoco));
				}
			}
		}

function submitenter(myfield,e, accion)

{

	var keycode;

	if (window.event) keycode = window.event.keyCode;

	else if (e) keycode = e.which;

	else return true;

	

	if (keycode == 13)

	   {
		eval(accion);

	   return false;

	   }

	else

	   return true;

}

function mostrarLayer(capa){
	$("#"+capa).show("fast");
	var target_offset = $("#"+capa).offset();
	var target_top = target_offset.top;
	$('html, body').animate({scrollTop:target_top}, 500);
}

function mostrarLayerWrk(capa){
	$("#"+capa).hide();
	$("#contenidos-desplegables > *").hide();
	$("#titulo-desplegable-flecha img").attr("src", "imagenes/expandible-up.jpg");
	$("#flecha_"+capa).attr("src", "imagenes/expandible-down.jpg");
	$("#"+capa).show("fast");
}

function ocultarLayerWrk(){
	$("#contenidos-desplegables > *").hide();
}

function ocultarLayer(capa){
	$("#"+capa).hide();
}



function cargarProvinciaLocalidadRo(id, lugar, tabla, id_tabla, con, otra_localidad, otra_provincia, id_provincia, id_localidad)
{
	params="id_tabla="+id_tabla+"&tabla="+tabla+"&con="+con+"&valor="+id+"&otra_provincia="+otra_provincia+"&otra_localidad="+otra_localidad+"&id_provincia="+id_provincia+"&id_localidad="+id_localidad+"&lugar="+lugar+"&ro=1";
			if(lugar=="provincia_div"){
				$("#provincia_div").html("<input type=\"text\" class=\"form-control\" value=\"\" name=\"var_localidad\" value=\""+otra_localidad+"\" maxlength=\"255\">");
				params+="&seleccionado="+id_provincia;	
				params+="&labelCampo=emp_otra_provincia&labelCampoId=var_id_provincia";	
			}
			if(lugar=="provincia_fiscal_div"){
				$("#provincia_fiscal_div").html("<input type=\"text\" class=\"form-control\" value=\"\" name=\"var_localidad_fiscal\" value=\""+otra_localidad+"\" maxlength=\"255\">");
				params+="&seleccionado="+id_provincia;	
				params+="&labelCampo=emp_otra_provincia&labelCampoId=var_id_provincia_fiscal";	
			}
			if(lugar=="localidad_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_localidad&labelCampoId=var_id_localidad";
			}
			if(lugar=="localidad_fiscal_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_localidad_fiscal&labelCampoId=var_id_localidad_fiscal";
			}
			if(lugar=="localidad_planta"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_localidad&labelCampoId=var_planta_id_localidad";
			}
			if(lugar=="municipalidad_planta"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_planta_id_municipalidad&labelCampoId=var_planta_id_municipalidad";
			}
			if(lugar=="municipalidad_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_municipalidad&labelCampoId=var_id_municipalidad";
			}
			if(lugar=="municipalidad_fiscal_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_municipalidad_fiscal&labelCampoId=var_id_municipalidad_fiscal";
			}
	$.ajax({
        	beforeSend: function(){
			$("#"+lugar).html('Cargando');
		}, 	complete: function(){ }, 
		success: function(html){ //so, if data is retrieved, store it in html
			$("#"+lugar).show("slow"); //animation
			$("#"+lugar).html(html); //show the html inside .content div
                },
        	method: "post",url: "/getLocalidad.php",data: params,contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	}); //close $.ajax(
}
function cargarProvinciaLocalidad(id, lugar, tabla, id_tabla, con, otra_localidad, otra_provincia, id_provincia, id_localidad)
{
	params="id_tabla="+id_tabla+"&tabla="+tabla+"&con="+con+"&valor="+id+"&otra_provincia="+otra_provincia+"&otra_localidad="+otra_localidad+"&id_provincia="+id_provincia+"&id_localidad="+id_localidad+"&lugar="+lugar;
			if(lugar=="provincia_div"){
				$("#provincia_div").html("<input type=\"text\" class=\"form-control\" value=\"\" name=\"var_localidad\" value=\""+otra_localidad+"\" maxlength=\"255\">");
				params+="&seleccionado="+id_provincia;	
				params+="&labelCampo=emp_otra_provincia&labelCampoId=var_id_provincia";	
			}
			if(lugar=="provincia_fiscal_div"){
				$("#provincia_fiscal_div").html("<input type=\"text\" class=\"form-control\" value=\"\" name=\"var_localidad_fiscal\" value=\""+otra_localidad+"\" maxlength=\"255\">");
				params+="&seleccionado="+id_provincia;	
				params+="&labelCampo=emp_otra_provincia&labelCampoId=var_id_provincia_fiscal";	
			}
			if(lugar=="localidad_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=var_domicilio_id_localidad&labelCampoId=var_domicilio_id_localidad";
			}
			if(lugar=="localidad_fiscal_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_localidad_fiscal&labelCampoId=var_id_localidad_fiscal";
			}
			if(lugar=="localidad_planta"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_localidad&labelCampoId=var_planta_id_localidad";
			}
			if(lugar=="municipalidad_planta"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_planta_id_municipalidad&labelCampoId=var_planta_id_municipalidad";
			}
			if(lugar=="municipalidad_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_municipalidad&labelCampoId=var_id_municipalidad";
			}
			if(lugar=="municipalidad_fiscal_div"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=emp_id_municipalidad_fiscal&labelCampoId=var_id_municipalidad_fiscal";
			}
	$.ajax({
        	beforeSend: function(){
			$("#"+lugar).html('Cargando');
		}, 	complete: function(){ }, 
		success: function(html){ //so, if data is retrieved, store it in html
			$("#"+lugar).show("slow"); //animation
			$("#"+lugar).html(html); //show the html inside .content div
                },
        	method: "post",url: "getLocalidad.php",data: params,contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	}); //close $.ajax(
}

function cargarProvinciaLocalidadPrint(id, lugar, tabla, id_tabla, con, otra_localidad, otra_provincia, id_provincia, id_localidad)
{
	params="id_tabla="+id_tabla+"&tabla="+tabla+"&con="+con+"&valor="+id+"&otra_provincia="+otra_provincia+"&otra_localidad="+otra_localidad+"&id_provincia="+id_provincia+"&id_localidad="+id_localidad;
			if(lugar=="provincia_part"){
				$("#localidad_part").html("<input type=\"text\" readonly class=\"campoBordeAzul\" value=\"\" name=\"per_domicilio_otra_localidad\" value=\""+otra_localidad+"\" maxlength=\"255\">");
				params+="&seleccionado="+id_provincia;	
				params+="&labelCampo=per_domicilio_otra_provincia&labelCampoId=per_domicilio_id_provincia";	
			}
			if(lugar=="provincia_lab"){
				$("#localidad_lab").html("<input type=\"text\" readonly class=\"campoBordeAzul\" value=\"\" name=\"per_domicilio_laboral_otra_localidad\" value=\""+otra_localidad+"\" maxlength=\"255\">");
				params+="&seleccionado="+id_provincia;	
				params+="&labelCampo=per_domicilio_laboral_otra_provincia&labelCampoId=per_domicilio_laboral_id_provincia";	
			}
			if(lugar=="localidad_part"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=per_domicilio_otra_localidad&labelCampoId=per_domicilio_laboral_id_localidad";	
			}
			if(lugar=="localidad_lab"){
				params+="&seleccionado="+id_localidad;
				params+="&labelCampo=per_domicilio_laboral_otra_localidad&labelCampoId=per_domicilio_laboral_id_localidad";
			}
	$.ajax({
        	beforeSend: function(){
			$("#"+lugar).html('<div align="left"><img src="imagenes/cargasc.gif"></div>');
		}, 	complete: function(){ }, 
		success: function(html){ //so, if data is retrieved, store it in html
			$("#"+lugar).show("slow"); //animation
			$("#"+lugar).html(html); //show the html inside .content div
                },
        	method: "post",url: "getLocalidadPrint.php",data: params,contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	}); //close $.ajax(
}


function cargarAreaInteresCombo(_valor,varCajaSeleccion,varCampoCantidad, varCampoAreaIdGuardar, varAreaElegirNombre, varCategoria,varMaxAreas)
{
	params="&areaId_guardar_campo="+varCampoAreaIdGuardar;
	params+="&tipo_area_id="+varCategoria;
	params+="&cant_areaId_campo="+varCampoCantidad;
	params+="&caja_seleccion="+varCajaSeleccion;
	params+="&areaElegir="+varAreaElegirNombre;
	params+="&max_areas="+varMaxAreas;
	//params+=$("select").serialize();
	params+="&areaId_seleccion="+_valor;
	//alert(params);
	$.ajax({
        	beforeSend: function(){
			/*$("#cargando").show("slow");*/
		
		}, //show loading just when link is clicked
        	complete: function(){ /*$("#cargando").hide("fast");*/}, //stop showing loading when the process is complete
		success: function(html){ //so, if data is retrieved, store it in html
			/*$("#area_elegir").show("slow"); //animation*/
			$("#"+varCajaSeleccion).html(html); //show the html inside .content div
        },
      	method: "post",url: "getArea.php",data: params, contentType : "application/x-www-form-urlencoded; charset=utf-8"
	}); //close $.ajax(
}


function cargarNcm(valor1, valor2, valor3)
{
	params="buscar_ncm1="+valor1+"&buscar_ncm2="+valor2+"&buscar_ncm3="+valor3;
	$.ajax({
        	beforeSend: function(){
	
		},
        	complete: function(){},
		success: function(html){
			switch(html){
				default:
					$("#form-ncm").html(html);
				break;
			}
                },
        	method: "post",url: "cargarNcm.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	}); //close $.ajax(
}

function cargarAreaInteres(valor)
{
	if(valor!=""){
		params="cant_areaId=1&areaId1="+valor;
	}
	params+="&"+$(":hidden").serialize();
	$.ajax({
        	beforeSend: function(){

		
		},
        	complete: function(){},
		success: function(html){
			switch(html){
				default:
					$("#form-areas-interes-seleccionadas").append(html);
				break;
			}
                },
        	method: "post",url: "cargarArea.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	}); //close $.ajax(
}


function agregarAdjuntoFunc(){
	var archivoInput=document.getElementById("archivo_agregar");
	with(document.datos){
		var errores = "";
		if(archivoInput.value==""){
			errores+="- Debe elegir un archivo para subir";
		} else {
			if(parseInt($("#cant_adj").val(),10)==1){
				errores+="- No puede subir otro adjunto sin eliminar primero el existente";
			}
		}
		
		if(errores==""){
			accion.value="addAdjunto";
			action="ProcesarAdjunto.php";
			target="frmImg";
			submit();
			$("#adjuntoUsuario").html("Subiendo archivo...");
		} else {
			alert(errores);
		}
	}
	archivoInput.value="";
}
function agregarAdjuntoCustom(varNombreArchivo,varCant,varDestino,varFrame,varSeleccionado,varNombreAdjunto, varCantMax, varTipoAdj){
	var archivoInput=document.getElementById(varNombreArchivo);
	with(document.datos){
		var errores = "";
		if(archivoInput.value==""){
			errores+="- Debe elegir un archivo para subir";
		} else {
			if(parseInt($("#"+varCant).val(),10)==varCantMax){
				errores+="- No puede subir otro adjunto sin eliminar primero alguno de los existentes";
			}
		}
		
		if(errores==""){
			accion.value="addAdjunto";
			action="ProcesarAdjuntoCustom.php?destino="+varDestino+"&archivo_var="+varNombreArchivo+"&cant_var="+varCant+"&seleccionado_var="+varSeleccionado+"&nombre_adjunto_var="+varNombreAdjunto+"&cantidad="+$("#"+varCant).val()+"&tipo_adjunto="+varTipoAdj;
			target=varFrame;
			submit();
			$("#"+varDestino).html("Subiendo archivo...");
		} else {
			alert(errores);
		}
	}
	archivoInput.value="";
}
function agregarAdjuntoCustomTipo(varNombreArchivo,varCant,varDestino,varFrame,varSeleccionado,varNombreAdjunto, varCantMax, varNombreTipoAdj){
	var archivoInput=document.getElementById(varNombreArchivo);
	with(document.datos){
		var errores = "";
		if(archivoInput.value==""){
			errores+="- Debe elegir un archivo para subir\n";
		} else {
			if(parseInt($("#"+varCant).val(),10)==varCantMax){
				errores+="- No puede subir otro adjunto sin eliminar primero alguno de los existentes\n";
			}
		}
		if($("#"+varNombreTipoAdj).val()==""){
			errores+="- Debe elegir el tipo de adjunto\n";
		}
		if(errores==""){
			accion.value="addAdjunto";
			action="ProcesarAdjuntoCustom.php?destino="+varDestino+"&archivo_var="+varNombreArchivo+"&cant_var="+varCant+"&seleccionado_var="+varSeleccionado+"&nombre_adjunto_var="+varNombreAdjunto+"&cantidad="+$("#"+varCant).val()+"&tipo_adjunto="+$("#"+varNombreTipoAdj).val();
			target=varFrame;
			submit();
			$("#"+varDestino).html("Subiendo archivo...");
		} else {
			alert(errores);
		}
	}
	archivoInput.value="";
	$("#"+varNombreTipoAdj).val("");
}
function agregarImagenFunc(){
	var archivoInput=document.getElementById("archivo_agregar");
	with(document.datos){
		var errores = "";
		if(archivoInput.value==""){
			errores+="- Debe elegir un archivo para subir";
		} else {
			if(parseInt($("#cant_adj").val(),10)==1){
				errores+="- No puede subir otro adjunto sin eliminar primero el existente";
			}
		}
		
		if(errores==""){
			accion.value="addAdjunto";
			action="ProcesarAdjuntoImagen.php";
			target="frmImg";
			submit();
			$("#adjuntoUsuario").html("Subiendo archivo...");
		} else {
			alert(errores);
		}
	}
	archivoInput.value="";
	
}
function agregarAdjuntoFuncBack(varMaxAdj){
	var archivoInput=document.getElementById("archivo_agregar");
	with(document.datos){
		var errores = "";
		if(archivoInput.value==""){
			errores+="- Debe elegir un archivo para subir";
		} else {
			if(parseInt($("#cant_adj").val(),10)>=varMaxAdj){
				errores+="- No puede subir más de "+varMaxAdj+" adjuntos";
			}
		}
		
		if(errores==""){
			accion.value="addAdjuntoBack";
			action="../ProcesarAdjunto.php";
			target="frmImg";
			submit();
			$("#adjuntoUsuario").html("Subiendo archivo...");
		} else {
			alert(errores);
		}
	}
	archivoInput.value="";
	
}

function agregarAdjuntoUsuarioFunc(){
	with(document.datos){
		var errores = "";
		if(archivo_agregar.value==""){
			errores+="- Debe elegir un archivo para subir";
		}
		
		if(errores==""){
			accion.value="addAdjunto";
			action="ProcesarAdjuntoUsuario.php";
			target="frmImg";
			submit();
		} else {
			alert(errores);
		}
	}
}

function insertarArea(varCampoCantidad, varCampoAreaIdGuardar, varCajaSeleccion, varAreaElegirNombre, valor)
{
	
	if(valor!=""){
		params="&"+varCampoCantidad+"=1&"+varAreaElegirNombre+"1="+valor;
		params+="&"+varCampoCantidad+"="+$("#"+varCampoCantidad).val()+"&"+varAreaElegirNombre+"1="+valor;
	} else {
		params=$("select").serialize();
		//params+="&cant_areaId="+$("#cant_areaId").val();
		params+="&"+varCampoCantidad+"="+$("#"+varCampoCantidad).val();
	}


	params+="&"+$('input[name^="'+varCampoAreaIdGuardar+'"]').serialize();
	params+="&areaId_guardar_campo="+varCampoAreaIdGuardar;
	params+="&cant_areaId_campo="+varCampoCantidad;
	params+="&areaId_agregada="+varCampoAreaIdGuardar;
	params+="&areaElegir="+varAreaElegirNombre;
	$.ajax({
        	beforeSend: function(){


		},
        complete: function(){ /*$("#cargando").hide("fast");*/},
		success: function(html){
			switch(html){
				case "-1":
					alert("Esta opción ya fue insertada.");
				break;
				default:
					$("#"+varAreaElegirNombre).append(html);
					window[varCampoCantidad]++;
				break;
			}
        },
        method: "post",url: "insertArea.php",data: params, contentType : "application/x-www-form-urlencoded; charset=utf-8"
	}); //close $.ajax(
}

function insertarAreaInteres(valor)
{
	if(valor!=""){
		params="cant_areaId=1&areaId1="+valor;
	} else {
		params=$("select").serialize();
		params+="&cant_areaId="+$("#cant_areaId").val();
	}
	params+="&"+$(":hidden").serialize();
	$.ajax({
        	beforeSend: function(){
			$("#carga").show();
		
		},
        	complete: function(){ /*$("#cargando").hide("fast");*/},
		success: function(html){
			switch(html){
				case "-1":
					alert("Este área ya fue insertado.");
				break;
				case "-2":
					alert("Usted ha sido bloqueado para escribir en este Área.\nAnte cualquier duda contacte al webmaster.");
				break;
				default:
					$("#form-areas-interes-seleccionadas").append(html);
				break;
			}
			$("#carga").hide();
	
                },
        	method: "post",url: "insertAreaEscribir.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	}); //close $.ajax(
	$("#texto_area").html("");
}

function insertarAreaInteresBuscador(valor)
{
	if(valor!=""){
		params="cant_areaId=1&areaId1="+valor;
	} else {
		params=$("select").serialize();
		params+="&cant_areaId="+$("#cant_areaId").val();
	}
	params+="&"+$(":hidden").serialize();
	$.ajax({
        	beforeSend: function(){
			$("#carga").show();
		},
        	complete: function(){ /*$("#cargando").hide("fast");*/},
		success: function(html){
			switch(html){
				case "-1":
				break;
				default:
					$("#form-areas-interes-seleccionadas").append(html);
				break;
			}
			$("#carga").hide();
                },
        	method: "post",url: "insertArea.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
	}); //close $.ajax(
}


function insertarTag(valor, cant_tags, tag_id, separador)
{
	if(valor!=""){
		var valores=valor.split(separador);
		for(i=0;i<valores.length;i++){
			cant_tags++;
			$("#cant_tags").val(cant_tags);
			vinculo="<div id=\"tag_"+$("#cant_tags").val()+"\"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a href=\"javascript:eliminarTag('tag_"+$("#cant_tags").val()+"')\">eliminar</a>&nbsp;<img src=\"imagenes/bullet-acciones.gif\" />&nbsp;</span>"+valores[i];
			if(tag_id!=''){
				vinculo=vinculo+"<input type=\"hidden\" name=\"tag_id_guardar[]\" value=\""+tag_id+"\">";
			} else {
				vinculo=vinculo+"<input type=\"hidden\" name=\"tag_valor_guardar[]\" value=\""+valores[i]+"\">";
			}
			vinculo=vinculo+"</div></div>";
			$("#tag-seleccionado").append(vinculo);
		}
	}
}

function eliminarTag(_id)
{
	$("#"+_id).remove();
}


function insertarLink(valor, cant_links, lnk_id)
{
	if(valor!=""){
		cant_links++;
		$("#cant_links").val(cant_links);
		if(valor.substring(0,7)!="http://"){
			valor="http://"+valor;
		}
			vinculo="<div id=\"link_"+$("#cant_links").val()+"\"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a href=\"javascript:eliminarLink('link_"+$("#cant_links").val()+"')\">eliminar</a>&nbsp;<a href=\""+valor+"\" target=\"_blank\">"+valor+"</a>";
			if(lnk_id!=''){
				vinculo=vinculo+"<input type=\"hidden\" name=\"link_id_guardar[]\" value=\""+lnk_id+"\">";
			} else {
				vinculo=vinculo+"<input type=\"hidden\" name=\"link_url_guardar[]\" value=\""+valor+"\">";
			}
			vinculo=vinculo+"</div></div>";
			$("#link-seleccionado").append(vinculo);

	}
}

function eliminarLink(_id)
{
	$("#"+_id).remove();
}


function insertarImagen(valor, caption, cant_img, lnk_id, carpeta, tamanio, varAccion)
{
	if(valor!=""){
		cant_img++;
		$("#cant_img").val(cant_img);
		vinculo='<div id="imagen_'+$("#cant_img").val()+'"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a href="javascript:eliminarImagenConsulta(\'imagen_'+$("#cant_img").val()+'\', \''+varAccion+'\', \''+carpeta+'\', \''+valor+'\')" class="eliminarimg">eliminar</a>&nbsp;<img src="'+carpeta+'/'+valor+'" '+tamanio+' />';
		if(lnk_id!=''){
			vinculo=vinculo+"<input type=\"hidden\" name=\"img_id_guardar[]\" value=\""+lnk_id+"\">";
			vinculo=vinculo+"<input type=\"hidden\" name=\"cap_"+lnk_id+"\" maxlength=\"255\" value=\""+caption+"\">";
		} else {
			vinculo=vinculo+"<input type=\"hidden\" name=\"cap[]\" id=\"cap\" maxlength=\"255\" value=\"\">";
			vinculo=vinculo+"<input type=\"hidden\" name=\"img[]\" value=\""+valor+"\">";
		}
		vinculo=vinculo+"</div></div>";
		$("#imagen-seleccionada").append(vinculo);

	}
}

function insertarAdjunto(valor, caption, cant_adj, lnk_id, carpeta, varAccion, varProducto)
{
	if(valor!=""){
		cant_adj++;
		$("#cant_adj").val(cant_adj);
			vinculo="<div id=\"adjunto_"+$("#cant_adj").val()+"\"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a href=\"javascript:eliminarAdjunto('adjunto_"+$("#cant_adj").val()+"', '"+varAccion+"', '"+carpeta+"', '"+valor+"', '"+varProducto+"' )\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;&nbsp;<a href=\""+carpeta+"/"+valor+"\" target=\"_blank\" class=\"texto12gris\">Ver Adjunto</a>";
			if(lnk_id!=''){
				vinculo=vinculo+"<input type=\"hidden\" name=\"adj_id_guardar[]\" value=\""+lnk_id+"\">";
			} else {
				vinculo=vinculo+"<input type=\"hidden\" name=\"adj[]\" value=\""+valor+"\">";
			}
			vinculo=vinculo+"</div></div>";
			$("#adjuntoUsuario").html("");
			$("#adjunto-seleccionado").append(vinculo);

	}
}
function insertarAdjuntoCustom(valor, caption, cant_adj, lnk_id, carpeta, varAccion, varCant,varNombreAdjunto,varSeleccionado,varDestino,varTipoAdj,varFecha)
{
	if(valor!=""){
		cant_adj++;
		$("#"+varCant).val(cant_adj);
			vinculo="<div id=\""+varNombreAdjunto+"_"+$("#"+varCant).val()+"\"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a href=\"javascript:eliminarAdjuntoCustom('"+varNombreAdjunto+"_"+$("#"+varCant).val()+"', '"+varAccion+"', '"+carpeta+"', '"+valor+"','"+varCant+"','"+varSeleccionado+"','"+varNombreAdjunto+"','"+lnk_id+"')\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;&nbsp;<a href=\""+carpeta+"/"+valor+"\" target=\"_blank\" class=\"texto12gris\">Ver Adjunto</a>";
			if(varAccion=="removeAdjunto"){
				vinculo=vinculo+" <b>Fecha: </b>"+varFecha;
			}
			if(lnk_id!=''){
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"_id_guardar[]\" value=\""+lnk_id+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"_id_guardar_tipo[]\" value=\""+varTipoAdj+"\">";
			} else {
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"[]\" value=\""+valor+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"_tipo[]\" value=\""+varTipoAdj+"\">";
			}

			vinculo=vinculo+"</div></div>";
			$("#"+varDestino).html("");
			$("#"+varSeleccionado).append(vinculo);

	}
}
function insertarAdjuntoCustomTipo(valor, caption, cant_adj, lnk_id, carpeta, varAccion, varCant,varNombreAdjunto,varSeleccionado,varDestino,varTipoAdj,varFecha,varTextoTipoAdj)
{
	if(valor!=""){
		cant_adj++;
		$("#"+varCant).val(cant_adj);
			vinculo="<div id=\""+varNombreAdjunto+"_"+$("#"+varCant).val()+"\"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a class=\"boton_borrar_archivo\" id=\"boton_borrar_archivo_"+lnk_id+"\" href=\"javascript:eliminarAdjuntoCustom('"+varNombreAdjunto+"_"+$("#"+varCant).val()+"', '"+varAccion+"', '"+carpeta+"', '"+valor+"','"+varCant+"','"+varSeleccionado+"','"+varNombreAdjunto+"','"+lnk_id+"')\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;&nbsp;<a href=\""+carpeta+"/"+valor+"\" target=\"_blank\" class=\"texto12gris\">Ver Adjunto</a>";
			if(varAccion=="removeAdjunto"){
				vinculo=vinculo+" <b>Fecha: </b>"+varFecha;
			}
			if(varTextoTipoAdj!=""){
				vinculo=vinculo+" - <b>"+varTextoTipoAdj+"</b>";
			}
			if(lnk_id!=''){
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"_id_guardar[]\" value=\""+lnk_id+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"_id_guardar_tipo[]\" value=\""+varTipoAdj+"\">";
			} else {
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"[]\" value=\""+valor+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\""+varNombreAdjunto+"_tipo[]\" value=\""+varTipoAdj+"\">";
			}

			vinculo=vinculo+"</div></div>";
			$("#"+varDestino).html("");
			$("#"+varSeleccionado).append(vinculo);

	}
}

function insertarAdjuntoBack(valor, caption, cant_adj, lnk_id, carpeta, varAccion)
{
	if(valor!=""){
		cant_adj++;
		$("#cant_adj").val(cant_adj);
			vinculo="<div id=\"adjunto_"+$("#cant_adj").val()+"\"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a href=\"javascript:eliminarAdjuntoBack('adjunto_"+$("#cant_adj").val()+"', '"+varAccion+"', '"+carpeta+"', '"+valor+"' )\"><img src=\"/images/bot_eliminar.gif\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;<a href=\"../"+carpeta+"/"+valor+"\" target=\"_blank\">"+caption+"</a>";
			if(lnk_id!=''){
				vinculo=vinculo+"<input type=\"hidden\" name=\"adj_id_guardar[]\" value=\""+lnk_id+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\"cap_adj_"+lnk_id+"\" value=\""+caption+"\">";
			} else {
				vinculo=vinculo+"<input type=\"hidden\" name=\"adj[]\" value=\""+valor+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\"cap_adj[]\" value=\""+caption+"\">";
			}
			vinculo=vinculo+"</div></div>";
			$("#adjuntoUsuario").html("");
			$("#adjunto-seleccionado").append(vinculo);

	}
}

function insertarAdjuntoUsuario(valor, caption, cant_adj, lnk_id, carpeta, varAccion)
{
	if(valor!=""){
		cant_adj++;
		$("#cant_adj").val(cant_adj);
			vinculo="<div id=\"adjunto_"+$("#cant_adj").val()+"\"><div id=\"form-item-intermedio\"><span class=\"form-item-nombre\">&nbsp;</span><a href=\""+carpeta+"/"+valor+"\" target=\"_blank\">"+caption+"</a>";
			if(lnk_id!=''){
				vinculo=vinculo+"<input type=\"hidden\" name=\"adj_id_guardar[]\" value=\""+lnk_id+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\"cap_adj_"+lnk_id+"\" value=\""+caption+"\">";
			} else {
				vinculo=vinculo+"<input type=\"hidden\" name=\"adj[]\" value=\""+valor+"\">";
				vinculo=vinculo+"<input type=\"hidden\" name=\"cap_adj[]\" value=\""+caption+"\">";
			}
			vinculo=vinculo+"</div></div>";
			$("#adjunto-seleccionado").html(vinculo);

	}
}

function eliminarImagenConsulta(_id, varAccion, carpeta, valor)
{
	$("#"+_id).remove();
	switch(varAccion){
		case "addImagen":
			/*se acaba de agregar entonces si se eliminar, tambien lo elimino de los temporales*/
			params="accion=borrarImagenTemporal&carpeta="+carpeta+"&img="+valor;
			$.ajax({
		        	beforeSend: function(){
							
				}, //show loading just when link is clicked
		        	complete: function(){ }, 
				success: function(html){ 

		                },
		        	method: "post",url: "ProcesarImagen.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
			}); //close $.ajax(
		break;
	}

}

function eliminarAdjuntoBack(_id, varAccion, carpeta, valor)
{
	if(confirm("¿Está seguro que desea eliminar este archivo?")){
		$("#"+_id).remove();
		switch(varAccion){
			case "addAdjunto":
				/*se acaba de agregar entonces si se eliminar, tambien lo elimino de los temporales*/
				params="accion=borrarAdjuntoTemporal&carpeta="+carpeta+"&img="+valor;
				$.ajax({
			        	beforeSend: function(){
								
					}, //show loading just when link is clicked
		        		complete: function(){ }, 
					success: function(html){ 
						var cant=parseInt($("#cant_adj").val(),10);
						$("#cant_adj").val(cant-1);
			                },
			        	method: "post",url: "../ProcesarAdjunto.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				}); //close $.ajax(
			break;
		}
	}
}


function eliminarAdjunto(_id, varAccion, carpeta, valor, varProducto)
{
	if(confirm("¿Está seguro que desea eliminar este archivo?")){
		$("#"+_id).remove();
		switch(varAccion){
			case "addAdjunto":
				/*se acaba de agregar entonces si se eliminar, tambien lo elimino de los temporales*/
				params="accion=borrarAdjuntoTemporal&carpeta="+carpeta+"&img="+valor;
				$.ajax({
			        	beforeSend: function(){
								
					}, //show loading just when link is clicked
		        		complete: function(){ }, 
					success: function(html){ 
						var cant=parseInt($("#cant_adj").val(),10);
						$("#cant_adj").val(cant-1);
			                },
			        	method: "post",url: "ProcesarAdjunto.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				}); //close $.ajax(
			break;
			case "removeAdjunto":
				$("#adjunto-seleccionado").append("<input type=\"hidden\" name=\"adj_id_borrar[]\" value=\""+valor+"\">");
				var cant=parseInt($("#cant_adj").val(),10);
				$("#cant_adj").val(cant-1);
			break;
		}
	}
}
function eliminarAdjuntoCustom(_id, varAccion, carpeta, valor,varCant,varSeleccionado,varNombreAdjunto,varLnkId)
{
	if(confirm("¿Está seguro que desea eliminar este archivo?")){
		$("#"+_id).remove();
		switch(varAccion){
			case "addAdjunto":
				/*se acaba de agregar entonces si se eliminar, tambien lo elimino de los temporales*/
				params="accion=borrarAdjuntoTemporal&carpeta="+carpeta+"&img="+valor;
				$.ajax({
			        	beforeSend: function(){
								
					}, //show loading just when link is clicked
		        		complete: function(){ }, 
					success: function(html){ 
						var cant=parseInt($("#"+varCant).val(),10);
						$("#"+varCant).val(cant-1);
			                },
			        	method: "post",url: "ProcesarAdjuntoCustom.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				}); //close $.ajax(
			break;
			case "removeAdjunto":
				$("#"+varSeleccionado).append("<input type=\"hidden\" name=\""+varNombreAdjunto+"_id_borrar[]\" value=\""+varLnkId+"\">");
				var cant=parseInt($("#"+varCant).val(),10);
				$("#"+varCant).val(cant-1);
			break;
		}
	}
}

function eliminarAreaInteres(_id, varCantidadCampo)
{
	$("#"+_id).remove();
	window[varCantidadCampo]--;
}


	function agregarFotoFunc(){
		with(document.datos){
			var errores = "";
			if(archivo.value==""){
				errores+="- Debe elegir el archivo con la imagen para subir.";
			}
			
			if(errores==""){
				accion.value="addImagen";
				action="ProcesarImagenMember.php";
				target="frmImg";
				submit();
			} else {
				alert(errores);
			}
		}
	}

	function agregarFotoFuncEmpresa(){
		with(document.datos){
			var errores = "";
			if(archivo.value==""){
				errores+="- Debe elegir un archivo para subir";
			}
			
			if(errores==""){
				accion.value="addImagen";
				action="../ProcesarImagenEmpresa.php";
				target="frmImg";
				submit();
			} else {
				alert(errores);
			}
		}
	}

	function agregarFotoFuncEmpresaFront(){
		with(document.datos){
			var errores = "";
			if(archivo.value==""){
				errores+="- Debe elegir un archivo para subir";
			}
			
			if(errores==""){
				accion.value="addImagen";
				action="ProcesarImagenEmpresaFront.php";
				target="frmImg";
				submit();
			} else {
				alert(errores);
			}
		}
	}

function cambiarEstadoAttend(){
	with(document.datos){
		accion.value="CAMBIARATTEND";
		submit();
	}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

/***********************************************
* Textarea Maxlength script- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

function ismaxlength(obj){
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength)
}

function showAdvanced(capa){
	hideMenu('resulCOM');
	hideMenu('resulNET');
	mi_capa=document.getElementById(capa);
	mi_capa.style.visibility='visible';

	if(capa=="resulCOM"){
		changeBotoneraCOM();
	}
	if(capa=="resulNET"){
		changeBotoneraNET();
	}
}

function hideMenu(capa){
	mi_capa=document.getElementById(capa);
	mi_capa.style.visibility='hidden';
}
	
function sendEmail(id_usuario){
	$("#mensaje-perfil").show();
	$("#error-mensaje-perfil").hide();
}

function enviarMensaje(varId_usuario, errorSubject, errorMensaje)
{
	var errores = "";
	var elemFoco = "";

	with(document.datos)
	{

		if(asunto.value == "")
		{
			errores += "- "+errorSubject+"\n";
			if(elemFoco == "") elemFoco = "asunto";
		}
		if(mensaje.value == "")
		{
			errores += "- "+errorMensaje+"\n";
			if(elemFoco == "") elemFoco = "mensaje";
		}
		if(errores == "")
		{
			params="accion=ENVIAR&mensaje="+escape(mensaje.value)+"&asunto="+asunto.value+"&id_usuario="+varId_usuario;
			$.ajax({
		        	beforeSend: function(){
					//nada
				},
		        	complete: function(){ 
					//nada
				},
				success: function(html){
					$("#mensaje-perfil").hide();
					$("#error-mensaje-perfil").html(html);
					$("#error-mensaje-perfil").show();
		                },
        			method: "post",url: "emailUser.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
			}); //close $.ajax(
		}
		else
		{
			alert(errores);
			SetFocus(eval(elemFoco));
		}
	}
}

function buscar()
{
	with(document.datos)
	{
		action="";
		if (typeof pagina != "undefined") {
			pagina.value="1";
		}

		submit();
	}
}
function buscarDestino(varDest)
{
	with(document.datos)
	{
		action="#"+varDest;
		if (typeof pagina != "undefined") {
			pagina.value="1";
		}

		submit();
	}
}

function buscarDestinoLen(varDest)
{
	with(document.datos)
	{
		action=varDest;
		if (typeof pagina != "undefined") {
			pagina.value="1";
		}

		submit();
	}
}

function buscarAdvanced()
{
	with(document.datos)
	{
		action="advancedSearch.php";
		if (typeof pagina != "undefined") {
			pagina.value="1";
		}
		submit();
	}
}


function buscarAvanzadoOpcion()
{
	with(document.datos)
	{
		action="advancedSearch.php";
		if (typeof pagina != "undefined") {
			pagina.value="1";
		}
		if(keyword.value=="Search"){
			keyword.value="";
		}
		keyword.value=busqueda.value;
		submit();
	}
}


function eliminarSeleccionados()
{
	with(document.datos)
	{
		if(confirm("¿Está seguro que desea eliminar los items seleccionados?"))
		{
			accion.value = "ELIMINAR";
			submit();
		}
	}
}

function irPaginaCustom(varP, varCampo, varAccion, varDestino)
{
	document.datos.accion.value=varAccion;
	document.datos.action=varDestino;
	document.datos[varCampo].value=varP;
	document.datos.submit();
}

function ir(p)
{
	with(document.datos)
	{
		action="";
		pagina.value = p;
		submit();
	}
}




function SetRecordFocus(cId)
{
	document.getElementById(cId).style.backgroundColor = "#F5F5F5";
}

function UnSetRecordFocus(cId)
{
	document.getElementById(cId).style.backgroundColor = "white";
}

function ordenar(campo)
{
	with(document.datos)
	{
		if(orden_campo.value != campo)
		{
			orden_campo.value = campo;
			orden_direccion.value = "ASC";
		}
		else
		{
			if(orden_direccion.value == "ASC")
				orden_direccion.value = "DESC";
			else
				orden_direccion.value = "ASC";
		}
		
		submit();
		
	}
}

function Expand(cSectionName)
{
	document.getElementById("tbl" + cSectionName).style.display = "";
	document.getElementById("img" + cSectionName).src = "images/ButtonCollapse.gif";
}

function Collapse(cSectionName)
{
	document.getElementById("tbl" + cSectionName).style.display = "none";
	document.getElementById("img" + cSectionName).src = "images/ButtonExpand.gif";
}

function ExpandCollapse(cSectionName)
{
	if (document.getElementById("tbl" + cSectionName).style.display == "none")
		Expand(cSectionName);
	else
		Collapse(cSectionName);
}

function checkEmail(varEmail) {
    var re = /\S+@\S+\.\S+/;
    return re.test(varEmail);

}

function SetFocus(elemFoco)
{
	try
	{
		//var oTable = GetParentTable(elemFoco);
		//if(oTable != "") Expand(oTable);
		elemFoco.focus();
	}
	catch(e)
	{
		alert(e.description);
	}
}
var globday;
function leapYear (Year) {
  if (((Year % 4)==0) && ((Year % 100)!=0) || ((Year % 400)==0))
    return (1);
  else
    return (0);
}

function getDaysInMonth(month,year)  {
  var days;
  if (month==1 || month==3 || month==5 || month==7 || month==8 || month==10 || month==12)
    days=31;
  else if (month==4 || month==6 || month==9 || month==11)
    days=30;
  else if (month==2) {
    if (leapYear (year)==1)
      days=29;
    else
      days=28;
  }
  globday=days;
  return (days);
}

function isDateValid(dia, mes, anio) {
  var valDay = dia;
  var valMonth = mes;
  var valYear = anio;

  if (valDay > getDaysInMonth(valMonth, valYear))
    return false;

  return true;
}
function isDateValidFull(fecha, sep) {
  var fechaArr = fecha.split(sep);
  if(fechaArr.length!=3){
	return false;  
  }
  var valDay = parseInt(fechaArr[0],10);
  var valMonth = parseInt(fechaArr[1],10);
  var valYear = parseInt(fechaArr[2],10);

  if(isNaN(valDay) || isNaN(valMonth) || isNaN(valYear)){
	return false;  
  }

  if(valMonth>12 || valMonth<1){
		return false;  
  }
  if (valDay > getDaysInMonth(valMonth, valYear) || getDaysInMonth(valMonth, valYear)==='undefined')
    return false;

  return true;
}
