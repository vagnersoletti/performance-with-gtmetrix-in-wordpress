<?php
/**
 * Create list info GTmetrix
 *
 * @package Performance with GTmetrix in WordPress
 */


if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class List_Table extends WP_List_Table {
   
    function __construct(){
        global $status, $page;
        include_once WP_PLUGIN_DIR.'/performance-with-gtmetrix-in-wp/functions/function.php';

        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'gtmetrix',     //singular name of the listed records
            'plural'    => 'gtmetrix',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function extra_tablenav( $which ) {
        if ( $which == "top" ){
            echo '';
        }
    }

    function column_default($item, $column_name){
        switch($column_name){
            case 'pagespeed':
            return '<div class="loading">
                        <div class="loader grid-score-grade background-grade-'.score_to_grade($item[$column_name]).'" style="width:'.$item[$column_name].'%;">'.score_to_grade($item[$column_name]) .' ('. $item[$column_name].')'.'</div>
                    </div>';
            case 'yslow':
            return '<div class="loading">
                        <div class="loader grid-score-grade background-grade-'.score_to_grade($item[$column_name]).'" style="width:'.$item[$column_name].'%;">'.score_to_grade($item[$column_name]) .' ('. $item[$column_name].')'.'</div>
                    </div>';
            case 'fullloadedtime':
            case 'totalpagesize':
            case 'requests':
                return $item[$column_name];
            case 'created_at':
                // return print_r(date( 'd/m/Y', strtotime($item[$column_name])));
                return sprintf(date( 'd/m/Y', strtotime($item[$column_name]))) . ' às ' . sprintf(date( 'g:i A', strtotime($item[$column_name])));
            case 'linkreportfull':
                return sprintf("<a href='".$item[$column_name]."' target='_blank'>Relatório Completo</a>", true);
            default:
                return sprintf($item,true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_title($item){
        
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&gtmetrix=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&gtmetrix=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item['pagespeed'],
            /*$2%s*/ $item['id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }

    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
        );
    }

    function get_columns(){
        $columns = array(
            'cb'                => '<input type="checkbox" />', //Render a checkbox instead of text
            'pagespeed'         => 'PageSpeed Score',
            'yslow'             => 'YSlow Score',
            'fullloadedtime'    => 'Fully Loaded Time (s)',
            'totalpagesize'     => 'Total Page Size (MB)',
            'requests'          => 'Requests',
            'created_at'        => 'Data/hora',
            'linkreportfull'    => 'Rel. Completo'
            
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'pagespeed'         => array('pagespeed', false),
            'yslow'             => array('yslow', false),
            'fullloadedtime'    => array('fullloadedtime', false),
            'totalpagesize'     => array('totalpagesize', false),
            'requests'          => array('requests', false),
            'created_at'        => array('created_at', false),
            'linkreportfull'    => array('linkreportfull', false)
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            // 'delete'    => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        // if( 'delete'===$this->current_action() ) {
        //     wp_die('Items deleted (or they would be if we had items to delete)!');
        // }
        
    }

    function prepare_items() {
        global $wpdb;

        $query = "SELECT * FROM $wpdb->prefix" . "gtmetrix_log" ;
        $values = $wpdb->get_results($query, $output = ARRAY_A);


        $per_page = 20;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();
        $data = $values;

        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'created_at'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');

        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }


}