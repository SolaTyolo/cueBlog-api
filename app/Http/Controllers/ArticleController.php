<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
	/**
	 * 获取文章列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getList( Request $request )
    {
        $page = $request->input('page' , 1);
        $pageSize = $request->input( 'pageSize' , 20 );
        
        $count = DB::select( "select COUNT(*) from articles "  )[0];
        
        
        $sql = <<< SQL
SELECT title , createTime , gist ,labels
FROM `articles`
ORDER BY createTime
LIMIT {$pageSize} OFFSET { ( $page - 1 ) * $pageSize }
SQL;
        $list = DB::select( $sql );
        
        return response()->json( [ 'count' => $count , 'list' => $list ] );
    }
    
	/**
	 * 获取文章详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getDetail( $id )
    {
	    $sql = <<< SQL
SELECT title , createTime , content , gist ,labels
FROM `articles`
WHERE articleId = {$id}
ORDER BY createTime
SQL;
	    $result = DB::select( $sql )[0];
	
	    return response()->json( $result );
	
    }
}
