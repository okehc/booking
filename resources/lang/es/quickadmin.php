<?php

return [
	
	'user-management' => [
		'title' => 'Administración de usuarios',
		'fields' => [
		],
	],
	
	'roles' => [
		'title' => 'Roles',
		'fields' => [
			'title' => 'Título',
		],
	],
	
	'users' => [
		'title' => 'Usuarios',
		'fields' => [
			'name' => 'Nombre',
			'apellido-paterno' => 'Apellido Paterno',
			'apellido-materno' => 'Apellido Materno',
			'ubicacion' => 'Ubicación',
			'departamento' => 'Departamento',
			'extension' => 'Extensión',
			'email' => 'Correo',
			'password' => 'Contraseña',
			'role' => 'Rol',
			'remember-token' => 'Recordar token',
		],
	],
	
	'reservacion' => [
		'title' => 'Mis Reservaciones',
		'fields' => [
			'nombre-de-reunion' => 'Reunión',
			'ubicacion' => 'Ubicación',
			'sala-de-juntas' => 'Sala de Juntas',
			'invitados' => 'Invitados',
			'hora-duracion' => 'Fecha de inicio',
			'hora-inicio' => 'Hora de inicio',
			'minuto-duracion' => 'Tiempo de duración',
			'repeat' => 'Repetir?',
			'concurrencia' => 'concurrencia',
			'comentario' => 'Mensaje',
			'tiempo' => 'Tiempo duración',
			'file' => 'Archivo a subir',
			'guest' => 'Invitados',
		],
	],
	
	'ubicaciones' => [
		'title' => 'Adminitración de Ubicaciones',
		'fields' => [
			'nombre' => 'Nombre de Ubicación',
			'ciudad' => 'Ciudad',
			'estado' => 'Estado',
		],
	],
	
	'accesos' => [
		'title' => 'Adminitración de Accesos',
		'fields' => [
			'nombre-acceso' => 'Nombre del Acceso',
			'id-ubicacion' => 'Ubicación',
		],
	],
	
	'seccion' => [
		'title' => 'Administración de Salas',
		'fields' => [
			'id-ubicacion' => 'Ubicación',
			'nombre-seccion' => 'Nombre de Sala',
			'id-atributos' => 'Atributos de la Sala',
			'ctd-personas' => 'Ctd. Invitados',
		],
	],
	
	'administracion' => [
		'title' => 'Administración',
		'fields' => [
		],
	],
	
	'adminitracion' => [
		'title' => 'Adminitración General',
		'fields' => [
		],
	],

	'items' => [
		'title' => 'Administración de Items',
		'fields' => [
			'item-nombre' => 'Nombre del Item',
			'item-descripcion' => 'Descripción del Item',
		],
	],
	'departamentos' => [
		'title' => 'Administración Departamentos',
		'fields' => [
			'departamento' => 'Departamento',
			'descripcion' => 'Descripción',
		],
	],
	'busquedas' => [
		'title' => 'Busquedas',
		'fields' => [
			'fehca' => 'Fehca',
			'ubicacion' => 'Ubicacion',
			'no-personas' => 'No. personas',
		],
	],	
	'qa_create' => 'Crear',
	'qa_save' => 'Guardar',
	'qa_edit' => 'Editar',
	'qa_view' => 'Ver',
	'qa_push' => 'Enviar Push',
	'qa_update' => 'Actualizar',
	'qa_list' => 'Lista de Reservaciones',
	'qa_list_old' => 'Lista de Reservaciones pasadas',
	'qa_no_entries_in_table' => 'Sin valores en la tabla',
	'qa_custom_controller_index' => 'Índice del controlador personalizado (index).',
	'qa_logout' => 'Salir',
	'qa_add_new' => 'Agregar',
	'qa_are_you_sure' => 'Estás seguro?',
	'qa_back_to_list' => 'Regresar a la lista?',
	'qa_dashboard' => 'Tablero de control',
	'qa_delete' => 'Eliminar',
	'qa_restore' => 'Restaurar',
	'qa_permadel' => 'Borrar permanentemente',
	'qa_all' => 'Todos',
	'qa_trash' => 'Papelera',
	'qa_delete_selected' => 'Eliminar seleccionado',
	'qa_category' => 'Categoría',
	'qa_categories' => 'Categorias',
	'qa_title' => 'Título',
	'qa_roles' => 'Roles',
	'qa_role' => 'Rol',
	'qa_user_management' => 'Administración de usuarios',
	'qa_users' => 'Usuarios',
	'qa_user' => 'Usuario',
	'qa_name' => 'Nombre',
	'qa_email' => 'Correo',
	'qa_password' => 'Contraseña',
	'qa_remember_token' => 'Recordar token',
	'qa_permissions' => 'Permisos',
	'qa_client' => 'Cliente',
	'qa_current_password' => 'Contraseña actual',
	'qa_new_password' => 'Contraseña nueva',
	'qa_password_confirm' => 'Confirmación de contraseña nueva',
	'qa_dashboard_text' => 'Ha iniciado sesión',
	'qa_forgot_password' => 'Olvidó su contraseña?',
	'qa_remember_me' => 'Recuerdame',
	'qa_login' => 'Iniciar sesión',
	'qa_copy' => 'Copiar',
	'qa_reset_password' => 'Reiniciar contraseña',
	'qa_email_greet' => 'Hola',
	'qa_confirm_password' => 'Confirmar contraseña',
	'qa_please_select' => 'Por favor seleccione',
	'qa_questions' => 'Preguntas',
	'qa_question' => 'Pregunta',
	'qa_answer' => 'Respuesta',
	'qa_project' => 'Proyecto',
	'qa_expenses' => 'Gastos',
	'qa_expense' => 'Gasto',
	'qa_amount' => 'Cantidad',
	'qa_address' => 'Dirección',
	'qa_contacts' => 'Contactos',
	'qa_first_name' => 'Nombre',
	'qa_last_name' => 'Apellido',
	'qa_phone' => 'Teléfono',
	'qa_category_name' => 'Nombre de categoría',
	'qa_products' => 'Productos',
	'qa_product_name' => 'Nombre de producto',
	'qa_price' => 'Precio',
	'qa_tag' => 'Etiqueta',
	'qa_photo1' => 'Foto 1',
	'qa_photo2' => 'Foto 2',
	'qa_photo3' => 'Foto 3',
	'qa_calendar' => 'Calendario',
	'qa_tasks' => 'Tareas',
	'qa_status' => 'Estado',
	'quickadmin_title' => 'Walgreens Boot Aliance Calendar Manager',
];