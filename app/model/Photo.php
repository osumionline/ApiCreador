<?php
class Photo extends OBase{
  function __construct(){
    $table_name  = 'photo';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Unique id for every picture'
        ],
        'id_user' => [
          'type'    => Base::NUM,
          'comment' => 'Id of the user owner of the photo',
          'ref'     => 'user.id'
        ],
        'ext' => [
          'type'    => Base::TEXT,
          'size'    => 5,
          'comment' => 'File extension'
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
    return $this->get('id').'.'.$this->get('ext');
  }
  
  private $tags = null;
  
  public function setTags($tags){
    $this->tags = $tags;
  }
  
  public function getTags(){
    if (is_null($this->tags)){
      $this->loadTags();
    }
    return $this->tags;
  }
  
  private function loadTags(){
    $list = [];
    $sql = sprintf( "SELECT * FROM `tag` WHERE `id` IN (SELECT `id_tag` FROM `photo_tag` WHERE `id_photo` = %s)", $this->get('id') );
    $this->db->query($sql);

    while($res=$this->db->next()){
      $tag = new Tag();
      $tag->update($res);

      array_push($list, $tag);
    }

    $this->tags = $list;
  }
}
