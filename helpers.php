<?php

function UPDATE($table_name, $form_data, $where_clause = '', $debug = false)
{
    global $connection;
    global $useMySQL;
    $whereSQL = '';
    if (!empty($where_clause)) {
        if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
            $whereSQL = " WHERE " . $where_clause;
        } else {
            $whereSQL = " " . trim($where_clause);
        }
    }
    $sql = "UPDATE " . $table_name . " SET ";
    $sets = array();
    foreach ($form_data as $column => $value) {
        $sets[] = "`" . $column . "` = '" . $value . "'";
    }
    $sql .= implode(', ', $sets);
    $sql .= $whereSQL;

    // return mysqli_query($connection, $sql);
    // echo '<pre>'.$sql.'</pre>';

    //SI DEBUG MODE
    if ($debug) {
        //PRINT ONLY THE QUERY
        echo $sql . '<br>';
    } else {
        //RUN QUERY
        return $useMySQL ? mysqli_query($connection, $sql) : sqlite_query($connection, $sql);
    }
}
function SELECT($table_name, $select = '*', $where_clause = '', $debug = false)
{
    global $connection;
    global $useMySQL;
    // check for optional where clause
    $whereSQL = '';
    if (!empty($where_clause)) {
        // check to see if the 'where' keyword exists
        // if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {   // not found, add key word
        //     $whereSQL = " WHERE " . $where_clause;
        // } else {
        //     $whereSQL = " " . trim($where_clause);
        // }
        $whereSQL = " " . trim($where_clause);
    }
    // start the actual SQL statement
    $sql = "SELECT " . $select . (!empty($table_name) ? " FROM " . $table_name : '') . " ";
    // append the where statement
    $sql .= $whereSQL;

    //SI DEBUG MODE
    if ($debug) {
        //PRINT ONLY THE QUERY
        echo $sql . '<br>';
    } else {
        //RUN QUERY
        return $useMySQL ? mysqli_query($connection, $sql) : sqlite_query($connection, $sql);
    }
    // run and return the query result
    //return mysqli_query($connection, $sql);
}
function INSERT($table_name, $form_data, $debug = false)
{
    //Login stuffs
    global $connection;
    global $useMySQL;
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);
    // build the query
    $sql = "INSERT INTO " . $table_name . "
    (`" . implode('`,`', $fields) . "`)
    VALUES ('" . implode("','", $form_data) . "')";

    //SI DEBUG MODE
    if ($debug) {
        //PRINT ONLY THE QUERY
        echo $sql . '<br>';
    } else {
        //RUN QUERY
        return $useMySQL ? mysqli_query($connection, $sql) : sqlite_query($connection, $sql);
    }
}
