<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Permisos</title>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css"> <!--Iconos-->   
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500" rel="stylesheet">  
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">  
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script>
        $(document).ready(function(e) {
            $('#solicitud_permiso').click(function(event)
            {
                $('#principal').load('<?php echo base_url(); ?>index.php/menu_principal/solicitud_permiso',function(data)
                {
                    $(this).html(data);
                });
            });

            $('#historial_solicitud').click(function(event)
            {
                $('#principal').load('<?php echo base_url(); ?>index.php/menu_principal/historial_permisos_solicitados',function(data)
                {
                    $(this).html(data);
                });
            });
            

            $('#salir').click(function(event)
            {
                                
                //unset($nombre);
                //window.location="http://localhost/sistema_permisos";
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/validacion/salir",
                    dataType: 'script',
                    success:function(result)
                    {
                        window.location="<?php echo base_url(); ?>";
                    }                    
                });

            });

            //se carga por defecto la pantalla de historial de solicitudes
            $('#principal').load('<?php echo base_url(); ?>index.php/menu_principal/historial_permisos_solicitados',function(data)
                {
                    $(this).html(data);
                });
            });
    </script>
    <style type="text/css">

        #principal{ 
            border:1px;
            min-width: 60%;
            max-width: 72%;
            width:72%; 
            display:inline-block;
            overflow-y: scroll;    
        }
    </style>

</head>

<body class="body_alterno">
    <div class="container" style="width: -webkit-fill-available;">
        <div class="row">
            <div class="col-md-3 myform-cont" >
                <div class="myform-top">                    
                    <div class="myform-top-usuario-right">
                        <?php echo $nombre?>
                        <?php echo $apellido?>                        
                        <h3><?php echo $tipo_empleado;?></h3>
                    </div>
                    <div class="myform-top-usuario-left">
                            <img src="<?php echo base_url(); ?>images/usuario.png">
                    </div>                                  
                </div>

                <div class="myform-bottom-principal">
                                                        
                        <button id="solicitud_permiso" type="submit" class="option"><img src="<?php echo base_url(); ?>images/solicitud.png" align="left"/>Solicitud de Permiso</button>
                    
                        <button id="historial_solicitud" type="submit" class="option"><img src="<?php echo base_url(); ?>images/historial.png" align="left"/>Historial de Permisos Solicitados</button>
                   
                        <button id="salir" type="submit" class="option"><img src="<?php echo base_url(); ?>images/salir.png" align="left"/>Salir</button>                                                                               
                </div>                

            </div>

            <div id="principal" class="myform-principal"></div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
</body>
</html>
