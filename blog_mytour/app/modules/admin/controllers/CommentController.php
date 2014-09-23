<?php namespace App\Modules\Admin\Controllers;

use Input, Redirect, View, Auth;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\Madmin;
use App\Modules\Admin\Models\Notify;

class CommentController extends \BaseController
{

	public function index()
	{
		$data = Comment::getComAllJoinPaging(array(), 10, 'com_date_created', 'desc');
		$dataCom = $data->toArray();
		return View::make('admin::comment.index', array('dataCom' => $dataCom['data'], 'dataPaging' => $data));
	}

	public function delete($id){
		$id = explode(',', $id);
		$result = Comment::deleteComWhere('com_id', $id);
		if($result){
			//delete Notify of User
			$rsNotify = Notify::deleteNotifyWhere('not_com_id', $id);
			return Redirect::route('com.comment');
		}
	}
/*
	public function loadDatatable(){
		// DB table to use
		$table = 'comment';

		// Table's primary key
		$primaryKey = 'comment.com_id';

		// Join condition
		$myJoin = "LEFT JOIN `article` ON `article`.`art_id` = `comment`.`com_art_id` LEFT JOIN `users` ON `users`.`id` = `comment`.`com_usr_id`";


		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
		$columns = array(
			array( 'db' => '`comment`.`com_id`', 'dt' => 2 ),
			array( 'db' => '`article`.`art_title`', 'dt' => 3 ),
			array( 'db' => '`users`.`username`',  'dt' => 4 ),
			array( 'db' => '`comment`.`com_detail`',   'dt' => 5 ),
			array(
				'db'        => '`comment`.`com_date_created`',
				'dt'        => 6,
				'formatter' => function( $d, $row ) {
					return date( 'd/m/Y H:i:s', $d);
				}
			),
			array('db' => '`comment`.`com_is_approved`', 'dt' => 7)
		);

		// SQL server connection information
		$sql_details = array(
			'user' => \Config::get('database.connections.mysql.username'),
			'pass' => \Config::get('database.connections.mysql.password'),
			'db'   => \Config::get('database.connections.mysql.database'),
			'host' => \Config::get('database.connections.mysql.host')
		);

		require(dirname(__FILE__).'/../../../controllers/SSP.php');

		echo json_encode(
			\SSP::simpleJoin( $_GET, $sql_details, $table, $primaryKey, $columns, $myJoin, "")
		);
	}*/
}