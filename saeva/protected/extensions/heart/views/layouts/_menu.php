<?php
$currController 	= Yii::app()->controller->id;
$currControllers	= explode('/', $currController);
$currAction			= Yii::app()->controller->action->id;
$currRoute 			= Yii::app()->controller->getRoute();
$currRoutes			= explode('/', $currRoute);


if (yii::app()->user->checkAccess("admin"))  {                                                                        
$menu=
	array(
		
		array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon'=>'fa fa-home','active'=>($currController=='site' and $currAction=='index' )),
                //array('label'=>'Acerca de', 'url'=>array('/site/page', 'view'=>'about'),'icon'=>'fa fa-university','active'=>($currController=='site' and $currAction=='page' )),
                array('label'=>'Usuarios', 'url'=>'#', 'icon'=>'fa fa-users', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
                    array('label'=>'Crear usuario','icon'=>'fa fa-user-plus', 'url'=>array('/usuario/create', 'view'=>'usuario'),'active'=>($currController=='site' and $currAction=='page' )),
                    array('label'=>'Administración de usuarios','icon'=>'fa fa-key', 'url'=>array('/usuario/admin'),'visible'=>!Yii::app()->user->isGuest),
			//array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
			//'---',
			//array('label'=>'NAV HEADER'),

        )),
		
                array('label'=>'Autoevaluacion', 'url'=>'#', 'icon'=>'fa fa-university','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction!='index') , 'items'=>array(
                        array('label'=>'Programa','icon'=>'fa fa-graduation-cap', 'url'=>array('/programa/admin', 'view'=>'programa'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Factor','icon'=>'fa fa-chevron-circle-down', 'url'=>array('/factor/admin', 'view'=>'factor'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Caracteristica','icon'=>'fa fa-pencil-square-o', 'url'=>array('/caracteristica/admin', 'view'=>'caracteristica'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Aspectos a evaluar','icon'=>'fa fa-bars', 'url'=>array('/aspectos/admin', 'view'=>'aspectos'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Ponderacion', 'url'=>'#','icon'=>'fa fa-calendar-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
                            array('label'=>'Factor','icon'=>'fa fa-share-alt-square', 'url'=>array('/califFactor/admin'),'visible'=>!Yii::app()->user->isGuest),
                            array('label'=>'Caracteristica','icon'=>'fa fa-signal', 'url'=>array('/calificacionCaracteristica/admin'),'active'=>($currController=='site' and $currAction=='page' )),


                        )),
                        array('label'=>'Link de las Encuestas', 'url'=>'#','icon'=>'fa fa-external-link-square', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
                            array('label'=>'Administrativos','icon'=>'fa fa-pencil-square-o', 'url'=>array('/tblAdministrativos/admin'),'visible'=>!Yii::app()->user->isGuest),
                            array('label'=>'Directivos','icon'=>'fa fa-pencil-square-o', 'url'=>array('/directivos/admin'),'active'=>($currController=='site' and $currAction=='page' )),
                            array('label'=>'Estudiantes','icon'=>'fa fa-pencil-square-o', 'url'=>array('/estudiantes/admin'),'active'=>($currController=='site' and $currAction=='page' )),
                            array('label'=>'Egresados','icon'=>'fa fa-pencil-square-o', 'url'=>array('/egresados/admin'),'active'=>($currController=='site' and $currAction=='page' )),
                            array('label'=>'Profesores','icon'=>'fa fa-pencil-square-o', 'url'=>array('/profesores/admin'),'active'=>($currController=='site' and $currAction=='page' )),


                        )),
			
                        //array('label'=>'Contact', 'url'=>array('/site/contact'),'active'=>($currController=='site' and $currAction=='contact' )),
			//'---',
			//array('label'=>'NAV HEADER'),
                
		)),

        array('label'=>'Encuestas','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/encuestas/admin/admin.php'), 'icon'=>'fa fa-calendar','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),
        array('label'=>'Documentos','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/documentoscmc/'), 'icon'=>'fa fa-file-text-o','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),

        // array('label'=>'Reportes', 'url'=>'#', 'icon'=>'fa fa-newspaper-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
        //     array('label'=>'Aspectos a evaluar','icon'=>'fa fa-file-pdf-o', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     array('label'=>'Ponderación','icon'=>'fa fa-pie-chart', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     //array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
        // )),

        array('label'=>'Backup', 'icon'=>'fa fa-archive', 'url'=>array('#'),'visible'=>!Yii::app()->user->isGuest),
    );

}


else if (yii::app()->user->checkAccess("Ingenieria")) {
  
$menu=
    array(
        
        array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon'=>'fa fa-home','active'=>($currController=='site' and $currAction=='index' )),
                //array('label'=>'Acerca de', 'url'=>array('/site/page', 'view'=>'about'),'icon'=>'fa fa-university','active'=>($currController=='site' and $currAction=='page' )),
        //         array('label'=>'Admin', 'url'=>'#', 'icon'=>'fa fa-cog', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
        //             array('label'=>'Crear usuario','icon'=>'fa fa-users', 'url'=>array('/usuario/create', 'view'=>'usuario'),'active'=>($currController=='site' and $currAction=='page' )),
        //             array('label'=>'Cambiar password','icon'=>'fa fa-key', 'url'=>array('/usuario/admin'),'visible'=>!Yii::app()->user->isGuest),
        //     //array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
        //     //'---',
        //     //array('label'=>'NAV HEADER'),

        // )),
        
                array('label'=>'Autoevaluacion', 'url'=>'#', 'icon'=>'fa fa-university','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction!='index') , 'items'=>array(
                       // array('label'=>'Programa','icon'=>'fa fa-graduation-cap', 'url'=>array('/programa/index', 'view'=>'programa'),'active'=>($currController=='site' and $currAction=='page' )),
                        //array('label'=>'Factor','icon'=>'fa fa-chevron-circle-down', 'url'=>array('/factor/index', 'view'=>'factor'),'active'=>($currController=='site' and $currAction=='page' )),
                       // array('label'=>'Caracteristica','icon'=>'fa fa-pencil-square-o', 'url'=>array('/caracteristica/index', 'view'=>'caracteristica'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Aspectos a evaluar','icon'=>'fa fa-bars', 
                            'url'=>array('/aspectos/index?Aspectos[tbl_Programa_id_programa]=1&yt1=', 'view'=>'aspectos'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Ponderacion', 'url'=>'#','icon'=>'fa fa-calendar-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
                            array('label'=>'Factor','icon'=>'fa fa-share-alt-square', 'url'=>array('/califFactor/index?CalifFactor[tbl_Programa_id_programa]=1&yt1='),'visible'=>!Yii::app()->user->isGuest),
                            array('label'=>'Caracteristica','icon'=>'fa fa-signal', 'url'=>array('/calificacionCaracteristica/index?CalificacionCaracteristica[tbl_Programa_id_programa]=1&yt1='),'active'=>($currController=='site' and $currAction=='page' )),


                        )),
            
                        //array('label'=>'Contact', 'url'=>array('/site/contact'),'active'=>($currController=='site' and $currAction=='contact' )),
            //'---',
            //array('label'=>'NAV HEADER'),
                
        )),

        array('label'=>'Encuestas','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/encuestas/admin/admin.php'), 'icon'=>'fa fa-calendar','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),
        array('label'=>'Documentos','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/documentoscmc/'), 'icon'=>'fa fa-file-text-o','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),

        // array('label'=>'Reportes', 'url'=>'#', 'icon'=>'fa fa-newspaper-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
        //     array('label'=>'Aspectos a evaluar','icon'=>'fa fa-file-pdf-o', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     array('label'=>'Ponderación','icon'=>'fa fa-pie-chart', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     //array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
        // )),

        //array('label'=>'Backup', 'icon'=>'fa fa-archive', 'url'=>array('/backup/default/index'),'visible'=>!Yii::app()->user->isGuest),
    );

}

else if (yii::app()->user->checkAccess("Arte")) {
  
$menu=
    array(
        
        array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon'=>'fa fa-home','active'=>($currController=='site' and $currAction=='index' )),
                //array('label'=>'Acerca de', 'url'=>array('/site/page', 'view'=>'about'),'icon'=>'fa fa-university','active'=>($currController=='site' and $currAction=='page' )),
        //         array('label'=>'Admin', 'url'=>'#', 'icon'=>'fa fa-cog', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
        //             array('label'=>'Crear usuario','icon'=>'fa fa-users', 'url'=>array('/usuario/create', 'view'=>'usuario'),'active'=>($currController=='site' and $currAction=='page' )),
        //             array('label'=>'Cambiar password','icon'=>'fa fa-key', 'url'=>array('/usuario/admin'),'visible'=>!Yii::app()->user->isGuest),
        //     //array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
        //     //'---',
        //     //array('label'=>'NAV HEADER'),

        // )),
        
                array('label'=>'Autoevaluacion', 'url'=>'#', 'icon'=>'fa fa-university','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction!='index') , 'items'=>array(
                       // array('label'=>'Programa','icon'=>'fa fa-graduation-cap', 'url'=>array('/programa/index', 'view'=>'programa'),'active'=>($currController=='site' and $currAction=='page' )),
                        //array('label'=>'Factor','icon'=>'fa fa-chevron-circle-down', 'url'=>array('/factor/index', 'view'=>'factor'),'active'=>($currController=='site' and $currAction=='page' )),
                        //array('label'=>'Caracteristica','icon'=>'fa fa-pencil-square-o', 'url'=>array('/caracteristica/index', 'view'=>'caracteristica'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Aspectos a evaluar','icon'=>'fa fa-bars', 
                            'url'=>array('/aspectos/index?Aspectos[tbl_Programa_id_programa]=2&yt1=', 'view'=>'aspectos'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Ponderacion', 'url'=>'#','icon'=>'fa fa-calendar-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
                            array('label'=>'Factor','icon'=>'fa fa-share-alt-square', 'url'=>array('/califFactor/index?CalifFactor[tbl_Programa_id_programa]=2&yt1='),'visible'=>!Yii::app()->user->isGuest),
                            array('label'=>'Caracteristica','icon'=>'fa fa-signal', 'url'=>array('/calificacionCaracteristica/index?CalificacionCaracteristica[tbl_Programa_id_programa]=2&yt1='),'active'=>($currController=='site' and $currAction=='page' )),


                        )),
            
                        //array('label'=>'Contact', 'url'=>array('/site/contact'),'active'=>($currController=='site' and $currAction=='contact' )),
            //'---',
            //array('label'=>'NAV HEADER'),
                
        )),

        array('label'=>'Encuestas','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/encuestas/admin/admin.php'), 'icon'=>'fa fa-calendar','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),
        array('label'=>'Documentos','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/documentoscmc/'), 'icon'=>'fa fa-file-text-o','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),

        // array('label'=>'Reportes', 'url'=>'#', 'icon'=>'fa fa-newspaper-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
        //     array('label'=>'Aspectos a evaluar','icon'=>'fa fa-file-pdf-o', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     array('label'=>'Ponderación','icon'=>'fa fa-pie-chart', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     //array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
        // )),

        //array('label'=>'Backup', 'icon'=>'fa fa-archive', 'url'=>array('/backup/default/index'),'visible'=>!Yii::app()->user->isGuest),
    );

}


else if (yii::app()->user->checkAccess("FCSA")) {
  
$menu=
    array(
        
        array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon'=>'fa fa-home','active'=>($currController=='site' and $currAction=='index' )),
                //array('label'=>'Acerca de', 'url'=>array('/site/page', 'view'=>'about'),'icon'=>'fa fa-university','active'=>($currController=='site' and $currAction=='page' )),
        //         array('label'=>'Admin', 'url'=>'#', 'icon'=>'fa fa-cog', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
        //             array('label'=>'Crear usuario','icon'=>'fa fa-users', 'url'=>array('/usuario/create', 'view'=>'usuario'),'active'=>($currController=='site' and $currAction=='page' )),
        //             array('label'=>'Cambiar password','icon'=>'fa fa-key', 'url'=>array('/usuario/admin'),'visible'=>!Yii::app()->user->isGuest),
        //     //array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
        //     //'---',
        //     //array('label'=>'NAV HEADER'),

        // )),
        
                array('label'=>'Autoevaluacion', 'url'=>'#', 'icon'=>'fa fa-university','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction!='index') , 'items'=>array(
                       // array('label'=>'Programa','icon'=>'fa fa-graduation-cap', 'url'=>array('/programa/index', 'view'=>'programa'),'active'=>($currController=='site' and $currAction=='page' )),
                        //array('label'=>'Factor','icon'=>'fa fa-chevron-circle-down', 'url'=>array('/factor/index', 'view'=>'factor'),'active'=>($currController=='site' and $currAction=='page' )),
                        //array('label'=>'Caracteristica','icon'=>'fa fa-pencil-square-o', 'url'=>array('/caracteristica/index', 'view'=>'caracteristica'),'active'=>($currController=='site' and $currAction=='page' )),
                         array('label'=>'Aspectos a evaluar','icon'=>'fa fa-bars', 
                            'url'=>array('/aspectos/index?Aspectos[tbl_Programa_id_programa]=3&yt1=', 'view'=>'aspectos'),'active'=>($currController=='site' and $currAction=='page' )),
                        array('label'=>'Ponderacion', 'url'=>'#','icon'=>'fa fa-calendar-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
                            array('label'=>'Factor','icon'=>'fa fa-share-alt-square', 'url'=>array('/califFactor/index?CalifFactor[tbl_Programa_id_programa]=3&yt1='),'visible'=>!Yii::app()->user->isGuest),
                            array('label'=>'Caracteristica','icon'=>'fa fa-signal', 'url'=>array('/calificacionCaracteristica/index?CalificacionCaracteristica[tbl_Programa_id_programa]=3&yt1='),'active'=>($currController=='site' and $currAction=='page' )),


                        )),
            
                        //array('label'=>'Contact', 'url'=>array('/site/contact'),'active'=>($currController=='site' and $currAction=='contact' )),
            //'---',
            //array('label'=>'NAV HEADER'),
                
        )),

        array('label'=>'Encuestas','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/encuestas/admin/admin.php'), 'icon'=>'fa fa-calendar','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),
        array('label'=>'Documentos','linkOptions'=>array('target'=>'_blank'), 'url'=>('http://www.colmayorcauca.edu.co/documentoscmc/'), 'icon'=>'fa fa-file-text-o','visible'=>!Yii::app()->user->isGuest,'active'=>($currController=='site' and $currAction=='page' )),

        // array('label'=>'Reportes', 'url'=>'#', 'icon'=>'fa fa-newspaper-o', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
        //     array('label'=>'Aspectos a evaluar','icon'=>'fa fa-file-pdf-o', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     array('label'=>'Ponderación','icon'=>'fa fa-pie-chart', 'url'=>array(''),'visible'=>!Yii::app()->user->isGuest),
        //     //array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
        // )),

        //array('label'=>'Backup', 'icon'=>'fa fa-archive', 'url'=>array('/backup/default/index'),'visible'=>!Yii::app()->user->isGuest),
    );

}


?>  








