<?php



function db_open(){

    $db = mysqli_connect(
        'localhost',
        'root',
        '',
        'agenda'
    );

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    return $db;
}

function db_close($db){
    mysqli_close($db);
}

// instrucción para insertar de forma segura, de manera de evitar sqlinjection

// 1.- 
// $sql = sprintf(
//     "insert into table (col1, col2) values ('%s', '%s')",
//     mysqli_real_escape_string($db, 'valu1 '),
//     mysqli_real_escape_string($db, 'valu2 ')    
// );
// myslqi_query($db, $sql);


// 2.- 
// $stmt = mysqli_prepare(
//     $db,
//     "insert into table (col1, col2) values (?, ?)"
// );
// mysqli_stmt_bind_param($stmt,'ss',$value1, $value2); // el ss significa que tanto el primer como el segundo parametro son strings.
// mysqli_stmt_execute($stmt);

?>