<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Multidatabase
{

        public function __construct()
        {
                $this->load();
        }

        /**
         * Load the databases and ignore the old ordinary CI loader which only allows one
         */
        public function load()
        {
                $CI = &get_instance();

                $CI->db             = $CI->load->database('default', TRUE);
                $CI->db_holding    	= $CI->load->database('db_holding', TRUE);
                $CI->db_wuling      = $CI->load->database('db_wuling', TRUE);
                $CI->db_wuling_sp   = $CI->load->database('db_wuling_sp', TRUE);
                $CI->db_wuling_as   = $CI->load->database('db_wuling_as', TRUE);
                $CI->kumalagroup    = $CI->load->database('kumalagroup', TRUE);
        }

        // Add more functions two use commonly.
        public function save()
        {
        }
}
