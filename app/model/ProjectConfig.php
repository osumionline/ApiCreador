<?php
class ProjectConfig extends OBase{
  function __construct(){
    $table_name  = 'project_config';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único para cada proyecto'
        ],
        'id_project' => [
          'type'     => Base::NUM,
          'nullable' => false,
          'comment'  => 'Id del proyecto al que pertenece la configuración',
          'ref'      => 'project.id'
        ],
        'db_host' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => true,
          'comment'  => 'Host de la base de datos'
        ],
        'db_user' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => true,
          'comment'  => 'Nombre de usuario para la base de datos'
        ],
        'db_pass' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'Contraseña cifrada para la base de datos'
        ],
        'db_name' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => true,
          'comment'  => 'Nombre de la base de datos'
        ],
        'cookies_prefix' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => true,
          'comment'  => 'Prefijo para las cookies'
        ],
        'cookies_url' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'URL para las cookies'
        ],
        'module_browser' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo browser 1 o no 0'
        ],
        'module_email' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo email 1 o no 0'
        ],
        'module_email_smtp' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo browser 1 o no 0'
        ],
        'module_ftp' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo ftp 1 o no 0'
        ],
        'module_image' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo image 1 o no 0'
        ],
        'module_pdf' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo pdf 1 o no 0'
        ],
        'module_translate' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo translate 1 o no 0'
        ],
        'module_crypt' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => false,
          'comment'  => 'Indica si habilitar el módulo crypt 1 o no 0'
        ],
        'base_url' => [
          'type'     => Base::TEXT,
          'size'     => 250,
          'nullable' => true,
          'comment'  => 'URL base de la aplicación'
        ],
        'admin_email' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'Dirección email para notificaciones al admin'
        ],
        'default_title' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'Título por defecto para las páginas'
        ],
        'lang' => [
          'type'     => Base::TEXT,
          'size'     => 10,
          'nullable' => true,
          'comment'  => 'Código de idioma por defecto'
        ],
        'smtp_host' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'Host para el envío de emails por SMTP'
        ],
        'smtp_port' => [
          'type'     => Base::TEXT,
          'size'     => 5,
          'nullable' => true,
          'comment'  => 'Puerto para el envío de emails por SMTP'
        ],
        'smtp_secure' => [
          'type'     => Base::TEXT,
          'size'     => 10,
          'nullable' => true,
          'comment'  => 'Tipo de cifrado para el envío de emails por SMTP'
        ],
        'smtp_user' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => true,
          'comment'  => 'Nombre de usuario para el envío de emails por SMTP'
        ],
        'smtp_pass' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'Contraseña cifrada para el envío de emails por SMTP'
        ],
        'error_403' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'URL al que redirigir en caso de error 403'
        ],
        'error_404' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'URL al que redirigir en caso de error 404'
        ],
        'error_500' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => true,
          'comment'  => 'URL al que redirigir en caso de error 500'
        ],
        'created_at' => [
          'type'    => Base::CREATED,
          'comment' => 'Fecha de creación del registro'
        ],
        'updated_at' => [
          'type'    => Base::UPDATED,
          'comment' => 'Fecha de última modificación del registro'
        ]
    ];

    parent::load($table_name, $model);
  }
}