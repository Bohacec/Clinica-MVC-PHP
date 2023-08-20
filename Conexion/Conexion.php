<?php
class Conexion extends PDO
{

    private $tipo_de_base;
    private $host;
    private $usuario;
    private $pws;
    private $db;
    private $puerto;
    private $conexion_db;
    private $dsn;

    public function __construct()
    {
        $this->tipo_de_base = 'mysql';
        $this->host = "localhost";
        $this->usuario = "root";
        $this->pws = "";
        $this->db = "clinica";
        $this->puerto = "3306";
        $this->conexion_db = null;
        $this->dsn = null;
    }

    /**
     * Metodo para Establecer una conexion con
     * autocommit desactivado. Se complementa
     * con el metodo cerrarConexion, ambos se
     * usan para mantener integridad en la base
     * de datos.-
     * TODO LO QUE SE ABRRE SE TIENE QUE CERRAR
     * @return boolean
     */
    public function abrirConexion()
    {
        /* Iniciar una transacción, desactivando 'autocommit' */
        $ok = false;
        try {
            $dsn = $this->getTipo_de_base() . ":host=" . $this->getHost() . ";dbname=" . $this->getDb();
            parent::__construct($dsn, $this->getUsuario(), $this->getPws());
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            parent::setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
            $this->setDsn($dsn);
            $this->beginTransaction();
            $ok = true;
        } catch (Exception $exPhp) {
            echo 'Error:' . $exPhp->getMessage();
        } catch (PDOException $exPhpPDO) {
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $exPhpPDO->getMessage();
        } finally {
            return $ok;
        }
    }

    public function abrirConexionList()
    {
        /* Iniciar una transacción, desactivando 'autocommit' */
        $ok = false;
        try {
            $dsn = $this->getTipo_de_base() . ":host=" . $this->getHost() . ";dbname=" . $this->getDb();
            parent::__construct($dsn, $this->getUsuario(), $this->getPws());
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            parent::setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

            $this->setDsn($dsn);

            $ok = true;
        } catch (Exception $exPhp) {
            echo 'Error:' . $exPhp->getMessage();
        } catch (PDOException $exPhpPDO) {
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $exPhpPDO->getMessage();
        } finally {
            return $ok;
        }
    }

    public function cerrarConexion()
    {
        /* Consignar los cambios */
        $ok = false;
        try {
            $this->commit();
            $ok = true;
        } catch (Exception $exPhp) {
            //Si hay algun Error Retroceder
            try {
                $this->rollBack();
            } catch (PDOException $rollExcep) {
                echo 'Error RollBack:' . $rollExcep->getMessage();
            }
        } finally {
            return $ok;
        }
    }

    public function retrocederConexion()
    {
        $ok = false;
        try {
            $this->rollBack();
            $ok = true;
        } catch (Exception $exPhp) {
        } finally {
            return $ok;
        }
    }


    function getTipo_de_base()
    {
        return $this->tipo_de_base;
    }

    function setTipo_de_base($tipo_de_base)
    {
        $this->tipo_de_base = $tipo_de_base;
    }

    function getHost()
    {
        return $this->host;
    }

    function getUsuario()
    {
        return $this->usuario;
    }

    function getPws()
    {
        return $this->pws;
    }

    function getDb()
    {
        return $this->db;
    }

    function getConexion_db()
    {
        return $this->conexion_db;
    }

    function getDsn()
    {
        return $this->dsn;
    }

    function setHost($host)
    {
        $this->host = $host;
    }

    function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    function setPws($pws)
    {
        $this->pws = $pws;
    }

    function setDb($db)
    {
        $this->db = $db;
    }

    function getPuerto()
    {
        return $this->puerto;
    }

    function setPuerto($puerto)
    {
        $this->puerto = $puerto;
    }

    function setConexion_db($conexion_db)
    {
        $this->conexion_db = $conexion_db;
    }

    function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }
}