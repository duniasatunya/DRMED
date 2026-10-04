<?php
if(!is_callable('mysql_connect')) {
	
	
define('MYSQL_BOTH',MYSQLI_BOTH);
define('MYSQL_NUM',MYSQLI_NUM);
define('MYSQL_ASSOC',MYSQLI_ASSOC);
define('MYSQL_CLIENT_COMPRESS',MYSQLI_CLIENT_COMPRESS);
define('MYSQL_CLIENT_IGNORE_SPACE',MYSQLI_CLIENT_IGNORE_SPACE);
define('MYSQL_CLIENT_INTERACTIVE',MYSQLI_CLIENT_INTERACTIVE);
define('MYSQL_CLIENT_SSL',MYSQLI_CLIENT_SSL);


  /**
 * @param  resource  $identificativo_connessione
 * @return int
 **/
function mysqli_affected_rows($identificativo_connessione=null){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
 	if(!is_object($identificativo_connessione)) return false;
	return $identificativo_connessione->affected_rows;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return string
 **/
function mysqli_character_set_name($identificativo_connessione=null){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_character_set_name($identificativo_connessione);
}

 /**
 * @param  resource  $identificativo_connessione
 * @return bool
 **/
function ((is_null($___mysqli_res = mysqli_close($identificativo_connessione=null))) ? false : $___mysqli_res){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_close($identificativo_connessione);
}



/**
 * @param  string  $server
 * @param  string  $nome_utente
 * @param  string  $password
 * @param  int  $flag_client
 * @return resource
 **/
function ($GLOBALS["___mysqli_ston"] = mysqli_connect($server='' , $nome_utente='' , $password='' )){
	return mysql_connect($server, $nome_utente, $password, false, $flag_client, 'p:');
}


 /**
 * @param  string  $server  es: 127.0.0.1 or 127.0.0.1:3306 or localhost:/var/run/mysqld/mysqld.sock or :/var/run/mysqld/mysqld.sock  
 * @param  string  $nome_utente
 * @param  string  $password
 * @param  bool  $nuova_connessione
 * @param  int  $client_flags
 * @return resource
 **/
function mysql_connect($server='' , $nome_utente='' , $password='' , $nuova_connessione=false , $client_flags=0, $persistente=''){
	if(func_num_args()===0 && $_SERVER['MYSQL_CONN']) foreach ($_SERVER['MYSQL_CONN'] as $hash=>&$conns) return $conns;
							
	$hash=sha1(serialize(func_get_args()));
	if(!$nuova_connessione && $_SERVER['MYSQL_CONN'][$hash]) return $_SERVER['MYSQL_CONN'][$hash];
	 
	if(!$server)	  $server = ini_get("mysqli.default_host");
	$server=trim($server);
	if(!$nome_utente) $nome_utente = ini_get("mysqli.default_user");
	if(!$password)    $password= ini_get("mysqli.default_pw"); 
	
	$link = mysqli_init();
	
	$socket=null;
	if(strpos($server,':')!==false) list($server,$porta)=explode(':',$server,2);
	                           else $porta=ini_get("mysqli.default_port"); 
    if(!$server) $server='localhost';			  
    if(!is_numeric($porta)) {
	                         $socket=$porta;
	                         $porta=null;
	                         }
	 if(!$porta && $porta!==null) $porta=3306;
	 $ok=@mysqli_real_connect($link,$persistente.$server,$nome_utente,$password,'',$porta,$socket,$client_flags);
	 if(!$ok) return false;
	//print_r(mysqli_connect($persistente.$server,$nome_utente,$password,'',$porta,null,$flags));
	//print_r($link);
   	 $_SERVER['MYSQL_CONN'][$hash]=&$link;
	return $link;		      
}

 /**
 * @param  string  $nome_database
 * @param  resource  $identificativo_connessione
 * @return bool
 **/
function ((is_null($___mysqli_res = mysqli_query($identificativo_connessione=null, "CREATE DATABASE $nome_database"))) ? false : $___mysqli_res){
	 if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	 return !@mysqli_query($identificativo_connessione,"create database `$nome_database`"); 
}

 /**
 * @param  resource  $identificativo_risultato
 * @param  int  $numero_riga
 * @return bool
 **/
function mysqli_data_seek($identificativo_risultato , $numero_riga){
   mysqli_store_result($identificativo_risultato);
   return @mysqli_data_seek( $identificativo_risultato , $numero_riga );
}

 /**
 * @param  resource  $risultato
 * @param  int  $riga
 * @param  mixed  $campo
 * @return string
 **/
function mysql_db_name($risultato , $riga , $campo=null){
	if(!@mysqli_data_seek( $risultato , $riga )) return false;
	$riga = mysqli_fetch_assoc($risultato);
	if(!$campo) return $riga['Database'];
		   else return $riga[$campo];
}

 /**
 * @param  string  $database
 * @param  string  $query
 * @param  resource  $identificativo_connessione
 * @return resource
 **/
function ((mysqli_query($identificativo_connessione=null, "USE $database")) ? mysqli_query($identificativo_connessione=null, $query ) : false){
		if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	    $rs=mysqli_query($identificativo_connessione,"select database()");
		$prec_db=@mysqli_fetch_row ($rs);
		@mysqli_query($identificativo_connessione,"use `$database`",MYSQLI_USE_RESULT);
			$rs=mysqli_query($identificativo_connessione,$query,MYSQLI_STORE_RESULT);
		if(strtolower($prec_db[0])!=strtolower($database)) @mysqli_query($identificativo_connessione,"use `{$prec_db[0]}`",MYSQLI_USE_RESULT);
		return $rs; 
}

 /**
 * @param  string  $nome_database
 * @param  resource  $identificativo_connessione
 * @return bool
 **/
function ((is_null($___mysqli_res = mysqli_query($identificativo_connessione=null, "DROP DATABASE $nome_database"))) ? false : $___mysqli_res){
    if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	  return !@mysqli_query($identificativo_connessione,"drop database `$nome_database`");
}

 /**
 * @param  resource  $identificativo_connessione
 * @return int
 **/
function mysqli_errno($identificativo_connessione=null){
	 if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	 if(!is_object($identificativo_connessione)) return false;
	 return $identificativo_connessione->errno;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return string
 **/
function mysqli_error($identificativo_connessione=null){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	 if(!is_object($identificativo_connessione)) return false;
	 return $identificativo_connessione->error;
}

 /**
 * @param  string  $stringa_senza_escape
 * @return string
 **/
function ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $stringa_senza_escape) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")){
	return @mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $stringa_senza_escape);
}

 /**
 * @param  resource  $risultato
 * @param  int  $tipo_risultato
 * @return array
 **/
function mysqli_fetch_array($risultato , $tipo_risultato=null){
	if($tipo_risultato===null) $tipo_risultato=MYSQLI_BOTH;
	return @mysqli_fetch_array($risultato ,$tipo_risultato);
}

 /**
 * @param  resource  $risultato
 * @return array
 **/
function mysqli_fetch_assoc($risultato){
    return @mysqli_fetch_assoc($risultato);
}

 

 /**
 * @param  resource  $risultato
 * @return array
 **/
function (($___mysqli_tmp = mysqli_fetch_lengths($risultato)) ? $___mysqli_tmp : false){
   return @mysqli_fetch_lengths($risultato);
}

 /**
 * @param  resource  $risultato
 * @return object
 **/
function mysqli_fetch_object($risultato){
   return @mysqli_fetch_object($risultato);
}

 /**
 * @param  resource  $risultato
 * @return array
 **/
function mysqli_fetch_row($risultato){
 return @mysqli_fetch_row ($risultato);
}


 /**
 * @param  resource  $risultato
 * @param  int  $indice_campo
 * @return int
 **/
function (($___mysqli_tmp = mysqli_field_seek($risultato , $indice_campo)) ? $___mysqli_tmp : false){
	return @mysqli_field_seek($risultato ,$indice_campo);
}


 /**
 * @param  resource  $risultato
 * @return bool
 **/
function ((mysqli_free_result($risultato) || (is_object($risultato) && (get_class($risultato) == "mysqli_result"))) ? true : false){
	@mysqli_free_result ($risultato);
}

 /**
 * @return string
 **/
function mysqli_get_client_info(){
     if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
 	 if(!is_object($identificativo_connessione)) return false;
	 return $identificativo_connessione->client_info;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return string
 **/
function ((is_null($___mysqli_res = mysqli_get_host_info($identificativo_connessione=null))) ? false : $___mysqli_res){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
 	if(!is_object($identificativo_connessione)) return false;
	return $identificativo_connessione->host_info;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return int
 **/
function ((is_null($___mysqli_res = mysqli_get_proto_info($identificativo_connessione=null))) ? false : $___mysqli_res){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	if(!is_object($identificativo_connessione)) return false;
	return $identificativo_connessione->protocol_version;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return string
 **/
function ((is_null($___mysqli_res = mysqli_get_server_info($identificativo_connessione=null))) ? false : $___mysqli_res){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	if(!is_object($identificativo_connessione)) return false;
	return $identificativo_connessione->server_info;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return string
 **/
function mysqli_info($identificativo_connessione=null){
	 if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	 if(!is_object($identificativo_connessione)) return false;
	 return $identificativo_connessione->info;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return int
 **/
function ((is_null($___mysqli_res = mysqli_insert_id($identificativo_connessione=null))) ? false : $___mysqli_res){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	if(!is_object($identificativo_connessione)) return false;
	return $identificativo_connessione->insert_id;
}

 /**
 * @param  resource  $identificativo_connessione
 * @return resource
 **/
function (($___mysqli_tmp = mysqli_query($identificativo_connessione=null, "SHOW DATABASES")) ? $___mysqli_tmp : false){
   if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
   $rs=@mysqli_query($identificativo_connessione,'SHOW DATABASES');
   @mysqli_store_result($rs);
   return $rs;
}

 
 /**
 * @param  resource  $risultato
 * @return int
 **/
function (($___mysqli_tmp = mysqli_num_fields($risultato)) ? $___mysqli_tmp : false){
	return @mysqli_num_fields ($risultato);
}

 /**
 * @param  resource  $risultato
 * @return int
 **/
function mysqli_num_rows($risultato){
	return @mysqli_num_rows($risultato);
}



 /**
 * @param  resource  $identificativo_connessione
 * @return bool
 **/
function mysqli_ping($identificativo_connessione=null){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_ping($identificativo_connessione);
}



 /**
 * @param  string  $query
 * @param  resource  $identificativo_connessione
 * @return resource
 **/
function mysqli_query($identificativo_connessione=null, $query ){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_query($identificativo_connessione,$query );
}

 /**
 * @param  string  $stringa_seza_escape
 * @param  resource  $identificativo_connessione
 * @return string
 **/
function mysqli_real_escape_string($identificativo_connessione=null, $stringa_seza_escape ){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_real_escape_string($identificativo_connessione,$stringa_seza_escape);
}


 /**
 * @param  string  $nome_database
 * @param  resource  $identificativo_connessione
 * @return bool
 **/
function mysqli_select_db($identificativo_connessione=null, $nome_database){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_select_db($identificativo_connessione,$nome_database);
}

 /**
 * @param  string  $charset
 * @param  resource  $identificativo_connessione
 * @return bool
 **/
function ((bool)mysqli_set_charset($identificativo_connessione=null, "$charset")){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_set_charset($identificativo_connessione,$charset);
}

 /**
 * @param  resource  $identificativo_connessione
 * @return string
 **/
function mysqli_stat($identificativo_connessione=null){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	if(!is_object($identificativo_connessione)) return false;
	return $identificativo_connessione->stat;

}


 /**
 * @param  resource  $identificativo_connessione
 * @return int
 **/
function mysqli_thread_id($identificativo_connessione=null){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	 if(!is_object($identificativo_connessione)) return false;
	 return $identificativo_connessione->thread_id;
}

 /**
 * @param  string  $query
 * @param  resource  $identificativo_connessione
 * @return resource
 **/
function mysqli_query($identificativo_connessione=null, $query , MYSQLI_USE_RESULT){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
    return @mysqli_query($identificativo_connessione,$query,0);
 }



/**
 * @param  string  $nome_database
 * @param  string  $nome_tabella
 * @param  resource  $identificativo_connessione
 * @return resource
 **/
function (($___mysqli_tmp = mysqli_query($identificativo_connessione=null, "SHOW COLUMNS FROM $nome_database.$nome_tabella")) ? $___mysqli_tmp : false){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_query($identificativo_connessione,"select * FROM `$nome_database`.`$nome_tabella` limit 1");
}

/**
 * @param  resource  $risultato
 * @param  int  $indice_campo
 * @return string
 **/
function ((($___mysqli_tmp = mysqli_fetch_field_direct($risultato , $indice_campo)->name) && (!is_null($___mysqli_tmp))) ? $___mysqli_tmp : false){
	$info=@mysqli_fetch_field_direct($risultato,$indice_campo);
	return $info->name;
}

/**
 * @param  resource  $risultato
 * @param  int  $indice_campo
 * @return string
 **/
function (($___mysqli_tmp = mysqli_fetch_field_direct($risultato , $indice_campo)->flags) ? (string)(substr((($___mysqli_tmp & MYSQLI_NOT_NULL_FLAG)       ? "not_null "       : "") . (($___mysqli_tmp & MYSQLI_PRI_KEY_FLAG)        ? "primary_key "    : "") . (($___mysqli_tmp & MYSQLI_UNIQUE_KEY_FLAG)     ? "unique_key "     : "") . (($___mysqli_tmp & MYSQLI_MULTIPLE_KEY_FLAG)   ? "unique_key "     : "") . (($___mysqli_tmp & MYSQLI_BLOB_FLAG)           ? "blob "           : "") . (($___mysqli_tmp & MYSQLI_UNSIGNED_FLAG)       ? "unsigned "       : "") . (($___mysqli_tmp & MYSQLI_ZEROFILL_FLAG)       ? "zerofill "       : "") . (($___mysqli_tmp & 128)                        ? "binary "         : "") . (($___mysqli_tmp & 256)                        ? "enum "           : "") . (($___mysqli_tmp & MYSQLI_AUTO_INCREMENT_FLAG) ? "auto_increment " : "") . (($___mysqli_tmp & MYSQLI_TIMESTAMP_FLAG)      ? "timestamp "      : "") . (($___mysqli_tmp & MYSQLI_SET_FLAG)            ? "set "            : ""), 0, -1)) : false){
	$info=@mysqli_fetch_field_direct($risultato,$indice_campo);
	return $info->flags;
}


/**
 * @param  resource  $risultato
 * @param  int  $indice_campo
 * @return int
 **/
function ((($___mysqli_tmp = mysqli_fetch_fields($risultato )) && (isset($___mysqli_tmp[0]))) ? $___mysqli_tmp[0]->length : false){
	$info=@mysqli_fetch_field_direct($risultato,$indice_campo);
	return $info->length;
}

/**
 * @param  resource  $risultato
 * @param  int  $indice_campo
 * @return string
 **/
function ((is_object($___mysqli_tmp = mysqli_fetch_field_direct($risultato , 0)) && !is_null($___mysqli_tmp = $___mysqli_tmp->type)) ? ((($___mysqli_tmp = (string)(substr(( (($___mysqli_tmp == MYSQLI_TYPE_STRING) || ($___mysqli_tmp == MYSQLI_TYPE_VAR_STRING) ) ? "string " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_LONG, MYSQLI_TYPE_LONGLONG, MYSQLI_TYPE_INT24))) ? "int " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_FLOAT, MYSQLI_TYPE_DOUBLE, MYSQLI_TYPE_DECIMAL, ((defined("MYSQLI_TYPE_NEWDECIMAL")) ? constant("MYSQLI_TYPE_NEWDECIMAL") : -1)))) ? "real " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_TIMESTAMP) ? "timestamp " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_YEAR) ? "year " : "" ) . ( (($___mysqli_tmp == MYSQLI_TYPE_DATE) || ($___mysqli_tmp == MYSQLI_TYPE_NEWDATE) ) ? "date " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_TIME) ? "time " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_SET) ? "set " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_ENUM) ? "enum " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_GEOMETRY) ? "geometry " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_DATETIME) ? "datetime " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_TINY_BLOB, MYSQLI_TYPE_BLOB, MYSQLI_TYPE_MEDIUM_BLOB, MYSQLI_TYPE_LONG_BLOB))) ? "blob " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_NULL) ? "null " : "" ), 0, -1))) == "") ? "unknown" : $___mysqli_tmp) : false){
	$info=@(((($___mysqli_tmp = mysqli_fetch_field_direct($risultato, 0)) && is_object($___mysqli_tmp)) ? ( (!is_null($___mysqli_tmp->primary_key = ($___mysqli_tmp->flags & MYSQLI_PRI_KEY_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->multiple_key = ($___mysqli_tmp->flags & MYSQLI_MULTIPLE_KEY_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->unique_key = ($___mysqli_tmp->flags & MYSQLI_UNIQUE_KEY_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->numeric = (int)(($___mysqli_tmp->type <= MYSQLI_TYPE_INT24) || ($___mysqli_tmp->type == MYSQLI_TYPE_YEAR) || ((defined("MYSQLI_TYPE_NEWDECIMAL")) ? ($___mysqli_tmp->type == MYSQLI_TYPE_NEWDECIMAL) : 0)))) && (!is_null($___mysqli_tmp->blob = (int)in_array($___mysqli_tmp->type, array(MYSQLI_TYPE_TINY_BLOB, MYSQLI_TYPE_BLOB, MYSQLI_TYPE_MEDIUM_BLOB, MYSQLI_TYPE_LONG_BLOB)))) && (!is_null($___mysqli_tmp->unsigned = ($___mysqli_tmp->flags & MYSQLI_UNSIGNED_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->zerofill = ($___mysqli_tmp->flags & MYSQLI_ZEROFILL_FLAG) ? 1 : 0)) && (!is_null($___mysqli_type = $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = (($___mysqli_type == MYSQLI_TYPE_STRING) || ($___mysqli_type == MYSQLI_TYPE_VAR_STRING)) ? "type" : "")) &&(!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && in_array($___mysqli_type, array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_LONG, MYSQLI_TYPE_LONGLONG, MYSQLI_TYPE_INT24))) ? "int" : $___mysqli_tmp->type)) &&(!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && in_array($___mysqli_type, array(MYSQLI_TYPE_FLOAT, MYSQLI_TYPE_DOUBLE, MYSQLI_TYPE_DECIMAL, ((defined("MYSQLI_TYPE_NEWDECIMAL")) ? constant("MYSQLI_TYPE_NEWDECIMAL") : -1)))) ? "real" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_TIMESTAMP) ? "timestamp" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_YEAR) ? "year" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && (($___mysqli_type == MYSQLI_TYPE_DATE) || ($___mysqli_type == MYSQLI_TYPE_NEWDATE))) ? "date " : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_TIME) ? "time" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_SET) ? "set" : $___mysqli_tmp->type)) &&(!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_ENUM) ? "enum" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_GEOMETRY) ? "geometry" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_DATETIME) ? "datetime" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && (in_array($___mysqli_type, array(MYSQLI_TYPE_TINY_BLOB, MYSQLI_TYPE_BLOB, MYSQLI_TYPE_MEDIUM_BLOB, MYSQLI_TYPE_LONG_BLOB)))) ? "blob" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_NULL) ? "null" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type) ? "unknown" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->not_null = ($___mysqli_tmp->flags & MYSQLI_NOT_NULL_FLAG) ? 1 : 0)) ) : false ) ? $___mysqli_tmp : false);//necessario perch� type in mysqli � numerico
	return $info->type;
}


/**
 * @param  resource  $risultato
 * @param  int  $indice_campo
 * @return string
 **/
function (mysqli_fetch_field_direct($risultato , $indice_campo)->table){
	$info=@mysqli_fetch_field_direct($risultato,$indice_campo);
	return $info->table;
}


/**
 * @param  resource  $identificativo_connessione
 * @return resource
 **/
function mysqli_query($identificativo_connessione=null, "SHOW PROCESSLIST"){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_query($identificativo_connessione,"show processlist",MYSQLI_STORE_RESULT);
}

/**     
 * @param  string  $database
 * @param  resource  $identificativoi_connessione
 * @return resource
 **/
function mysqli_query($identificativo_connessione=null, "SHOW TABLES FROM `$database`"){
	if(!$identificativo_connessione) $identificativo_connessione=($GLOBALS["___mysqli_ston"] = mysqli_connect());
	return @mysqli_query($identificativo_connessione,"SHOW TABLES",MYSQLI_STORE_RESULT);

}


/**
 * @param  resource  $risultato
 * @param  int  $i
 * @return string
 **/
function ((mysqli_data_seek($risultato , $i) && (($___mysqli_tmp = mysqli_fetch_row($risultato )) !== NULL)) ? array_shift($___mysqli_tmp) : false){
	@mysqli_data_seek($risultato,$i);
	$row=@mysqli_fetch_row($risultato);
	return $row[0];
}



/**
 * @param  resource  $risultato
 * @param  int  $campo
 * @param  mixed  $campo
 * @return mixed
 **/
function mysqli_result($risultato , $riga , $colonna=null){
	$esito=@mysqli_data_seek($risultato,$riga);
	if(!$esito && $colonna!==null) return @mysqli_field_seek($risultato,$colonna);
	return $esito;
}

/**
 * @param  resource  $risultato
 * @param  int  $indice_campo
 * @return object
 **/
function (((($___mysqli_tmp = mysqli_fetch_field_direct($risultato , 0)) && is_object($___mysqli_tmp)) ? ( (!is_null($___mysqli_tmp->primary_key = ($___mysqli_tmp->flags & MYSQLI_PRI_KEY_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->multiple_key = ($___mysqli_tmp->flags & MYSQLI_MULTIPLE_KEY_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->unique_key = ($___mysqli_tmp->flags & MYSQLI_UNIQUE_KEY_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->numeric = (int)(($___mysqli_tmp->type <= MYSQLI_TYPE_INT24) || ($___mysqli_tmp->type == MYSQLI_TYPE_YEAR) || ((defined("MYSQLI_TYPE_NEWDECIMAL")) ? ($___mysqli_tmp->type == MYSQLI_TYPE_NEWDECIMAL) : 0)))) && (!is_null($___mysqli_tmp->blob = (int)in_array($___mysqli_tmp->type, array(MYSQLI_TYPE_TINY_BLOB, MYSQLI_TYPE_BLOB, MYSQLI_TYPE_MEDIUM_BLOB, MYSQLI_TYPE_LONG_BLOB)))) && (!is_null($___mysqli_tmp->unsigned = ($___mysqli_tmp->flags & MYSQLI_UNSIGNED_FLAG) ? 1 : 0)) && (!is_null($___mysqli_tmp->zerofill = ($___mysqli_tmp->flags & MYSQLI_ZEROFILL_FLAG) ? 1 : 0)) && (!is_null($___mysqli_type = $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = (($___mysqli_type == MYSQLI_TYPE_STRING) || ($___mysqli_type == MYSQLI_TYPE_VAR_STRING)) ? "type" : "")) &&(!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && in_array($___mysqli_type, array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_LONG, MYSQLI_TYPE_LONGLONG, MYSQLI_TYPE_INT24))) ? "int" : $___mysqli_tmp->type)) &&(!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && in_array($___mysqli_type, array(MYSQLI_TYPE_FLOAT, MYSQLI_TYPE_DOUBLE, MYSQLI_TYPE_DECIMAL, ((defined("MYSQLI_TYPE_NEWDECIMAL")) ? constant("MYSQLI_TYPE_NEWDECIMAL") : -1)))) ? "real" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_TIMESTAMP) ? "timestamp" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_YEAR) ? "year" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && (($___mysqli_type == MYSQLI_TYPE_DATE) || ($___mysqli_type == MYSQLI_TYPE_NEWDATE))) ? "date " : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_TIME) ? "time" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_SET) ? "set" : $___mysqli_tmp->type)) &&(!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_ENUM) ? "enum" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_GEOMETRY) ? "geometry" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_DATETIME) ? "datetime" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && (in_array($___mysqli_type, array(MYSQLI_TYPE_TINY_BLOB, MYSQLI_TYPE_BLOB, MYSQLI_TYPE_MEDIUM_BLOB, MYSQLI_TYPE_LONG_BLOB)))) ? "blob" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type && $___mysqli_type == MYSQLI_TYPE_NULL) ? "null" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->type = ("" == $___mysqli_tmp->type) ? "unknown" : $___mysqli_tmp->type)) && (!is_null($___mysqli_tmp->not_null = ($___mysqli_tmp->flags & MYSQLI_NOT_NULL_FLAG) ? 1 : 0)) ) : false ) ? $___mysqli_tmp : false){
	
	mysqli_field_seek($risultato, $indice_campo);
	$info=mysqli_fetch_field($risultato);
	
	$out=new stdclass();
	$out->name=$info->name;
	$out->table=$info->table;
	$out->def='';
	$out->max_length=$info->max_length;
	$infos=array();
	if($info->orgtable && $info->db && $info->orgname ) {
		$rs=mysqli_query(($GLOBALS["___mysqli_ston"] = mysqli_connect()),"select is_nullable,column_key,numeric_precision,column_type
		                                      	from `information_schema`.`COLUMNS` where
			                                     table_schema='{$info->db}' and
			                                     table_name='{$info->orgtable}' and
		                                       	 column_name='{$info->orgname}' limit 1");
		$infos=mysqli_fetch_assoc($rs);
	}	
			
	$out->not_null=($infos['is_nullable']=='YES'?0:1);
	$out->primary_key=($infos['column_key']=='PRI'?1:0);
	$out->multiple_key=($infos['column_key']=='MUL'?1:0);
	$out->unique_key=($infos['column_key']=='UNI'?1:0);
	$out->numeric=($infos['numeric_precision']>0?1:0);
	$out->blob=intval(preg_match('/blob$/',$infos['column_type']));
	$out->type=$info->type;
	$out->unsigned=intval(stripos(" {$infos['column_type']} ",' unsigned ')!==false);
	$out->zerofill=intval(stripos(" {$infos['column_type']} ",' zerofill ')!==false);
	switch ($info->type){
		  case 4:
		  case 5:
		  case 246:$out->type='real';break;
		  case 7:$out->type='timestamp';
		  		 $out->unsigned=1;
		 		 $out->zerofill=1;
		 		 break;
		 case 10:$out->type='date';break;
		 case 11:$out->type='time';break;
		 case 12:$out->type='datetime';break;
		 case 13:$out->type='year';
		 		 $out->unsigned=1;
		 		 $out->zerofill=1;
		 		break;
		 case 16:$out->numeric=0;
		 		 $out->unsigned=1;
		 		 $out->zerofill=0;
		 		 $out->type='int';
		 		 break;	
		 case 255:$out->type='geometry';
		 		 $out->blob=1;
		 		 break;
		case 252:$out->type='blob';
				 $out->blob=1;
				 break;
		case 253:
		case 254:$out->type='string';break;
	}
	return $out;
}


}
?>