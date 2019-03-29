<?php
class PhotoTag extends OBase{
  function __construct(){
    $table_name  = 'photo_tag';
    $model = [
        'id_photo' => [
          'type'    => Base::PK,
          'comment' => 'Photo id',
          'ref'     => 'photo.id'
        ],
        'id_tag' => [
          'type'    => Base::PK,
          'comment' => 'Tag id',
          'ref'     => 'tag.id'
        ],
        'created_at' => [
          'type'    => Base::CREATED,
          'comment' => 'Row creation date'
        ]
    ];

    parent::load($table_name, $model);
  }
}
