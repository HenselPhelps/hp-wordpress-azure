<?php

/**
 * Class FMModelSelect_data_from_db
 */
class FMModelSelect_data_from_db {
  /**
   * Get labels by form id.
   *
   * @param  int $id
   *
   * @return (string|null) $rows
   */
  function get_labels( $id ) {
    global $wpdb;
    $rows = $wpdb->get_var("SELECT label_order_current FROM " . $wpdb->prefix . "formmaker where id=" . $id);

    return $rows;
  }

  /**
   * Get tables.
   *
   * @return object $tables
   */
  function get_tables() {
    global $wpdb;
    $con_type = $_POST['con_type'];
    if ( $con_type == 'local' ) {
      $query = "SHOW TABLES";
      $tables = $wpdb->get_col($query);
    }
    else {
      if ( $con_type == 'remote' ) {
        $username = WDW_FM_Library::get('username', '');
        $password = WDW_FM_Library::get('password', '');
        $database = WDW_FM_Library::get('database', '');
        $host = WDW_FM_Library::get('host', '');
        $wpdb_temp = new wpdb($username, $password, $database, $host);
        $query = "SHOW TABLES";
        $tables = $wpdb_temp->get_col($query);
      }
    }

    return $tables;
  }

  /**
   * Get tables saved.
   *
   * @param  string $con_type
   * @param  string $username
   * @param  string $password
   * @param  string $database
   * @param  string $host
   *
   * @return object $tables
   */
  function get_tables_saved( $con_type, $username, $password, $database, $host ) {
    global $wpdb;
    if ( $con_type == 'local' ) {
      $query = "SHOW TABLES";
      $tables = $wpdb->get_col($query);
    }
    else {
      if ( $con_type == 'remote' ) {
        $wpdb_temp = new wpdb($username, $password, $database, $host);
        $query = "SHOW TABLES";
        $tables = $wpdb_temp->get_col($query);
      }
    }

    return $tables;
  }

  /**
   * Get table struct.
   *
   * @return object $table_struct
   */
  function get_table_struct() {
    global $wpdb;
    $name = WDW_FM_Library::get('name', NULL);
    if ( !$name ) {
      return array();
    }
    $con_method = WDW_FM_Library::get('con_method', NULL);
    $con_type = WDW_FM_Library::get('con_type', NULL);
    $query = 'SHOW COLUMNS FROM `' . $name . '`';
    if ( $con_type == 'remote' ) {
      $username = WDW_FM_Library::get('username', '');
      $password = WDW_FM_Library::get('password', '');
      $database = WDW_FM_Library::get('database', '');
      $host = WDW_FM_Library::get('host', '');
      $wpdb_temp = new wpdb($username, $password, $database, $host);
      $table_struct = $wpdb_temp->get_results($query);
    }
    else {
      $table_struct = $wpdb->get_results($query);
    }

    return $table_struct;
  }

  /**
   * Get table struct.
   *
   * @param  string $con_type
   * @param  string $username
   * @param  string $password
   * @param  string $database
   * @param  string $host
   * @param  string $name
   * @param  string $con_method
   *
   * @return object $table_struct
   */
  function get_table_struct_saved( $con_type, $username, $password, $database, $host, $name, $con_method ) {
    global $wpdb;
    if ( !$name ) {
      return array();
    }
    $query = 'SHOW COLUMNS FROM `' . $name . '`';
    if ( $con_type == 'remote' ) {
      $wpdb_temp = new wpdb($username, $password, $database, $host);
      $table_struct = $wpdb_temp->get_results($query);
    }
    else {
      $table_struct = $wpdb->get_results($query);
    }

    return $table_struct;
  }
}
