<?php

/*========================================================================
*   Open eClass 2.3
*   E-learning and Course Management System
* ========================================================================
*  Copyright(c) 2003-2010  Greek Universities Network - GUnet
*  A full copyright notice can be read in "/info/copyright.txt".
*
*  Developers Group:	Costas Tsibanis <k.tsibanis@noc.uoa.gr>
*			Yannis Exidaridis <jexi@noc.uoa.gr>
*			Alexandros Diamantidis <adia@noc.uoa.gr>
*			Tilemachos Raptis <traptis@noc.uoa.gr>
*
*  For a full list of contributors, see "credits.txt".
*
*  Open eClass is an open platform distributed in the hope that it will
*  be useful (without any warranty), under the terms of the GNU (General
*  Public License) as published by the Free Software Foundation.
*  The full license can be read in "/info/license/license_gpl.txt".
*
*  Contact address: 	GUnet Asynchronous eLearning Group,
*  			Network Operations Center, University of Athens,
*  			Panepistimiopolis Ilissia, 15784, Athens, Greece
*  			eMail: info@openeclass.org
* =========================================================================*/

/**===========================================================================
	class.dbconnection.php
	@last update: 15-05-2007 by Thanos Kyritsis
	@authors list: Thanos Kyritsis <atkyritsis@upnet.gr>
	               
	based on Claroline version 1.7.9 licensed under GPL
	      copyright (c) 2001, 2007 Universite catholique de Louvain (UCL)
	      
	      original file: class.dbconnection Revision: 1.6.2.2
	      
	Claroline authors: Frederic Minne <zefredz@gmail.com>
==============================================================================        
    @Description: 

    @Comments:
 
    @todo: 
==============================================================================
*/

    class DatabaseConnection
    {
        var $error = '';
        var $errno = 0;
        var $connected = false;
        
        function setError( $errmsg = '', $errno = 0 )
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }

        function getError()
        {
            if ( $this->error != '' )
            {
                $errno = $this->errno;
                $error = $this->error;
                $this->error = '';
                $this->errno = 0;
                return $errno.' - '.$error;
            }
            else
            {
                return false;
            }
        }

        function hasError()
        {
            return ( $this->error != '' );
        }
        
        function connect()
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }
        
        function isConnected()
        {
            return $this->connected;
        }
        
        function close()
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }

        function executeQuery( $sql )
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }

        function getAllObjectsFromQuery( $sql )
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }

        function getObjectFromQuery( $sql )
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }

        function getAllRowsFromQuery( $sql )
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }

        function getRowFromQuery( $sql )
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }
        
        function queryReturnsResult( $sql )
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }

        function getLastInsertID()
        {
            trigger_error( "Call to undefined abstract method in "
                . __CLASS__ . "->" . __FUNCTION__
                , E_USER_ERROR
                );
        }
    }
    
    class MyDatabaseConnection extends DatabaseConnection
    {
        var $db_link;
        var $host;
        var $username;
        var $passwd;
        var $dbname;
        
        function MyDatabaseConnection( $host, $username, $passwd, $dbname )
        {
            $this->db_link = null;
            $this->host = $host;
            $this->username = $username;
            $this->passwd = $passwd;
            $this->dbname = $dbname;
        }
        
        function setError( $errmsg = '', $errno = 0 )
        {
            if ( $errmsg != '' )
            {
                $this->error = $errmsg;
                $this->errno = $errno;
            }
            else
            {
                $this->error = ( @mysql_error() !== false ) ? @mysql_error() : 'Unknown error';
                $this->errno = ( @mysql_errno() !== false ) ? @mysql_errno() : 0;
            }
            
            $this->connected = false;
        }
        
        function connect()
        {
            global $db;

            $this->db_link = @mysql_connect( $this->host, $this->username, $this->passwd );

            if( ! $this->db_link )
            {
                $this->setError();
                
                return false;
            }

            if( @mysql_select_db($db, $this->dbname, $this->db_link ) )
            {
                $this->connected = true;
                return true;
            }
            else
            {
                $this->setError();
                
                return false;
            }
        }
        
        function close()
        {
            if( $this->db_link != false )
            {
                @mysql_close( $this->db_link );
            }
            else
            {
                $this->setError( "No connection found" );
            }
            $this->connected = false;
        }
        
        function executeQuery( $sql )
        {
            global $db;
            db_query( $sql, $this->db_link );
            
            if( @mysql_errno( $this->db_link ) != 0 )
            {
                $this->setError();
                
                return 0;
            }

            return @mysqli_affected_rows($db );
        }

        function getAllObjectsFromQuery( $sql )
        {
            $result = db_query( $sql, $this->db_link );

            if ( @mysqli_num_rows( $result ) > 0 )
            {
                $ret= array();

                while( ( $item = @mysql_fetch_object( $result ) ) != false )
                {
                    $ret[] = $item;
                }
            }
            else
            {
                $this->setError();
                
                @mysqli_free_result( $result );
                
                return null;
            }

            @mysqli_free_result( $result );

            return $ret;
        }

        function getObjectFromQuery( $sql )
        {
            $result = db_query( $sql, $this->db_link );

            if ( ( $item = @mysql_fetch_object( $result ) ) != false )
            {
                @mysqli_free_result( $result );
                
                return $item;
            }
            else
            {
                $this->setError();

                @mysqli_free_result( $result );
                return null;
            }
        }
        
        function getAllRowsFromQuery( $sql )
        {
            $result = db_query( $sql, $this->db_link );

            if ( @mysqli_num_rows( $result ) > 0 )
            {
                $ret= array();

                while ( ( $item = @mysqli_fetch_array( $result ) ) != false )
                {
                    $ret[] = $item;
                }
            }
            else
            {
                $this->setError();

                @mysqli_free_result( $result );
                
                return null;
            }

            @mysqli_free_result( $result );

            return $ret;
        }

        function getRowFromQuery( $sql )
        {
            $result = db_query( $sql, $this->db_link );

            if ( ( $item = @mysqli_fetch_array( $result ) ) != false )
            {
                @mysqli_free_result( $result );
                
                return $item;
            }
            else
            {
                $this->setError();

                @mysqli_free_result( $result );
                
                return null;
            }
        }
        
        function queryReturnsResult( $sql )
        {
            $result = db_query( $sql, $this->db_link );
            
            if ( @mysql_errno( $this->db_link ) == 0 )
            {

                if ( @mysqli_num_rows( $result ) > 0 )
                {
                    @mysqli_free_result( $result );

                    return true;
                }
                else
                {
                    @mysqli_free_result( $result );

                    return false;
                }
            }
            else
            {
                $this->setError();
                
                return false;
            }
        }

        function getLastInsertID()
        {
            global $db;
            if ( $this->hasError() )
            {
                return 0;
            }
            else
            {
                return mysqli_insert_id( );
            }
        }
    }
?>
