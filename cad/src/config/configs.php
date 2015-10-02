<?php
/**
 *
 * PHP Version 5.5
 * @category:
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: <nmoller@crosemont.qc.ca>
 * @link http://github.com/nmoller GitHub
 *
 * Voir tests
 * 
 */

namespace cad\config;


class configs {

    /**
     * @param $request_uri On passera la variable $_SERVER['REQUEST_URI'] qu'a le
     * format [virtual_folder]/[path_moodle] ex: dev/admin/cron.php
     */
    public function __construct($request_uri) {
        $this->instance = self::get_instance($request_uri);
    }

    public static function get_instance($request_uri) {
        $comp = explode('/', $request_uri);
        return $comp[0];
    }

    public function set_configs(&$CFG) {
        // Ce sera le bon fils de configurator avec les paramètres pour l'instance
        // correspondante.
        $config = 'cad\config\Conf_' . $this->instance;
        if (class_exists($config)) {

            $c = new $config;
            $CFG = $c->instanceCFG($CFG);
            return $CFG;
        }
        else {
            echo $config;
            die('Bad configuration file');
        }
    }

}

/**
 * Class configurator
 * @package cad\config
 *
 * Il faut définir les valeur de confs pour que ce soit possible de l'instancier.
 * Cela nous permet de changer un switch à modifier à chaque cas par l'utilisation
 * du polymorphisme.
 *
 */
abstract class configurator {
    /**
     * @var array Ce sont les variables que l'on va adapter selon l'instance.
     * On pourrait vouloir changer aussi dbuser ....
     */
    private $confs = array(
        'dbname',
        'wwwroot',
        'dataroot'
    );
    private $instance_confs;

    public function __construct(array $values){
        foreach ($this->confs as $key) {
            if (!array_key_exists($key, $values)) {
                throw new \DomainException('You are not passing the right parameters!');
            }
        }
        $this->instance_confs = $values;
    }

    /**
     * On enrichie la variable $CFG avec les paramètres propres à l'instance.
     * @param $CFG
     * @return mixed
     */
    public function instanceCFG(&$CFG) {

        foreach ($this->confs as $key) {
            $CFG->$key = $this->instance_confs[$key];
        }
        return $CFG;
    }
}


class Conf_dev extends configurator {
    const BASE = 'http://moodle.dev/';

    public function __construct() {
        parent::__construct(array(
            'dbname' => 'moodle_dev',
            'wwwroot' => self::BASE . 'dev',
            'dataroot' => '/var/www/html/moodledata'
        ));
    }

}
