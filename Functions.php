<?php
 
/* The line of codes in here are broken downdown into 
   Smaller chunks to perfom similar tasks.
  For better understanding read the readme file attached.
*/


//Database connection is needed 


function query($pdo,$sql,$param=[]){
    
    $query=$pdo->prepare($sql);

    $query->execute($param); 

    return $query;
 
}


function totalCount($pdo){

    $result=query($pdo,"SELECT COUNT(*) FROM Joke");
    
    $rows= $result->fetch();
    
    return $rows[0];
}

function insert($pdo,$fields ) {
    
    $query = 'INSERT INTO `tableName` (';

    foreach ($fields as $key => $value) {
        $query .= '`' . $key . '`,';
    }

    $query = rtrim($query, ',');

    $query .= ') VALUES (';

    foreach ($fields as $key => $value) {
        $query .= ':' . $key . ',';
    }

    $query = rtrim($query, ',');
    $query .= ')';

    foreach ($fields as $key => $value) {

        if ($value instanceof DateTime) {

            $fields[$key] = $value->format('Y-m-d');
        }
     }
    query($pdo, $query, $fields);
    
}


function update($pdo, $fields){

  $query = ' UPDATE `tableName` SET ';

  foreach ($fields as $key => $value) {

      $query .= '`' . $key . '` = :' . $key . ',';

  }

  $query = rtrim($query, ',');

  $query .= ' WHERE `id` = :primaryKey';

 // Set the :primaryKey variable

 $fields['primaryKey'] = $fields['id'];

 query($pdo, $query, $fields);

}


function get_items_id($pdo, $id) {
  
  $param = [':id' => $id];
 
  $query = query($pdo, 'SELECT * FROM `tableName`
  WHERE `id` = :id', $param);

  return $query->fetch();

}


function deleteItem($pdo, $id){

  $param=['id' => $id];

  $query=query($pdo, 'DELETE FROM `tableName` WHERE `id` = :id',$param);

  return $query->fetch();
}


function showItems($pdo){

  $sql=query($pdo,"SELECT  `Column1`,`columnName2` FROM `tableName`");
  
  return $sql->fetchAll();
}


