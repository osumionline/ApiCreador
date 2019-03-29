<?php
class Tag extends OBase{
  function __construct(){
    $table_name  = 'tag';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Unique id for every tag'
        ],
        'name' => [
          'type'     => Base::TEXT,
          'size'     => 20,
          'nullable' => false,
          'comment'  => 'Name of the tagg'
        ],
        'id_user' => [
          'type'     => Base::NUM,
          'nullable' => true,
          'default'  => null,
          'comment'  => 'Id of the user owner of the tag',
          'ref'      => 'user.id'
        ],
        'created_at' => [
          'type'    => Base::CREATED,
          'comment' => 'Row creation date'
        ],
        'updated_at' => [
          'type'    => Base::UPDATED,
          'comment' => 'Rows last update date'
        ]
    ];

    parent::load($table_name, $model);
  }
  
  public function __toString(){
    return $this->get('name');
  }
}
